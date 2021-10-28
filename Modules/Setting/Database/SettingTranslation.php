<?php

namespace Modules\Setting\Database;

use App\Model;
#use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
		'translated_value',
	];

	public $a_form = [
		'title'			=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:30',
		],
		'translated_value'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:191',
		],
	];
}
