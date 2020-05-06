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
                             use App\User;
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

		$user->active = 1;
		$user->save();

		Auth::login($user);

		return redirect(route('guest.personal.profile'));
	}

	public function core(SignupRequest $request)
	{
		$data = $request->post();
		$validator = Validator::make($data, []);

		if($validator->fails()){
			return response([
				'message' => 'Validation fails',
				'errors' => $validator->errors()
			], 422);
		}

		$token = sha1(Str::random(60));

		$user = User::create([
			'email'             => $data['email'],
			'password'          => Hash::make($data['password']),
			'activation_token'  => $token,
		]);

		Mail::send('emails.registration', [ 'token' => $token, 'email' => $data['email'] ], function($message) use ($request) {
			$message->from(config('services.mail.from'), config('services.mail.name'))
				->to($request->post('email'))->subject(trans('common/messages.email.subject'));
		});

		return response([
			'message'	=> trans('user/form.text.token_sent'),
			'url'		=> route('public.cabinet'),
		], 200);

	}

}
