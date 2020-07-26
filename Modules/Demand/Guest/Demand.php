<?php

namespace Modules\Demand\Guest;

use                                   \Carbon\Carbon;
use                   Modules\Course\Database\Course;
use                   Modules\Demand\Database\Demand as Model;
use                     Modules\Meal\Database\Meal;
use                    Modules\Plate\Database\Plate;

class Demand extends Model
{
	/**
	 * Get list of courses that available for upcoming dates
	 * @param	Object				query to select items for
	 *
	 * @return	Object				items
	 */
	public static function getCourses($o_query)
	{
		$a_meal_ids		= $o_query->select('meal_id')->distinct()->get()->pluck('meal_id')->toArray();
		$a_course_ids	= Meal::select('course_id')->whereIn('id', $a_meal_ids)->distinct()->get('course_id')->pluck('course_id')->toArray();
		$o_courses		= Course::select()->whereIn('id', $a_course_ids)->get('id', 'title');
		return $o_courses;
	}


	/**
	 * Get activity of all users
	 *
	 * @return	Array						specifically organised for easier presentation
	 */
	public static function getAllDemand() : Array
	{
		$s_freshest		= Plate::select('date')->max('date');
		$s_date_start	= Carbon::parse($s_freshest)->addWeeks(-2)->startOfWeek()->format('Y-m-d');
		$s_date_end		= Carbon::parse($s_freshest)->endOfWeek()->format('Y-m-d');
#$s_date_start	= '2020-07-13';$s_date_end		= '2020-07-31';

        $o_query		= Plate::select
        			(
						'plates.id'
						, 'plates.date'
						, 'plates.position'
						, 'plates.price'
						, 'plates.weight'
						, 'courses.id AS course_id'
						, 'meals.id AS meal_id'
						, \DB::raw('COUNT(ob_plates.id) AS qty')
						, 'meal_translations.title AS title'
        			)
            ->join('meals', 'plates.meal_id', '=', 'meals.id')
            ->join('courses', 'meals.course_id', '=', 'courses.id')
            ->join('meal_translations', 'plates.meal_id', '=', 'meal_translations.meal_id')
            ->join('demand_plate', 'plates.id', '=', 'demand_plate.plate_id')
            ->groupBy('plates.id')
			->whereBetween('plates.date', [$s_date_start, $s_date_end])
            ;
		$o_plates		= $o_query->get();
		$a_items		= [];
		$a_items	= self::_arrangeDemands($o_plates, $a_items);
		return $a_items;
	}

	/**
	 * Get list of preferred meals by user
	 * @param	Object		$o_user			user to check activity for
	 *
	 * @return	Array						items
	 */
	public static function getRating(Object $o_user)
	{

#Table 1 (plates): id, name
#Table 2 (demand_plate): id, amount, plate_id, plate_id
#Table 3 (demands): id, last_name

$o_items = Plate::join('demand_plate', 'plates.id', '=', 'demand_plate.plate_id')
->join('demands', 'demand_plate.demand_id', '=', 'demands.id');
#->get();

dd($o_items->toSql());

        $o_query = Meal::select
        			(
						'meals.id'
#						, 'meal_translations.title AS title'
						, 'demands.id AS demand_id'
        			)
/*
            ->leftJoin('plate_translations', function($join) {
                $join->on('plate_translations.plate_id', '=', 'plates.id')
                    ->where('locale', '=', app()->getLocale());
            })
*/
#            ->join('meal_translations', 'plates.meal_id', '=', 'meal_translations.meal_id')
#            ->join('courses', 'courses.id', '=', 'meals.course_id')
#            ->leftJoin('demands', function($join) {
#                $join->on('meals.demand_id', '=', 'plates.demand_id');
#            })
#            ->whereDate('date', '=', $o_date)
            ;
dd($o_query->get()[0]->original);



/*
		$o_demands		= self::select('id')->distinct()->whereUserId($o_user->id)->get('id', 'plate_id', 'meal_id');

		foreach ($o_demands AS $k => $v)
		{
			dump($v->plate->meal);#->demand->id);

		}
dd($o_demands);
*/
#		$r = self::select()->whereUserId($i_user_id)->
		$o_items	= Meal::select()
#						->distinct()
						->with('plate')
						->with('plate.demand')
#						->where('demand.user_id', '=', $o_user->id)
#						->get()
						;#->with('plate')->with('demand')->where('demands.user_id', '=', $o_user->id)->get('id', 'meal_id');
dump($o_items->toSql());
#		$a_items	= [];
		foreach ($o_items->get() AS $k => $v)
		{
			dump($v->plate->demand);#->demand->id);
#			$a_items[$v->meal->course->id][$v->position][$v->date] = $v;
		}

dd($o_items->count(), $o_items);
		return $o_query->select('date')->get()->pluck('date')->toArray();
	}

	/**
	 * Get list of upcoming dates
	 * @param	Object				query to select items for
	 *
	 * @return	Array				items
	 */
	public static function getUpcomingDates($o_query)
	{
		return $o_query->select('date')->get()->pluck('date')->toArray();
	}

	/**
	 * Check if any demands already made for current week
	 * @param	Array				demands’ dates
	 *
	 * @return	Boolean				flag
	 */
	public static function getThisWeek($a_dates) : Bool
	{
		$s_freshest			= Plate::select('date')->max('date');

		$b_current_week	 	= (isset($a_dates[0]) ?
									(
										Carbon::parse($s_freshest)->isNextWeek()
										&&
										Carbon::parse($a_dates[0])->isNextWeek()
									)
									||
									(
										Carbon::now()->startOfWeek()->format('Y-m-d') <= $a_dates[0]
										&&
										Carbon::now()->endOfWeek()->format('Y-m-d') >= $a_dates[0]
										&&
										Carbon::now()->startOfWeek()->format('Y-m-d') <= $s_freshest
										&&
										Carbon::now()->endOfWeek()->format('Y-m-d') >= $s_freshest
									)
								: FALSE);
		return $b_current_week;
	}

	/**
	 * Get list of meals on plate that available for upcoming dates
	 * @param	Object				query to select items for
	 *
	 * @return	Array				specifically organised for easier presentation
	 */
	public static function getWeekItems($o_query)
	{
		$o_items		= $o_query->select('id', 'meal_id', 'date', 'position', 'price', 'weight')->get();
		$a_items		= [];
		foreach ($o_items AS $k => $v)
		{
			$a_items[$v->meal->course->id][$v->position][$v->date] = $v;
		}
		return $a_items;
	}

	/**
	 * Arrange raw data to unified array grouped by date
	 * @param	Object		$o_plates		user to check activity for
	 * @param	Array		$a_items		user to check activity for
	 *
	 * @return	Array						plate properties by date
	 */
	private static function _arrangeDemands(Object $o_plates, Array $a_items) : Array
	{
		foreach ($o_plates AS $k => $o_plate)
		{
			$a_items[$o_plate->date]['plate_id'][]			= $o_plate->id;
			$a_items[$o_plate->date]['course_id'][]			= $o_plate->meal->course->id;
			$a_items[$o_plate->date]['meal_title'][]		= $o_plate->meal->title;
			$a_items[$o_plate->date]['meal_id'][]			= $o_plate->meal->id;
			$a_items[$o_plate->date]['price'][]				= (int) $o_plate->price;
			$a_items[$o_plate->date]['position'][]			= $o_plate->position;
			$a_items[$o_plate->date]['qty'][]				= (int) ($o_plate->qty ?? 1);
			if (!isset($a_items[$o_plate->date]['total']))
			{
				$a_items[$o_plate->date]['total']			= 0;
			}
			if (!isset($a_items[$o_plate->date]['heavy']))
			{
				$a_items[$o_plate->date]['heavy']			= 0;
			}
			if (!isset($a_items[$o_plate->date]['heap']))
			{
				$a_items[$o_plate->date]['heap']			= 0;
			}
			if (!isset($a_items[$o_plate->date]['list']))
			{
				$a_items[$o_plate->date]['list']			= '';
			}
			$i_qty											= (int) ($o_plate->qty ?? 1);
			$a_items[$o_plate->date]['total']				+= (int) $o_plate->price;
			$a_items[$o_plate->date]['heavy']				+= (int) $o_plate->weight;
			$a_items[$o_plate->date]['heap']				+= $i_qty;
			$a_items[$o_plate->date]['list']				.= ','. $o_plate->position . ( $i_qty > 1 ? '×' . $i_qty : '' );
		}
		/**
		 *	clean up
		 */
		$a_items[$o_plate->date]['list']					= trim($a_items[$o_plate->date]['list'], ',');
		return $a_items;
	}

	/**
	 * Get activity of user
	 * @param	Object		$o_user			user to check activity for
	 *
	 * @return	Array						specifically organised for easier presentation
	 */
	public static function getUserActivity(Object $o_user) : Array
	{
		$o_demands		= self::select('id')->whereUserId($o_user->id)->get('id', 'plate_id');
		$a_items		= [];
		foreach ($o_demands AS $k => $o_demand)
		{
			$o_plates	= $o_demand->plate;
			$a_items	= self::_arrangeDemands($o_plates, $a_items);
		}
		/**
		 *	sort by date DESC
		 */
		krsort($a_items);
		return $a_items;
	}

}
