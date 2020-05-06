<?php

namespace Modules\Report\Database;

use App\Model;

class ReportTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
		'description',
	];

	public $a_form = [
		'title'			=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> '',
		],
		'description'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> '',
		],
	];
}
