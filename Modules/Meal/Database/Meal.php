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

}
