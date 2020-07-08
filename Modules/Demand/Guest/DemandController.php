<?php

namespace Modules\Demand\Guest;

use                                              Auth;
use                           Illuminate\Support\Carbon;
use                         App\Http\Controllers\ControllerGuest as Controller;
use                      Modules\Demand\Database\Demand;
use                         Modules\Demand\Guest\Demand as GuestDemand;
use                       Modules\Plate\Database\Plate;
use                              Illuminate\Http\Request;
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
	public function week(Request $request)
	{
		$this->setEnv();

		$o_user = Auth::user();

		$o_query = Plate::whereBetween('date', [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])
			->distinct()
			->limit(1000)
			;

		return view($this->_env->s_view . 'week',
					[
						'b_admin'		=> $o_user->checkAdmin(),
						'demand'		=> GuestDemand::findOrNew($request->id),
						'a_dates'		=> GuestDemand::getUpcomingDates($o_query),
						'o_courses'		=> GuestDemand::getCourses($o_query),
						'a_items'		=> GuestDemand::getWeekItems($o_query),
						'activity'		=> GuestDemand::getUserActivity($o_user),
						'user'			=> $o_user,
					]);
	}
}
