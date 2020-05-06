<?php

namespace App\Http\Controllers\Auth;

#                             use App\Country;
#      use Illuminate\Support\Facades\Auth;
      use Illuminate\Foundation\Auth\AuthenticatesUsers;
#                          use Carbon\Carbon;
#                                 use Cookie;
            use App\Http\Controllers\Controller as BaseController;
#      use Illuminate\Support\Facades\DB;
#      use Illuminate\Support\Facades\Hash;
#      use Illuminate\Support\Facades\Mail;
#   use Illuminate\Auth\Notifications\ResetPassword;
#               use App\Http\Requests\ResetRequest;
                 use Illuminate\Http\Request;
#              use Illuminate\Support\Str;
#               use App\Http\Requests\SigninRequest;
#               use App\Http\Requests\SignupRequest;
#                             use App\User;
#      use Illuminate\Support\Facades\Validator;
#use App\Traits\FestivalTrait;

class LoginController	extends BaseController
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;
/*
	use FestivalTrait {
		FestivalTrait::__construct as protected __traitConstruct;
	}
*/
	public function __construct(Request $request)
	{
		$this->middleware('guest')->except('logout');
#		$this->__traitConstruct($request);
	}

	protected function redirectTo()
	{
		return route('guest.personal.profile');
	}

}
