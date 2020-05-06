<?php

namespace App;

use App\Model;
#use App\DesignTranslation;

class Design extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
#		'issue_id',
		'published',
	];

	public $a_form = [
	];
#	public $translatedAttributes = [];
#    protected static function boot()
/*
	public function __construct()
	{
		parent::__construct();
	}
*/
/*
#	public function store()
	{
		dump($this->translatedAttributes);
		$m = new DesignTranslation;
#		$this->translatedAttributes = $m->getFillable();
	    $this->translatedAttributes = array_merge($this->translatedAttributes, $m->getFillable());
		dump($this->translatedAttributes);
	}
*/
	public function issue()
	{
		return $this->belongsToMany('Modules\Issue\Database\Issue');
	}
/*
	public function points()
	{
		return $this->belongsToMany('App\Point');
	}
*/
/*
	public function scopeFilter($query, $filters)
	{
		return $filters->apply($query);
	}
*/
}
