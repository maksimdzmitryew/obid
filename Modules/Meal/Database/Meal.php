<?php

namespace Modules\Meal\Database;

use                       Illuminate\Support\Carbon;
use              \Modules\Complaint\Database\Complaint;
use                \Modules\Element\Database\Element;
use                   \Modules\Mark\Database\Mark;
use                                      App\Model;

class Meal extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'course_id',
		'provider_id',
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

	public function course()
	{
		return $this->belongsTo('Modules\Course\Database\Course');
	}

	public function plate()
	{
		return $this->hasMany('Modules\Plate\Database\Plate');
	}
}
