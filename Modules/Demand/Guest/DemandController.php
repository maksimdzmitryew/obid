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
		$fn_find = $this->_env->fn_find;
		$this->validate($request, [
			'id' => 'integer'
		]);

		$o_user				= Auth::user();
		if (is_null($request->id))
		{
			$i_tmp			= GuestDemand::select('id')->whereUserId($o_user->id)->max('id');
			$request->merge([
				'id' => $i_tmp,
			]);
		}

		$a_activity	= GuestDemand::getUserActivity($o_user);

		$s_freshest			= Plate::select('date')->max('date');
		$i_week				= (int) \Carbon\Carbon::parse($s_freshest)->isNextWeek();

		$o_query	= Plate::whereBetween('date', [
							Carbon::now()->addWeek($i_week)->startOfWeek()->format('Y-m-d'),
							Carbon::now()->addWeek($i_week)->endOfWeek()->format('Y-m-d')
						])
			->distinct()
			->limit(1000)
			;

		return view($this->_env->s_view . 'week',
				[
					$this->_env->s_sgl		=> $fn_find($request->id),
					'b_admin'				=> $o_user->checkAdmin(),
					'a_dates'				=> GuestDemand::getUpcomingDates($o_query),
					'o_courses'				=> GuestDemand::getCourses($o_query),
					'a_items'				=> GuestDemand::getWeekItems($o_query),
					'b_week'				=> GuestDemand::getThisWeek(array_keys($a_activity)),
					'activity'				=> $a_activity,
					'user'					=> $o_user,
				]);
	}
}
