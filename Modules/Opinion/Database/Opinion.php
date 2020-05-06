<?php

namespace Modules\Opinion\Database;

use                                      App\Model;
use   Illuminate\Database\Eloquent\Relations\HasMany;

class Opinion extends Model
{
	protected $connection = 'psc';
	protected $fillable = [



		'place_id',
		'user_id',
		'published',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],










		'place_id'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> 'required|integer',
		],
	];















	public function place()
	{
		return $this->belongsTo('Modules\Place\Database\Place');
	}
	public function user()
	{
		return $this->belongsTo('App\User');
	}
    public function vote() : HasMany
    {
        return $this->HasMany('Modules\Opinion\Database\OpinionVote');
#		return $this->hasMany('Modules\Opinion\Database\OpinionVote');
    }
}
