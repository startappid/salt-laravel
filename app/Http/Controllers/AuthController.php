<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Users;
use App\Models\UserFcmTokens;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Events\UserCheck;
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
    public function signup(Request $request) {

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

            $user = new User([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'gender' => $request->get('gender'),
                'phone' => $request->get('phone'),
                'password' => bcrypt($request->password),
                'api_token' => Str::random(80),
            ]);
            $user->save();
            if(!is_null($request->get('role'))) {
                $user->assignRole($request->get('role'));
            }

            $this->responder->setStatus(201, 'Created');
            $this->responder->set('message', 'Successfully created user!');
            $this->responder->set('data', $user);
            return $this->responder->response();

        } catch (\Exception $err) {}
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
                'username' => 'required|string',
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

            $credentials = request(['username', 'password']);
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
        $this->responder->set('collection', 'User');
        $this->responder->set('message', 'Data retrieved');
        $this->responder->set('data', $user);
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
                'password' => 'required|string|confirmed'
            ];

            $validator = Validator::make($request->all(), $rules, $this->messages);
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
    public function resetPassword(Request $request) {

        try {
            $rules = [
                'password' => 'required|string|confirmed',
            ];

            $validator = Validator::make($request->all(), $rules, $this->messages);
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
            $this->responder->set('data', null);
            return $this->responder->response();

        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

}
