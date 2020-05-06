<?php

namespace Modules\Element\Database;

use App\Model;

class Element extends Model
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
		'style_ids'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> '',
		],
	];

	public function style()
	{
		return $this->belongsToMany('Modules\Style\Database\Style');
	}
}
