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
}
