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
		'meal_id',
		'published',
		'date',
		'position',
		'weight',
		'price',
		'number',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
	];

	/**
	 * Get meal available for ordering at specified date by selected provider
	 * @param Integer	$provider_id		provider
	 * @param Object	$o_date				date whem meal is available for ordering
	 *
	 * @return Object						collection of meals with courses
	 */
	public static function getItems(Int $provider_id, Object $o_date) : Object
	{
		$s_type			= 'plate';
		$s_model		= ucfirst($s_type);
		$s_model		= '\Modules\\' . $s_model . '\\' . 'Database' . '\\' . $s_model;
		$fn_select		= $s_model . '::select';

#        $o_query = $fn_select
        $o_query = self::select
        			(
						'plates.id'
						, 'plate_translations.title as title'
						, 'meals.id AS meal_id'
						, 'courses.id AS course_id'
						, 'providers.id AS provider_id'
        			)
            ->leftJoin('plate_translations', function($join) {
                $join->on('plate_translations.plate_id', '=', 'plates.id')
                    ->where('locale', '=', app()->getLocale());
            })
            ->join('meals', 'plates.meal_id', '=', 'meals.id')
            ->join('courses', 'courses.id', '=', 'meals.course_id')
            ->leftJoin('providers', function($join) {
                $join->on('courses.provider_id', '=', 'providers.id');
            })
            ->whereDate('date', '=', $o_date)
#            ->whereDate('date', '=', Carbon::parse('2020-05-05'))
            #->get()
            ;
        /*
		$o_items		= $fn_select()->with('meal')
#		->whereProviderId($provider_id)
		->get()
		;#->pluck('title');
		*/
#dd($o_query);
		return $o_query->get();
	}

    public function mealCourse()
    {
        return $this->hasOneThrough('Modules\Course\Database\Course', 'Modules\Meal\Database\Meal');
    }

	public function meal()
	{
		return $this->belongsTo('Modules\Meal\Database\Meal');
	}

    public function provider()
    {

        return $this
                ->join('meals', 'plates.meal_id', '=', 'meals.id')
                ;
    	dd($this);

    	dump($res);
    	return $res;
        return $this->hasOneThrough('Modules\Provider\Database\Provider', 'Modules\Meal\Database\Meal');
    }

}
