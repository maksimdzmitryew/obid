<?php

namespace Modules\Place\Database;

use                       Illuminate\Support\Carbon;
use              \Modules\Complaint\Database\Complaint;
use                \Modules\Element\Database\Element;
use                   \Modules\Mark\Database\Mark;
use                                      App\Model;

class Place extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'building_id',
		'user_id',
		'lat',
		'lng',
		'published',
	];
    protected $casts = [
        'rating_info'	=> 'array',
    ];
	public $translatedAttributes = [];
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
		'building_id'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> 'required|integer',
		],
		'lat'		=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'numeric|between:-85.05112878,85.05112878', #regex:/^[+-]?\d+\.\d+$/
		],
		'lng'		=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'numeric|between:-999.9999999,999.9999999', #regex:/^-?\d{1,2}\.\d{6,}$/
		],
	];

	/**
	 * Calculate rating for each place and save to DB
	 * First we check if items to be calculated for can be found
	 * Then call supporting function to do the actual calculations
	 *
	 * @return void
	 */
	public static function calculateRating() : void
	{
		$i_update_freq = 24;
		$o_sql		= self::wherePublished(1)
						->where('rating_last', '<', Carbon::now()->subHour($i_update_freq))
						->with(['opinion', 'vote'])
						;

		if ($o_sql->count() > 0)
			self::_calculateRating($o_sql);
	}

	/**
	 * Do the actual calculation of rating
	 * @param Object	$o_sql			Items query to get items and calculate rating for
	 *
	 * @return void
	 */
    private static function _calculateRating(Object $o_sql) : void
    {
		$i_lowest_allowed 	= 35;
		$i_emails_per_day	= 1;
		$i_batch_update		= 50;
		$i_min_opinions		= 1;

		$a_data		= $o_sql
						->limit($i_batch_update)
						->get()
					;

		$a_marks	= Mark::wherePublished(1)->where('qty', '>', '0')->get()->pluck('qty', 'id')->toArray();
		$i_mark_max = max($a_marks);
		$i_mark_min = min($a_marks);
		$a_elements	= Element::get()->pluck('title', 'id')->toArray();
		$a_update	= ['rating_info', 'rating_all', 'rating_min', 'complaint_qty', 'rating_last',];

		for ($i = 0; $i < count($a_data); $i++)
		{
			$o_place = $a_data[$i];

			$o_place->rating_last		= Carbon::now();

			$a_rating	= [];
			$a_rating	= self::_sumAllVotes($o_place['vote'], $a_marks);
			$a_rating	= self::_setAverageTotal($a_rating, $a_elements, $i_mark_max, $i_mark_min);

			$i_tmp		= $o_place['opinion']->count();
			$a_rating['overall']['latest_opinion'] = '';
			for ($j = $i_tmp; $j > 0; $j--)
			{
				if (!empty($o_place['opinion'][$j]['description']))
				{
					$a_rating['overall']['latest_opinion'] = $o_place['opinion'][$j]['description'];
					break;
				}
			}

			$o_place->rating_all		= $a_rating['overall']['percent'];
			$o_place->rating_min		= $a_rating['lowest']['elements'];
			unset($a_rating['overall']['percent']);
			unset($a_rating['lowest']);

			$o_place->rating_info		= json_encode($a_rating);

			$b_send		= TRUE;
			$b_send		= $b_send && (
							/**
							 * Place overall rating (in percent) is lower than the allowed threshold
							 */
							$o_place->rating_all > -1
							&& $o_place	->rating_all < $i_lowest_allowed
							||
							/**
							 * One of the place's elements rating (in percent) is lower than the allowed threshold
							 */
							$o_place->rating_min > -1
							&& $o_place	->rating_min < $i_lowest_allowed
						);
			/**
			 * Qty of active complaints already sent for this place
			 * Responses not received so far
			 * Also update complaints counter, just in case it's outdated
			 */
			$o_place->complaint_qty = Complaint::select('id')->wherePublished(1)->wherePlaceId($o_place->id)->count();
			$b_send		= $b_send && ($o_place->complaint_qty < 1);
			/**
			 * Delay for sending new complaints
			 * The delay date should be in the past
			 * Calculated as the date when received response from last authority for the latest complaint
			 * plus 30 days
			 * (See Complaint Model for details)
			 */
			$b_send		= $b_send && ($o_place->complaint_delay < Carbon::now());
			/**
			 * Daily limit for sending new complaints
			 */
			$b_send		= $b_send && (Complaint::select('created_at')->whereDate('created_at', '=', Carbon::today())->count() < $i_emails_per_day);
			/**
			 * At least this much unique opinions (votes) were cast for place's elements
			 */
			$b_send		= $b_send && ($a_rating['overall']['votes'] >= $i_min_opinions);

			if ($b_send)
			{
				$s_tmp = implode(', ', $a_rating['issues']);
				Complaint::sendIt($o_place, $s_tmp);
				$a_update['complaint_qty']		= $o_place->complaint_qty;
			}

			/**
			 * compute array to be used as update data
			 * includes (re-)calculated rating if necessary
			 * and new value for date when the rating was last checked and updated
			 */
			$a_tmp = array_intersect_key($o_place->toArray(),array_flip($a_update));

			$o_place->update($a_tmp);
		}
	}


	/**
	 * Unify marks description for all elements
	 *
	 * @param String	$s_format_set	Format describing placement of information
	 * @param Array		$a_format_val	values (aka marks) to be formatted
	 *
	 * @return Array					mark as key and qty as value
	 */
	private static function _getMarkDescription(String $s_format_set, Array $a_format_val) : String
	{
		return vsprintf($s_format_set, $a_format_val);
	}

	/**
	 * Go through all marks and calculate average points
	 * for each element and for the place in general
	 *
	 * @param Array		$a_rating		All votes organised per element and per place
	 * @param Array		$a_elements		All elements that can be voted for
	 * @param Integer	$i_mark_max		Maximum posible value for a single mark
	 *
	 * @return Array					mark as key and qty as value
	 */
	private static function _setAverageTotal(Array $a_rating, Array $a_elements, Int $i_mark_max, Int $i_mark_min) : Array
	{
		$a_res				=
							[
							'element'	=> [],
							'lowest'	=>
										[
										'elements' => -1,
										],
							'overall'	=>
										[
										'percent' => -1,
										],
							'issues'	=> [],
							];
		$i_overall_value	= 0;
		$i_overall_votes	= 0;
		$i_total_elements	= 0;
		$a_each_element		= [];
		foreach ($a_rating AS $i_element_id => $a_marks)
		{
			foreach ($a_marks AS $i_mark_value => $i_mark_qty)
			{
				$i_sum_value = 0;
				$i_sum_votes = 0;

				$i_sum_value += $i_mark_value;
				$i_sum_votes += $i_mark_qty;
				if ($i_sum_votes > 0 && $i_mark_max > 0)
				{
					$i_tmp = $i_sum_value / $i_sum_votes;
					$i_percent = ($i_tmp-$i_mark_min) / ($i_mark_max-$i_mark_min) * 100;
					$a_each_element[] = $i_percent;

					if ($i_percent < 35)
						$a_res['issues'][] = $a_elements[$i_element_id];

					$a_res['element'][] =
						[	'percent'		=> round($i_percent),
							'votes'			=> $i_sum_votes,
							'average'		=> $i_tmp,
							'description'	=> self::_getMarkDescription(
								trans('mark::crud.rating.element'),
								[
								$a_elements[$i_element_id],
								Place::formatNumber($i_tmp, 1),
								Place::formatNumber($i_sum_votes),
								]
							),
						]
							;
					$i_overall_value += $i_tmp;
					$i_total_elements++;
					if ($i_sum_votes > $i_overall_votes)
						$i_overall_votes = $i_sum_votes;
				}
			}
		}

		if (count($a_each_element) > 0)
			$a_res['lowest']['elements'] = min($a_each_element);

		/**
		 * Total rating for the place
		 * is based on the rating of all elements' rating
		 */
		if ($i_overall_votes > 0 && $i_mark_max > 0)
		{
			$i_tmp = $i_overall_value / $i_total_elements;
			$i_overall = ($i_tmp-$i_mark_min) / ($i_mark_max-$i_mark_min) * 100;
#			$i_tmp = $i_mark_max * ($i_overall / 100);
			$a_res['overall']['percent'] = round($i_overall);
			$a_res['overall']['votes'] = $i_overall_votes;
			$a_res['overall']['average'] = $i_tmp;
			$a_res['overall']['description'] = self::_getMarkDescription(
						trans('mark::crud.rating.overall'),
						[
						trans('mark::crud.rating.summary'),
						Place::formatNumber($i_overall),
						]
					);
			$a_res['overall']['details'] = self::_getMarkDescription(
						trans('mark::crud.rating.details'),
						[
						Place::formatNumber($i_tmp, 1),
						Place::formatNumber($i_mark_max),
						Place::formatNumber($i_overall_votes),
						]
					);
		}
		return $a_res;
	}

	/**
	 * Take each vote value (aka mark)
	 * calculate qty of each mark
	 * the same value marks that are considered as kind "the same" mark
	 * so they are summarized together
	 *
	 * @param Array		$a_votes		All votes casted for this place
	 * @param Array		$a_marks		Weight of each mark in points
	 *
	 * @return Array					mark as key and qty as value
	 */
	private static function _sumAllVotes($a_votes, $a_marks) : Array
	{
		$a_rating = [];
		for ($i = 0; $i < count($a_votes); $i++)
		{
			$a_vote			= $a_votes[$i];
			$i_mark_id		= $a_vote['mark_id'];
			$i_element_id	= $a_vote['element_id'];

			if (isset($a_marks[$i_mark_id]))
			{
				$i_mark_value	= $a_marks[$i_mark_id];
				if (!isset($a_rating[$i_element_id][$i_mark_value]))
					$a_rating[$i_element_id][$i_mark_value] = 0;

				$a_rating[$i_element_id][$i_mark_value]++;
			}
		}
		return $a_rating;
	}

    public function opinion()
    {
        return $this->HasMany('Modules\Opinion\Database\Opinion');
    }
    public function vote()
    {
        return $this->HasMany('Modules\Opinion\Database\OpinionVote');
    }

	public function building()
	{
		return $this->belongsTo('Modules\Building\Database\Building');
	}
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
