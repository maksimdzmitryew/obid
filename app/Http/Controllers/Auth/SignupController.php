<?php

namespace App\Http\Controllers\Auth;

      use Illuminate\Support\Facades\Auth;
      use Illuminate\Foundation\Auth\AuthenticatesUsers;
                          use Carbon\Carbon;
                                 use Cookie;
      use Illuminate\Support\Facades\DB;
      use Illuminate\Support\Facades\Hash;
       use App\Http\Controllers\Auth\LoginController as Controller;
      use Illuminate\Support\Facades\Mail;
                 use Illuminate\Http\Request;
               use App\Http\Requests\SignupRequest;
use                              App\User;
      use Illuminate\Support\Facades\Validator;
              use Illuminate\Support\Str;

class SignupController	extends Controller
{
	use AuthenticatesUsers;

	public function __construct(Request $request)
	{
		$this->middleware('guest');
	}

	public function form()
	{
		$this->setEnv();

		return view($this->_env->s_view . 'login',
					[
						'safety'		=> NULL,
						'email'			=> '',
						'tab'			=> request()->segment(1),
					]);
	}

	public function confirm($token){

		$user = User::where('activation_token', $token)->first();

		if( ! $user){
			return redirect('welcome.index');
		}

		$user->published = 1;
		$user->save();

		Auth::login($user);

		return redirect(route('guest.personal.profile'));
	}

	public function core(SignupRequest $request)
	{
		$data = $request->post();

/*
		$validator = Validator::make($data, []);

		if($validator->fails()){
			return response([
				'message' => trans('validation/status.422'),
				'errors' => $validator->errors()
			], 422);
		}
*/
		$token = sha1(Str::random(60));

		$i_status = 200;
		$s_title = trans('user/messages.text.success');
		$s_msg = trans('user/form.text.token_sent');
		$s_footer = '';
		$s_url = route('guest.personal.profile');

		try
		{
			$o_mail_status = Mail::send('emails.registration', [ 'token' => $token, 'email' => $data['email'] ], function($message) use ($request) {
				$message->from(config('services.mail.from'), config('services.mail.name'))
					->to($request->post('email'))->subject(trans('common/messages.email.subject'));
			});

		    if (is_object($o_mail_status) && $o_mail_status->failures() > 0)
		    {
		    	$s_msg = '';
		        //Fail for which email address...
		        foreach (Mail::failures as $address)
		        {
		            $s_msg .= $address . ', ';
		        }
		    }
		}
		catch (\Swift_TransportException $e)
		{
			$i_status = 409;
			$s_title = trans('user/messages.text.failure');
			$s_msg = trans('user/form.text.failed_sending') . ' ' . trans('user/form.text.try_later');
			$s_footer = trans('user/form.text.failed_exception') . ':<br /><i>' . $e->getMessage() . '</i>';
			$s_url = route('signup_page');
		}

		if ($i_status == 200)
		{
			$user = User::create([
				'email'             => $data['email'],
				'password'          => Hash::make($data['password']),
				'activation_token'  => $token,
			]);
		}

		return response(
			[
			'title'			=> $s_title,
			'message'		=> $s_msg,
			'footer'		=> $s_footer,
			'btn_primary'	=> trans('user/messages.button.ok'),
			'url'			=> $s_url,
			],
			$i_status
		);

	}

}
