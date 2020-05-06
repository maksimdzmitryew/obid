<?php

namespace Modules\Opinion\Database;

use                                      App\Model;
#use Illuminate\Database\Eloquent\Model;

class OpinionTranslation extends Model
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
			'rules'		=> 'string|max:255',
		],
		'description'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:2000',
		],
	];
}
