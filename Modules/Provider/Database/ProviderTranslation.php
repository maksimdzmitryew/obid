<?php

namespace Modules\Provider\Database;

use App\Model;
#use Illuminate\Database\Eloquent\Model;

class ProviderTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
		'address',
		'description',
	];

	public $a_form = [
		'title'			=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'required|string|max:255',
		],
		'address'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'required|string|max:255',
		],
		'description'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
		],
	];
}
