<?php

namespace App\Http\Controllers\Auth;

      use Illuminate\Support\Facades\Auth;
#      use Illuminate\Foundation\Auth\AuthenticatesUsers;
                                 use Cookie;
      use Illuminate\Support\Facades\DB;
       use App\Http\Controllers\Auth\LoginController as Controller;
               use App\Http\Requests\SigninRequest;
              use Illuminate\Support\Str;
                 use Illuminate\Http\Request;
      use Illuminate\Support\Facades\Validator;

class SigninController	extends Controller
{
#	use AuthenticatesUsers;

	public function __construct(Request $request)
	{
		$this->middleware('guest');
	}

	public function core(SigninRequest $request)
	{

		$data = $request->post();
		$validator = Validator::make($data, []);

		if($validator->fails()){
			return response([
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		if (in_array($request->login_safety, [0,1,2]))
			$i_safety = $request->login_safety;
		else
			$i_safety = NULL;

		session(['safety' => $i_safety]);

		if ($i_safety == 1)
			$s_email = $request->email;
		else
			$s_email = NULL;

		if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1], ($i_safety == 2)))
		{
			$cookie_name='email';
			$cookie_value=$s_email;
			$cookie_expired_in=2629800;//in mins = 5 years
			$cookie_path='/'; // available to all pages of website.
			$cookie_host=$request->getHttpHost(); // domain or website you are setting this cookie.
			$http_only=false;
			$secure=false;
			$raw=false;
			$samesite=null;
			$my_cookie = cookie($cookie_name, $cookie_value, $cookie_expired_in,$cookie_path,$cookie_host,$http_only);
			Cookie::queue($my_cookie);

			return back()->withCookie($my_cookie);
			return response([
				'action' => 'reload',
			], 307);
		}
		return redirect(route('guest.personal.profile'));
	}

	public function form()
	{
		$this->setEnv();

		$s_email	= Cookie::get('email');
		$i_safety	= (int) (!is_null($s_email) && !empty($s_email));

#		return view('public.profile.login',
		return view($this->_env->s_view . 'login',
					[
						'safety'		=> $i_safety,
						'email'			=> $s_email,
						'tab'			=> request()->segment(1),
					]);
	}

}
