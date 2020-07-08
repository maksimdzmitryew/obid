<?php

namespace Modules\Demand\Database;

use                           Illuminate\Support\Carbon;
use       Illuminate\Database\Eloquent\Relations\HasMany;
use                                          App\Model;

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
