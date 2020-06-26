<?php

namespace Modules\Provider\API;

use                                      Carbon\Carbon;
use                     Modules\Course\Database\Course as Course;
use                                  App\Traits\FileTrait;
use                       Modules\Meal\Database\Meal;
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
		$a_items	= self::select('id')->wherePublished(1)->limit(25)->get();
		self::_parseDay($a_items[0]->id);
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
	 * @return String						date formatted as 'Y-m-d'
	 */
	private static function _getDate(String $s_content) : String
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
			$s_date = $a_matches[1][0];

		$s_date		= Carbon::parse($s_date)->format('Y-m-d');

		return $s_date;
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

		#		$s_regexps	= '((\b\w{1,}|\b\w{1,}\s{1,}\w{1,}|\b\w{1,}\s{1,}\w{1,}\s{1,}\w{1,})\sУкраїни|цього Кодексу)';
		preg_match_all('~' . $s_regexps . '~iu', $s_text, $a_matches);


		#<tr><td class="ttdd1s">1</td><td class="ttdd2s">Салаты</td><td class="ttdd3s">Салат из свежих овощей с маслом растительным (огурец, помидор, масло раст.)  [591]</td><td class="ttdd4s" align="center"><input class="input1" readonly type="text" value="150"></td><td class="ttdd5s" align="center"><input readonly class="input1" type="text" id="c11" value="22" align="center" onkeyup="document.getElementById('result1').innerHTML = (parseFloat(this.value)||0) * (parseFloat(document.getElementById('x11').value)||0); "></td><td class="ttdd6s" align="center"><input style="text-align:center; background: #CCCCCC;" class="mokrec" type="text" size="2" name="1" id="x11" onkeyup="document.getElementById('result1').innerHTML = (parseFloat(this.value)||0) * (parseFloat(document.getElementById('c11').value)||0)"></td><td class="ttdd7s" align="center" style="font-weight:bold;" name="result1" id="result1"></td></tr>
		echo '<pre>';
		var_dump($a_matches);
		echo '</pre>';
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
						'provider_id'	=> $provider_id,
						'published'		=> TRUE,
						'title'			=> $a_matches[3][$i_pointer],
						'id'			=> (int)$a_matches[4][$i_pointer],
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
	 * @param Array		$a_matches			raw matched records from webpage
	 * @param Integer	$provider_id		provider
	 *
	 * @return void
	 */
	private static function _checkAndCreateItems(String $s_type, Array $a_items, Int $provider_id) : void
	{
		$a_titles		= array_keys($a_items[$s_type]);
		$s_model		= ucfirst($s_type);
		$s_model		= '\Modules\\' . $s_model . '\\' . 'Database' . '\\' . $s_model;
		$fn_select		= $s_model . '::select';
		$o_items		= $fn_select()->whereProviderId($provider_id)->get()->pluck('title');

#dd($s_type, $a_res, $a_titles, $a_items[$s_type]);


		#$a_res	=	self::getIdTitle($request, NULL, 'Course', TRUE, [], [], TRUE, FALSE);

		#$a_res	=	Course::select('id')->whereIn('title', $a_courses)->pluck('title', 'id');
#		$o_items		=	Course::select()->whereProviderId($provider_id)->get()->pluck('title');
		#dd($o_courses);
		#$o_course	=	Course::select()->whereProvider()->pluck('title', 'id');

		$a_new			= array_diff($a_titles, $o_items->toArray());
#dump($a_new);
		for ($i = 0; $i < count($a_new); $i++)
		{
			$s_title	= $a_new[$i];
			$a_data		= $a_items[$s_type][$s_title];

			$o_tmp		= new $s_model;
			$o_tmp->fill($a_data);
			$o_tmp->save();

#dd($s_title, $a_data);
/*
			$a_tmp	= [
							'provider_id'	=> $provider_id,
							'published'		=> TRUE,
							'title'			=> $a_new[$i],
						];
*/
		#	$a_insert[]	= $o_tmp;
		#	$a_insert[]	= $a_tmp;
		}
		#Course::insert($a_insert);
		#Course::createMany($a_insert);
		#dd($a_insert);
		#Course::create($a_insert);
		#$a_insert[0]->save();

	}

	/**
	 * Parse provider’s web-page for updates in menu
	 * @param Integer	$provider_id		provider’s identifier
	 *
	 * @return void
	 */
	private static function _parseDay(Int $provider_id = 4) : void
	{
#		$s_url_read	= 'http://obed.in.ua/menu/ponedelnik/index.php';
		$s_url_read			= 'http://obed.in.ua/menu/vtornik/index.php';
		$s_content			= self::getFileContent($s_url_read);

		$s_text				= self::_getText($s_content);

		if (empty($s_text))
		{
			/**
			 *	inform and stop
			 */
			self::writeLog('critical', 'Not found: webpage is empty. provider=' . $provider_id);
		}
#dd($s_text);

		$a_matches			= self::_getMatches($s_text);
		if (count($a_matches[0]) < 1)
		{
			self::writeLog('critical', 'No meals for the day. provider=' . $provider_id . ' url=' . $s_url_read );
		}

		$s_date				= self::_getDate($s_content);

		if (empty($s_date))
		{
			self::writeLog('critical', 'Empty date. provider=' . $provider_id . ' url=' . $s_url_read );
		}

		$a_items			= self::_getCoursesMeals($a_matches, $provider_id);

		self::_checkAndCreateItems('course', $a_items, $provider_id);
		$o_courses			=	Course::select()->get()->pluck('title', 'id');

		/**
		 *	assign course_id foreign key value to each meal
		 */
		foreach ($a_items['meal'] AS $s_title => $a_data)
		{
			$i_cid = array_search($a_data['course_title'], $o_courses->toArray());
			if ($i_cid !== FALSE)
			{
				$a_items['meal'][$s_title]['course_id']	= $i_cid;
			}
		}
		self::_checkAndCreateItems('meal', $a_items, $provider_id);

#		$a_courses			= array_keys($a_items['courses']);
#		$a_meals			= array_keys($a_items['meals']);

#		self::_checkExistingCoursesTitles($a_matches, $provider_id);
		$o_meals			=	Meal::select()->get()->pluck('title', 'id');

dd($s_date, $s_text, $a_items, $o_courses, $o_meals);#, $a_courses, $a_meals);




#dd($events->toSql(), $events->getBindings());
dd($a_courses, $a_res, $a_tmp, $a_insert);
die();




dd($s_text, $s_content);
		die('ok');
	}
}
