<?php

namespace Modules\Provider\Database;

use                       Illuminate\Support\Carbon;
use              \Modules\Complaint\Database\Complaint;
use                \Modules\Element\Database\Element;
use                   \Modules\Mark\Database\Mark;
use                                      App\Model;

class Provider extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'day_1',
		'day_2',
		'day_3',
		'day_4',
		'day_5',
		'published',
		'url',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
		'url'		=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
			'default'	=>	'',
		],
		'day_1'		=> [
			'tab'		=> 'days',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
			'default'	=>	'',
		],
		'day_2'		=> [
			'tab'		=> 'days',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
			'default'	=>	'',
		],
		'day_3'		=> [
			'tab'		=> 'days',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
			'default'	=>	'',
		],
		'day_4'		=> [
			'tab'		=> 'days',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
			'default'	=>	'',
		],
		'day_5'		=> [
			'tab'		=> 'days',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
			'default'	=>	'',
		],
	];
	public function course()
	{
		return $this->hasOne('Modules\Course\Database\Course');
	}

	public function meal()
	{
		return $this->hasOne('Modules\Meal\Database\Meal');
	}

    public function plate()
    {
        return $this->hasManyThrough('Modules\Plate\Database\Plate', 'Modules\Meal\Database\Meal');
    }
}
