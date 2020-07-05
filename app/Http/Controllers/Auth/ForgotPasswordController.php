<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ForgotPasswordController extends Controller
{
	use SendsPasswordResetEmails;

    protected $responder;

	/**
	 * Create a new controller instance.
	 */
	public function __construct(ResponseService $responder)
	{
		$this->responder = $responder;
		$this->middleware('guest');
	}

	public function __invoke(Request $request)
	{

		$rules = [
			'phone_number' => 'required|string'
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			$this->responder->set('errors', $validator->errors());
			$this->responder->setStatus(400, 'Bad Request');
			$this->responder->set('message', $validator->errors()->first());
			return $this->responder->response();
		}

		$user = User::where('phone', $request->get('phone_number'))->first();
    if(is_null($user)) {
      $this->responder->set('message', "User not found!");
      $this->responder->setStatus(404, 'Not found.');
      return $this->responder->response();
		}

		$request->merge(['email' => $user->email]);

		$this->validateEmail($request);

		// We will send the password reset link to this user. Once we have attempted
		// to send the link, we will examine the response then see the message we
		// need to show to the user. Finally, we'll send out a proper response.
		$response = $this->broker()->sendResetLink(
			$request->only('email')
		);

        if($response == Password::RESET_LINK_SENT) {
            $this->responder->setStatus(201, 'Created');
            $this->responder->set('message', 'Reset link sent to your email.');
            return $this->responder->response();
        } else {
            $this->responder->setStatus(401, 'Unauthorized');
            $this->responder->set('message', 'Unable to send reset link');
            return $this->responder->response();
        }
	}
}