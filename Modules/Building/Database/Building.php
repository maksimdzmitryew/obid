<?php

namespace Modules\Building\Database;

use App\Model;

class Building extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'style_id',
		'published',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> '',
		],
		'style_id'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> '',
		],
	];

	public function style()
	{
		return $this->belongsTo('Modules\Style\Database\Style');
	}
}
