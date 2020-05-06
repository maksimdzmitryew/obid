<?php

namespace App;

use App\Model;
#use Illuminate\Database\Eloquent\Model;

class PointTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
		'annotation',
		'description',
		'address',
	];
	public $a_form = [
	];
}
