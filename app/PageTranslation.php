<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{

	protected $fillable = [
		'name',
		'excerpt',
		'body',
		'meta_title',
		'meta_keywords',
		'meta_description',
	];


	public $timestamps = false;

	protected static function boot()
	{
		static::saving(function ($model) {
			$model->meta_title = Str::limit($model->meta_title ?: $model->name, 160);
			$model->meta_keywords = $model->meta_keywords ?: '';
			$model->meta_description = $model->meta_description ?: Str::limit(strip_tags($model->body), 160);
		});
	}
}
