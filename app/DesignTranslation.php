<?php

namespace App;

use App\Model;
#use Illuminate\Database\Eloquent\Model;

class DesignTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
		'description',
	];

	public $a_form = [
	];
}
