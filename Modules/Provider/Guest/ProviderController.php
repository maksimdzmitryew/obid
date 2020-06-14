<?php

namespace Modules\Provider\Guest;

use                                          Auth;
use                Modules\Building\Database\Building;
use                     App\Http\Controllers\ControllerGuest as Controller;
#                                 use Hash;
use                   Modules\Provider\Database\Provider;
use                          Illuminate\Http\Request;
#                             use App\Subscriber;
#                             use App\User;
#                                 use Validator;


class ProviderController extends Controller
{
	/**
	 * Open CRUD form to authenticated user (aka "User" previously and now "Guest")
	 * for creating/editing the specified resource.
	 * @param Request	$request		Data from request
	 *
	 * @return View		instance of
	 */
	public function form(Request $request)
	{
		$this->setEnv();

		$user = Auth::user();

		return view($this->_env->s_view . 'form',
					[
						'b_admin'		=> $user->checkAdmin(),
						'building'		=> Building::all()->sortBy('title'),
						'provider'		=> Provider::findOrNew($request->id),
						'user'			=> $user,
					]);
	}
}
