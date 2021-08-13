<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Users;
use App\Models\Addresses;
use App\Models\Files;
use App\Models\UserFcmTokens;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Events\UserCheck;
use Illuminate\Support\Arr;
use DB;
use Curl;

class AuthController extends Controller {
    protected $responder;
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'unique'  => 'The :attribute field is unique.',
        'same'    => 'The :attribute and :other must match.',
        'size'    => 'The :attribute must be exactly :size.',
        'between' => 'The :attribute value :input is not between :min - :max.',
        'in'      => 'The :attribute must be one of the following types: :values',
    ];

    public function __construct(ResponseService $responder) {
        $this->responder =$responder;
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request, Users $model) {
        try {

            $rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'username' => 'required|string|unique:users',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed',
                'gender' => 'nullable|integer',
                'phone' => 'nullable|string',
                'role' => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->setStatus(400, 'Bad Request');
                $this->responder->set('message', $validator->errors()->first());
                return $this->responder->response();
            }
            $request->merge(['channel' => 'registration']);
            $fields = $request->only($model->getTableFields());
            foreach ($fields as $key => $value) {
                $model->setAttribute($key, $value);
            }
            $model->save();

            $user = User::find($model->id);
            $user->sendEmailVerificationNotification();

            $this->responder->set('message', Str::title('You\'re registered!'));
            $this->responder->set('data', $model);
            $this->responder->setStatus(201, 'Created.');
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }


    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request) {

        try {

            $rules = [
                'email' => 'required|email',
                'password' => 'required|string',
                'remember_me' => 'boolean|nullable',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->setStatus(400, 'Bad Request');
                $this->responder->set('message', $validator->errors()->first());
                return $this->responder->response();
            }

            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)) {
                $this->responder->setStatus(401, 'Unauthorized');
                $this->responder->set('message', 'You are not unauthorized');
                return $this->responder->response();
            }

            $user = $request->user();
            if($user->status != 'active') {
                $this->responder->setStatus(401, 'Unauthorized');
                $this->responder->set('message', 'Your account is not active!');
                return $this->responder->response();
            }
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->get('remember_me')) {
                $token->expires_at = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
                $token->save();
            }

            $roles = $user->roles->pluck( 'name' );
            $data = array(
                "user" => $user,
                "roles" => $roles,
                "token" => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->format('Y-m-d H:i:s')
                ]
            );

            $this->responder->set('collection', 'User');
            $this->responder->set('message', 'You are Authorized');
            $this->responder->set('data', $data);
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }

    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request) {
        try {
            $request->user()->token()->revoke();
            $this->responder->set('collection', 'User');
            $this->responder->set('message', 'Successfully logged out');
            return $this->responder->response();
        } catch (\Exception $err) {}
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function profile(Request $request)
    {
        $user = Auth::user();
        $permissions = $user->getAllPermissions();
        $permissions = Arr::pluck($permissions, 'name');

        $profile = Users::with(['address', 'photo', 'roles'])->find($user->id);
        $this->responder->set('collection', 'User');
        $this->responder->set('message', 'Data retrieved');
        $this->responder->set('data', $profile);
        $this->responder->set('permissions', $permissions);
        return $this->responder->response();
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function updateProfile(Request $request) {

        try {

            $rules = [
                "email" => "required|email",
                "first_name" => "required|string",
                "last_name" => "required|string",
                "dob" => "required|date",
                "gender" => "required|string",
                "phone" => "required|string",
                "address" => "nullable|array"
            ];

            $validator = Validator::make($request->all(), $rules, $this->messages);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->setStatus(400, 'Bad Request');
                $this->responder->set('message', $validator->errors()->first());
                return $this->responder->response();
            }

            $user = Auth::user();
            $fields = $request->only([
                "email",
                "first_name",
                "last_name",
                "dob",
                "gender",
                "phone"
            ]);
            foreach ($fields as $key => $value) {
                $user->setAttribute($key, $value);
            }
            $user->save();

            if($request->has('address')) {
                $address = Addresses::where('foreign_id', $user->id)
                                    ->where('foreign_table', 'users')
                                    ->first();

                if(is_null($address)) {
                    $address = new Addresses();
                }

                $data = array_merge($request->get('address'), [
                    'foreign_id' => $user->id,
                    'foreign_table' => 'users'
                ]);

                foreach ($data as $key => $value) {
                    $address->setAttribute($key, $value);
                }
                $address->save();
            }

            $this->responder->setStatus(200, 'Ok');
            $this->responder->set('message', 'Profile updated');
            $this->responder->set('data', $user);
            return $this->responder->response();

        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function photo(Request $request)
    {
        $user = Auth::user();
        $profile = Files::where('foreign_table', 'users')
                        ->where('foreign_id', $user->id)
                        ->where('directory', 'users/profile')
                        ->first();

        $this->responder->set('collection', 'User');
        $this->responder->set('message', 'Data retrieved');
        $this->responder->set('data', $profile);
        return $this->responder->response();
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function permissions(Request $request)
    {
        $user = Auth::user();
        $permissions = $user->getAllPermissions();
        $permissions = Arr::pluck($permissions, 'name');

        $this->responder->set('collection', 'Permissions');
        $this->responder->set('message', 'Data retrieved');
        $this->responder->set('data', $permissions);
        return $this->responder->response();
    }


    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function changePassword(Request $request) {

        try {

            $rules = [
                'password' => 'required|string|confirmed',
                'password_confirmation' => 'required_with:password|same:password|min:6'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->setStatus(400, 'Bad Request');
                $this->responder->set('message', $validator->errors()->first());
                return $this->responder->response();
            }

            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();

            $this->responder->setStatus(200, 'Ok');
            $this->responder->set('message', 'Password changed!');
            $this->responder->set('data', $user);
            return $this->responder->response();

        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

	public function createUpdateFCM(Request $request) {
		try {
			$user = Auth::user();
			$token = UserFcmTokens::updateOrCreate(
				['user_id' => $user->id, 'token' => $request->get('token')],
				['token' => $request->get('token')]
			);
            $this->responder->setStatus(200, 'Ok');
            $this->responder->set('message', 'FCM Token updated!');
            $this->responder->set('data', $token);
            return $this->responder->response();
		} catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
		}
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function forgotPassword(Request $request) {

        try {
            $rules = [
                'email' => 'required|email',
            ];

            $validator = Validator::make($request->all(), $rules, $this->messages);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->setStatus(400, 'Bad Request');
                $this->responder->set('message', $validator->errors()->first());
                return $this->responder->response();
            }

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            $status == Password::RESET_LINK_SENT? true: false;
            if($status) {
                $this->responder->setStatus(200, 'Ok');
                $this->responder->set('message', 'Reset link sent!');
                $this->responder->set('data', null);
            } else {
                $this->responder->setStatus(500);
                $this->responder->set('message', 'Server cannot send link to your email!');
                $this->responder->set('data', null);
            }
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

}
