<?php

namespace Modules\Country\Database;

use App\Model;

class CountryTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
	];

	public $a_form = [
		'title'			=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'required|string|max:255',
		],
	];
}
