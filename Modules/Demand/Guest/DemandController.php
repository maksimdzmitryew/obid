<?php

namespace Modules\Demand\Guest;

use                                          Auth;
use                Modules\Building\Database\Building;
use                     App\Http\Controllers\ControllerGuest as Controller;
#                                 use Hash;
use                   Modules\Demand\Database\Demand;
use                          Illuminate\Http\Request;
#                             use App\Subscriber;
#                             use App\User;
#                                 use Validator;


class DemandController extends Controller
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
#						'building'		=> Building::all()->sortBy('title'),
						'demand'		=> Demand::findOrNew($request->id),
						'user'			=> $user,
					]);
	}
}
