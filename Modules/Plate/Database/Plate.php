<?php

namespace Modules\Plate\Database;

use                       Illuminate\Support\Carbon;
use              \Modules\Complaint\Database\Complaint;
use                \Modules\Element\Database\Element;
use                   \Modules\Mark\Database\Mark;
use                                      App\Model;

class Plate extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'demand_id',
		'meal_id',
		'published',
		'date',
		'position',
		'weight',
		'price',
		'number',
	];
	public $translatedModel = 'meal';
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
/*
		'demand_ids'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> '',
		],
*/
	];

	/**
	 * Get meal available for ordering at specified date by selected provider
	 * @param Integer	$provider_id		provider
	 * @param Object	$o_date				date whem meal is available for ordering
	 *
	 * @return Object						collection of meals with courses
	 */
/*

$o_items		= Plate::select(['id', 'meal_id'])->whereDate('date', '=', $o_date)->get();

for ($i = 0; $i < $o_items->count(); $i++)
{
	$o_data		= $o_items->offsetGet($i);
	$a_items[]	= [
					'id'			=> $o_data->id,
					'title'			=> $o_data->meal->title,
					'meal_id'		=> $o_data->meal->id,
					'course_id'		=> $o_data->meal->course->id,
					'provider_id'	=> $o_data->meal->course->provider->id,
					];
}

----------------------- the below can be substituted with the above -----------------------

#		$o_items		= Plate::getItems($provider_id, $o_date);
#		$a_new			= array_values(array_diff($a_titles, $o_items->pluck('title')->toArray()));

	public static function getItems(Int $provider_id, Object $o_date) : Object
	{
		$s_type			= 'plate';
		$s_model		= ucfirst($s_type);
		$s_model		= '\Modules\\' . $s_model . '\\' . 'Database' . '\\' . $s_model;
		$fn_select		= $s_model . '::select';

        $o_query = self::select
        			(
						'plates.id'
#						, 'plate_translations.title as title'
						, 'meals.id AS meal_id'
						, 'meal_translations.title AS title'
						, 'courses.id AS course_id'
						, 'providers.id AS provider_id'
        			)
/ *
            ->leftJoin('plate_translations', function($join) {
                $join->on('plate_translations.plate_id', '=', 'plates.id')
                    ->where('locale', '=', app()->getLocale());
            })
* /
            ->join('meals', 'plates.meal_id', '=', 'meals.id')
            ->join('meal_translations', 'plates.meal_id', '=', 'meal_translations.meal_id')
            ->join('courses', 'courses.id', '=', 'meals.course_id')
            ->leftJoin('providers', function($join) {
                $join->on('courses.provider_id', '=', 'providers.id');
            })
            ->whereDate('date', '=', $o_date)
            ;
#dd($o_query->get()[0]->original);

		return $o_query->get();
	}
*/
	public function demand()
	{
		return $this->belongsToMany('Modules\Demand\Database\Demand');
	}

	public function meal()
	{
		return $this->belongsTo('Modules\Meal\Database\Meal');
	}

}
