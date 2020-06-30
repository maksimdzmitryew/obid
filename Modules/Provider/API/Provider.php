<?php

namespace Modules\Provider\API;

use                                      Carbon\Carbon;
use                     Modules\Course\Database\Course as Course;
use                                  App\Traits\FileTrait;
use                       Modules\Meal\Database\Meal;
use                      Modules\Plate\Database\Plate;
use                   Modules\Provider\Database\Provider as Model;
use                             Illuminate\Http\Request;

class Provider extends Model
{
	use FileTrait;

	public $translationModel = '\Modules\Provider\Database\ProviderTranslation';

	/**
	 * Parse provider’s web-page for updates in menu
	 * @param Request	$request			data from request
	 *
	 * @return void
	 */
	public static function parse(Request $request) : void
	{
		$a_columns	= ['id'];
		for ($d = 1; $d < 6; $d++)
		{
			$a_columns[]	= 'day_' . $d;
		}
		$a_items	= self::select($a_columns)->wherePublished(1)->limit(25)->get()->toArray();
		for ($i = 0; $i < count($a_items); $i++)
		{
			for ($d = 1; $d < 6; $d++)
			{
				dump($a_items[$i]['day_' . $d]);
				self::_parseDay($a_items[$i]['id'], $a_items[$i]['day_' . $d]);
			}
		}
	}

	/**
	 * Find recognisable text within webpage content
	 * @param String	$s_content			webpage content
	 *
	 * @return String						valuable content
	 */
	private static function _getText(String $s_content) : String
	{
		$i_pos		= strpos($s_content, '<!DOCTYPE xhtml><html><head></head><body>');
		if ($i_pos === FALSE) return '';
		$s_text		= substr($s_content, $i_pos);
		$i_pos		= strpos($s_text, '</table></body></html>');
		if ($i_pos === FALSE) return '';
		$i_pos		+= strlen('</table></body></html>');
		$s_text		= trim(substr($s_text, 0, $i_pos), '/');
		return $s_text;
	}

	/**
	 * Find recognisable date stamp within webpage content
	 * @param String	$s_content			webpage all content
	 *
	 * @return Object						carbon ready
	 */
	private static function _getDate(String $s_content) : Object
	{
		$s_date		= '';
		$s_regexps	=
			'<table widht="1000" align="center">'
			. '<tr>'
			. '<td align="right">'
			. '<h2 class="h2class">Меню на .+?</h2>'
			. '</td>'
			. '<td align="right">'
			. '<h2 class="h2class">'
			. '(.*?)</h2>'
			. '</td>'
			. '</tr>'
			. '</table>'
		;
		preg_match_all('~' . $s_regexps . '~iu', $s_content, $a_matches);

		if (isset($a_matches[1][0]))
			$s_date = ltrim(trim(str_replace('.', '/', $a_matches[1][0]), ' /'), '0');

		$o_date		= Carbon::createFromFormat('j/m/Y', $s_date);
		if ($o_date->format("Y") < date("Y"))
		{
			$o_date	= Carbon::createFromFormat('j/m/y', $s_date);
		}
		return $o_date;
	}

	/**
	 * Find recognisable text within webpage content
	 * @param String	$s_text				webpage valuable content
	 *
	 * @return Array						matched items
	 */
	private static function _getMatches(String $s_text) : Array
	{
		$s_regexps	= '<tr>'
						. '<td class="ttdd1s">(\d+)</td>'
						. '<td class="ttdd2s">(.*?)</td>'
						. '<td class="ttdd3s">(.*?)\s*?\[(\d+)\]</td>'
						. '<td class="ttdd4s".+?value="(.+?)".+?/td>'
						. '<td class="ttdd5s".+?value="(\d+?)".+?/td>'
						. '.*?</tr>'
						;
		preg_match_all('~' . $s_regexps . '~iu', $s_text, $a_matches);
#		echo '<pre>';var_dump($a_matches);echo '</pre>';
		$a_courses	= [];
		return $a_matches;
	}

	/**
	 * Turn matched text into associative array
	 *
	 * @param Array		$a_match			single record from webpage
	 * @param Integer	$i_pointer			position in array
	 * @param Integer	$provider_id		provider
	 *
	 * @return Array					structured course and its meal
	 */
	private static function _matchCourseAndMeal(Array $a_matches, Int $i_pointer, Int $provider_id) : Array
	{
		$a_tmp		= [];
		$a_tmp['course']
					= [
						'position'		=> (int)$a_matches[1][$i_pointer],
						'provider_id'	=> $provider_id,
						'published'		=> TRUE,
						'title'			=> $a_matches[2][$i_pointer],
					];
		$a_tmp['meal']
					= [
						'position'		=> (int)$a_matches[1][$i_pointer],
						'course_id'		=> NULL,
						'course_title'	=> $a_tmp['course']['title'],
						'published'		=> TRUE,
						'title'			=> $a_matches[3][$i_pointer],
						'number'		=> (int)$a_matches[4][$i_pointer],
						'weight'		=> (int)$a_matches[5][$i_pointer],
						'price'			=> (int)$a_matches[6][$i_pointer],
					];

/*
			$s_format	= 'num=%s course=%s name=%s id=%d weight=%s price=%d<br />';
			$res = sprintf($s_format,
				$i_num,
				$s_course,
				$s_name,
				$i_id,
				$i_weight,
				$i_price
			);
			echo $res;
*/
		return $a_tmp;
	}

	/**
	 * Find recognisable text within webpage content and turn the text into separacte courses and meals properties
	 *
	 * @param Array		$a_matches			raw matched records from webpage
	 * @param Integer	$provider_id		provider
	 *
	 * @return Array						courses with their properties
	 */
	private static function _getCoursesMeals(Array $a_matches, Int $provider_id) : Array
	{
		$a_courses		= [];
		$a_meals		= [];
		for ($i = 0; $i < count($a_matches[0]); $i++)
		{
			$a_res					= self::_matchCourseAndMeal($a_matches, $i, $provider_id);
			$s_title				= $a_res['course']['title'];
			$a_courses[$s_title]	= $a_res['course'];

			$s_title				= $a_res['meal']['title'];
			$a_meals[$s_title]		= $a_res['meal'];
		}
		$a_res			= [
							'course'	=> $a_courses,
							'meal'		=> $a_meals,
							];
		return $a_res;
	}

	/**
	 * Find recognisable text within webpage content and turn the text into separacte courses and meals properties
	 * Save courses that are not already in DB
	 *
	 * @param String	$s_type				type that matches the table name
	 * @param Array		$a_items_new		items found at webpage
	 * @param String	$s_parent			parent name
	 * @param Array		$a_parent			parent identifier(s)
	 *
	 * @return void
	 */
	private static function _checkAndCreateItems(String $s_type, Array $a_items_new, String $s_parent, Array $a_parent) : void
	{
		$a_items		= self::getIdTitleForParent($s_type, NULL, $s_parent, $a_parent);
		$a_titles		= array_keys($a_items_new[$s_type]);
		$a_new			= array_values(array_diff($a_titles, $a_items));

		$s_model		= self::getModelNameWithNamespace($s_type);

		for ($i = 0; $i < count($a_new); $i++)
		{
			$s_title	= $a_new[$i];
			$a_data		= $a_items_new[$s_type][$s_title];

			$o_tmp		= new $s_model;
			$o_tmp->fill($a_data);
			$o_tmp->save();
		}
	}

	/**
	 * assign course_id foreign key value to each meal
	 * @param String	$s_target		items to add other items ids
	 * @param String	$s_source		items to get ids from
	 * @param Array		$a_items		items from webpage
	 * @param Array		$a_db			items from DB
	 *
	 * @return Array					updated $a_items with course foreign key
	 */
	private static function _linkItemsWithIdsFromDB(String $s_target, String $s_source, Array $a_items, Array $a_db) : Array
	{
		foreach ($a_items[$s_target] AS $s_title => $a_data)
		{
			$s_tmp	= ($s_target != $s_source ? $s_source . '_' : '');
			$i_cid	= array_search($a_data[$s_tmp . 'title'], $a_db);
			if ($i_cid !== FALSE)
			{
				$a_items[$s_target][$s_title][$s_source . '_' . 'id']	= $i_cid;
			}
		}
		return $a_items;
	}

	/**
	 * assign course_id foreign key value to each meal
	 * @param Array		$a_items		items from webpage
	 * @param Array		$a_courses		courses from DB
	 *
	 * @return Array					updated $a_items with course foreign key
	 */
	private static function _linkCoursesAndMeals(Array $a_items, Array $a_courses) : Array
	{
		$a_items	= self::_linkItemsWithIdsFromDB('meal', 'course', $a_items, $a_courses);
		return $a_items;
	}

	/**
	 * assign meal’s foreign key as id value to each meal
	 * @param Array		$a_items		items from webpage
	 * @param Array		$a_meals		meals from DB
	 *
	 * @return Array					updated $a_items with meal id
	 */
	private static function _linkMealsAndMeals(Array $a_items, Array $a_meals) : Array
	{
		$a_items	= self::_linkItemsWithIdsFromDB('meal', 'meal', $a_items, $a_meals);
		return $a_items;
	}

	/**
	 * assign course_id foreign key value to each meal
	 * @param Array		$a_items			items from webpage
	 * @param Integer	$provider_id		provider
	 * @param Object	$o_date				date whem meal is available for ordering
	 *
	 * @return void
	 */
	private static function _fillDailyMenu(Array $a_items, Int $provider_id, Object $o_date) : void
	{
		$o_items		= Plate::getItems($provider_id, $o_date);

		$a_titles		= array_keys($a_items);
		$a_new			= array_values(array_diff($a_titles, $o_items->pluck('title')->toArray()));

		for ($i = 0; $i < count($a_new); $i++)
		{
			$s_title			= $a_new[$i];
			$a_data				= $a_items[$s_title];
			$a_data['date']		= $o_date;
			$o_tmp		= new Plate;
			$o_tmp->fill($a_data);
			$o_tmp->save();
		}
	}

	/**
	 * Parse provider’s web-page for updates in menu
	 * @param Integer	$provider_id		provider’s identifier
	 * @param String	$s_url_read			webpage URL
	 *
	 * @return Boolean						success/failure
	 */
	private static function _parseDay(Int $provider_id, String $s_url_read) : Bool
	{
		$s_content			= self::getFileContent($s_url_read);

		$s_text				= self::_getText($s_content);

		if (empty($s_text))
		{
			/**
			 *	inform and stop
			 */
			self::writeLog('warning', 'Not found: webpage is empty. provider=' . $provider_id);
			return FALSE;
		}

		$a_matches			= self::_getMatches($s_text);
		if (count($a_matches[0]) < 1)
		{
			self::writeLog('warning', 'No meals for the day. provider=' . $provider_id . ' url=' . $s_url_read );
			return FALSE;
		}

		$o_date				= self::_getDate($s_content);

		if (empty($o_date))
		{
			self::writeLog('warning', 'Empty date. provider=' . $provider_id . ' url=' . $s_url_read );
			return FALSE;
		}

		$a_items			= self::_getCoursesMeals($a_matches, $provider_id);

		$s_parent_key		= 'provider';
		$a_parent_ids		= array($provider_id);
		self::_checkAndCreateItems('course', $a_items, $s_parent_key, $a_parent_ids);
		$a_courses			= self::getIdTitleForParent('course', NULL, $s_parent_key, $a_parent_ids);
		$a_items			= self::_linkCoursesAndMeals($a_items, $a_courses);

		$s_parent_key		= 'course';
		$a_parent_ids		= array_keys($a_courses);
		self::_checkAndCreateItems('meal', $a_items, $s_parent_key, $a_parent_ids);
		$a_meals			= self::getIdTitleForParent('meal', NULL, $s_parent_key, $a_parent_ids);
		$a_items			= self::_linkMealsAndMeals($a_items, $a_meals);

		self::_fillDailyMenu($a_items['meal'], $provider_id, $o_date);

		return TRUE;
	}
}
