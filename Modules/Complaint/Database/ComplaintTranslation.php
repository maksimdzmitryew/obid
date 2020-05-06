<?php

namespace Modules\Complaint\Database;

use App\Model;
#use Illuminate\Database\Eloquent\Model;

class ComplaintTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
		'annotation',
		'description',
		'address',
		'response',
	];

	public $a_form = [
		'title'			=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'required|string|max:191',
		],
		'annotation'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:191',
		],
		'description'	=> [
			'tab'		=> 'data',
			'field'		=> 'textarea',
			'rules'		=> 'string|max:10000',
		],
		'response'	=> [
			'tab'		=> 'data',
			'field'		=> 'textarea',
			'rules'		=> 'string|max:10000',
		],
	];
}
