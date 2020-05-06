<?php

namespace Modules\Mark\Database;

use App\Model;

class Mark extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'qty',
		'published',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> '',
		],
		'qty'		=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'required|numeric|between:0,10',
		],
	];
}
