<?php

namespace Modules\Demand\Database;

use                       Illuminate\Support\Carbon;
use              \Modules\Complaint\Database\Complaint;
use                \Modules\Element\Database\Element;
use                   \Modules\Mark\Database\Mark;
use                                      App\Model;

class Demand extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
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
	];

	public function plate()
	{
		return $this->hasMany('Modules\Plate\Database\Plate');
	}

}
