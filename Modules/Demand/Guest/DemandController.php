<?php

namespace Modules\Demand\Guest;

use                                           Auth;
use                        Illuminate\Support\Carbon;
use                      App\Http\Controllers\ControllerGuest as Controller;
use                   Modules\Demand\Database\Demand;
use                      Modules\Demand\Guest\Demand as GuestDemand;
use                    Modules\Plate\Database\Plate;
use                           Illuminate\Http\Request;
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

		$o_query = Plate::where('date', '>', Carbon::now())->distinct()->limit(1000);

		return view($this->_env->s_view . 'form',
					[
						'b_admin'		=> $user->checkAdmin(),
						'demand'		=> GuestDemand::findOrNew($request->id),
						'a_dates'		=> GuestDemand::getUpcomingDates($o_query),
						'o_courses'		=> GuestDemand::getCourses($o_query),
						'a_items'		=> GuestDemand::getItems($o_query),
						'user'			=> $user,
					]);
	}
}
