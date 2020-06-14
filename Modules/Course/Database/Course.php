<?php

namespace Modules\Course\Database;

use                       Illuminate\Support\Carbon;
use              \Modules\Complaint\Database\Complaint;
use                \Modules\Element\Database\Element;
use                   \Modules\Mark\Database\Mark;
use                                      App\Model;

class Course extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'provider_id',
		'published',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'provider_id'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> 'required|integer',
		],
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
	];

}
