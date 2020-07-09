<?php

namespace Modules\Demand\Guest;

use                   Modules\Course\Database\Course;
use                   Modules\Demand\Database\Demand as Model;
use                     Modules\Meal\Database\Meal;

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
			$a_tmp		= [];
			$i_tmp		= 0;
			foreach ($o_plates AS $k => $o_plate)
			{
				$a_items[$o_plate->date]['plate_id'][]			= $o_plate->id;
				$a_items[$o_plate->date]['course_id'][]			= $o_plate->meal->course->id;
				$a_items[$o_plate->date]['meal_title'][]		= $o_plate->meal->title;
				$a_items[$o_plate->date]['meal_id'][]			= $o_plate->meal->id;
				$a_items[$o_plate->date]['price'][]				= (int) $o_plate->price;
				$a_items[$o_plate->date]['position'][]			= $o_plate->position;
				$a_items[$o_plate->date]['weight'][]			= (int) $o_plate->weight;
				if (!isset($a_items[$o_plate->date]['total']))
				{
					$a_items[$o_plate->date]['total']			= 0;
				}
				if (!isset($a_items[$o_plate->date]['heavy']))
				{
					$a_items[$o_plate->date]['heavy']			= 0;
				}
				$a_items[$o_plate->date]['total']				+= (int) $o_plate->price;
				$a_items[$o_plate->date]['heavy']				+= (int) $o_plate->weight;
			}
		}
		/**
		 *	sort by date DESC
		 */
		krsort($a_items);
		return $a_items;
	}

}
