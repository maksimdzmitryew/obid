<?php

namespace Modules\Issue\Database;

use App\Model;

class Issue extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'element_id',
		'published',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'element_ids'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> '',
		],
		'published'		=> [
			'tab'		=> 'manage',
			'field'		=> 'checkbox',
			'rules'		=> '',
		],
	];

	public function element()
	{
		return $this->belongsToMany('Modules\Element\Database\Element');
	}
	public function report()
	{
		return $this->belongsToMany('Modules\Report\Database\Report');
	}
}
