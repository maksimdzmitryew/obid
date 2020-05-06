<?php

namespace Modules\Opinion\Database;

use                                      App\Model;

class OpinionVote extends Model
{
	public $translationModel = '\Modules\Opinion\Database\OpinionTranslation';
	protected $connection = 'psc';
	protected $fillable = [
		'element_id',
		'mark_id',
		'opinion_id',
		'place_id',
		'user_id',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		/**
		 * although this model does not have visual represention
		 * neither it can be filled via dedicated form
		 * however
		 * we need to keep fields' and rules' descripton
		 * so parent form of opinion knows how to interpret every field
		*/
		'element_id'		=> [
			'tab'		=> '',
			'field'		=> '',
			'rules'		=> 'required|integer',
		],
		'mark_id'		=> [
			'tab'		=> '',
			'field'		=> '',
			'rules'		=> 'required|integer',
		],
		'place_id'		=> [
			'tab'		=> '',
			'field'		=> '',
			'rules'		=> 'required|integer',
		],





	];

    public $timestamps = false;
	public function element()
	{
		return $this->belongsTo('Modules\Element\Database\Element');
	}
	public function mark()
	{
		return $this->belongsTo('Modules\Mark\Database\Mark');
	}
	public function opinion()
	{
		return $this->belongsTo('Modules\Opinion\Database\Opinion');
	}
	public function place()
	{
		return $this->belongsTo('Modules\Place\Database\Place');
	}
	public function user()
	{
		return $this->belongsTo('App\User');
	}




}
