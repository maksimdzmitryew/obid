<?php

namespace App\Http\Controllers\Auth;

      use Illuminate\Support\Facades\Auth;
                          use Carbon\Carbon;
      use Illuminate\Support\Facades\DB;
      use Illuminate\Support\Facades\Hash;
       use App\Http\Controllers\Auth\LoginController as Controller;
      use Illuminate\Support\Facades\Mail;
                             use App\PasswordResets;
   use Illuminate\Auth\Notifications\ResetPassword;
               use App\Http\Requests\ResetRequest;
                 use Illuminate\Http\Request;
      use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
              use Illuminate\Support\Str;



      use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

	function change($token = NULL, Request $request)
	{
		$a_errors = [];

		if (!is_null($request->post('token')))
			$token = $request->post('token');

		$validator = Validator::make(request()->post(), [
			'password_new' => 'required|string|confirmed|min:6|max:40',
			'password_new_confirmation' => 'required|string'
		]);

		if($validator->fails())
		{
			$a_errors		= json_decode($validator->errors(), TRUE);
		}

		$user = $this->_checkToken($token);
		if( ! $user){
			$a_errors['token'] = [trans('validation.exists', ['attribute' => trans('user/form.field.token'),]),];
		}

		if (count($a_errors) > 0)
		{
			return response([
				'message'	=> trans('messages.validation.fail'),
				'errors'	=> $a_errors,
			], 422);
		}

		$user->password = bcrypt($request->post('password_new'));
		$user->save();

		Auth::login($user);
		PasswordResets::where('email', $user->email)->delete();

		return response([
			'title'		=> trans('user/form.text.reset'),
			'message'	=> trans('user/form.text.reset_done'),
			'url'		=> route('guest.personal.profile'),
		], 200);

	}

	function form()
	{
		$this->setEnv();

#		return view('public.profile.password-reset');
		return view($this->_env->s_view . 'password',
					[
						'tab'			=> request()->segment(2),
					]);
	}

	function new($token = NULL)
	{
/*
		$user = $this->_checkToken($token);

		if( ! $user){
			return response([
				'message' => trans('messages.validation.fail'),
				'errors' => [
					'token' => 'Token is not valid'
				]
			], 422);
		}
*/
		$this->setEnv();

		return view($this->_env->s_view . 'password',
					[
						'tab'			=> request()->segment(1),
						'token'			=> $token,
					]);
/*
		return view('public.profile.password-change', [
			'token' => $token
		]);
*/
	}

	function send(ResetRequest $request)
	{
        $this->setEnv();

		$data = $request->post();
		$validator = Validator::make($data, []);

		if($validator->fails())
		{
			return response([
				'message' => trans('messages.validation.fail'),
				'errors' => $validator->errors()
			], 422);
		}

		$hash = sha1(Str::random(60));

		$i_status	= 200;
		$s_title	= trans('user/form.text.reset');
		$s_msg		= trans('user/form.text.reset_sent');
		$s_footer	= '';
		$s_url		= route('password_change', ['token' => NULL]);


#		Mail::send('emails.password-reset', ['hash' => $hash], function($message) use ($request) {
#			$message->to($request->post('email'))->subject(trans('user/form.text.reset_subj'));
#		});


        try
        {
            $a_data = [ 'hash' => $hash, 'email' => $data['email'], 's_app_name' => $this->_env->s_title ];
            $o_mail_status = Mail::send('emails.password-reset', $a_data, function($message) use ($request) {
                $message
                    ->from($this->_env->s_email, $this->_env->s_title)
                    ->to($request->post('email'))
                    ->subject(trans('user/form.text.reset_subj', [ 'app_name' => $this->_env->s_title ]))
                    ;
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
			$data = [
				'email' => $request->post('email'),
				'token' => $hash,
				'created_at' => now()
			];

			$reset_password = DB::table('password_resets')->where('email', $request->post('email'));

			$reset_password->count() ? $reset_password->update($data) : $reset_password->insert($data);
        }

        return response(
            [
            'title'         => $s_title,
            'message'       => $s_msg,
            'footer'        => $s_footer,
            'btn_primary'   => trans('user/messages.button.ok'),
            'url'           => $s_url,
            ],
            $i_status
        );
	}

	private function _checkToken($token)
	{
		$reset_password = PasswordResets::where('token', $token)->where('created_at', '>', Carbon::now()->subHour())->first();

		return $reset_password ? $reset_password->user : false;
	}

}
