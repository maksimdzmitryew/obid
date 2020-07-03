<?php

namespace Modules\Personal\Guest;

                                 use Auth;
       use Modules\Building\Database\Building;
            use App\Http\Controllers\ControllerGuest as Controller;
                                 use Hash;
          use Modules\Place\Database\Place;
                 use Illuminate\Http\Request;
                             use App\Subscriber;
                             use App\User;
                                 use Validator;

class PersonalController extends Controller
{

	public function profile(Request $request)
	{
		$this->setEnv();

		$user = Auth::user();

		return view($this->_env->s_view . 'index',
					[
						'b_admin'		=> $user->checkAdmin(),
						'tab'			=> request()->segment(2),
						'user'			=> $user,
						'subscribe'		=> Subscriber::where('email', $user->email)->exists(),
					]);
/*
#        return view('public.profile.miy-pr', [
		return view('public.profile.miy-pr', [
			'user'			=> $user,
			'b_admin'		=> $user->checkAdmin(),
			'subscribe'		=> Subscriber::where('email', $user->email)->exists(),
			#'event_dates' => $events,
			#'dates' => $this->getFavoriteDates(),
			#'cities' => $this->getCities()
		]);
*/
	}

	public function update(Request $request)
	{
		$user = User::find(Auth::id());

		$validator = Validator::make($request->all(), [
			'first_name'	=> 'required|string|max:255',
			'last_name'		=> 'required|string|max:255',
			'email'			=> 'required|string|email|max:255|unique:users,email,' . $user->id,
			'old_password'	=> 'nullable|string|min:6',
			'password'		=> 'nullable|string|min:6|confirmed',
			'subscribe'		=> 'nullable|boolean',
		]);

		$user->first_name	= $request->first_name;
		$user->last_name	= $request->last_name;
		$user->email		= $request->email;

		if ($request->password) {
			if (!Hash::check($request->old_password, $user->password)) {
				return back()->withErrors([
					'old_password' => 'Given data does not match any record'
				])->withInput();
			}

			$user->password = bcrypt($request->password);
		}

		if ($request->subscribe) {
			if (!Subscriber::where('email', $user->email)->exists()) {
				Subscriber::create(['email' => $user->email]);
			}
		} else {
			if ($subscriber = Subscriber::where('email', $user->email)->first()) {
				$subscriber->delete();
			}
		}

		$user->save();

		return back();
	}

	public function activity(Request $request)
	{
		$this->setEnv();

		$user = Auth::user();

		return view($this->_env->s_view . 'index',
					[
						'b_admin'		=> $user->checkAdmin(),
						'tab'			=> request()->segment(2),
						'user'			=> $user,
						'subscribe'		=> Subscriber::where('email', $user->email)->exists(),
					]);
	}

}
