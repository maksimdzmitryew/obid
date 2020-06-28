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
		'date',
		'published',
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

	public function meal()
	{
		return $this->belongsTo('Modules\Meal\Database\Meal');
	}

}
