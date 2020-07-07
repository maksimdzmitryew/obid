<?php

namespace Modules\Demand\Database;

use                       Illuminate\Support\Carbon;
use              \Modules\Complaint\Database\Complaint;
use                \Modules\Element\Database\Element;
use   Illuminate\Database\Eloquent\Relations\HasMany;
use                   \Modules\Mark\Database\Mark;
use                                      App\Model;

class Demand extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'user_id',
		'plate_id',
		'published',
	];

	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
/*
		'plate_ids'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> '',
		],
*/
	];

	public function plate()
	{
		return $this->belongsToMany('Modules\Plate\Database\Plate');
	}

}
