<?php

namespace App;

use Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class File extends Model
{
	protected $connection = 'usu';
	protected $fillable = [
		'alt',
		'title',
		'type',
		'path',
		'path_medium',
		'path_small',
		'position',
		'size',
		'savedname',
		'url',
		'url_medium',
		'url_small',
	];

	protected $hidden = [
		'fileable_type',
		'fileable_id'
	];

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('position');
		});

		static::deleted(function($model) {
			Storage::delete($model->path);

			if($model->path_medium){
				Storage::delete($model->path_medium);
			}

			if($model->path_small){
				Storage::delete($model->path_small);
			}
		});
	}

	public function fileable()
	{
		return $this->morphTo();
	}

	public function scopeType($query, $type)
	{
		return $query->where('type', $type);
	}

	public static function getRelativeStoragePath($today)
	{
		return 'public/' . $today->year . '/' . $today->month . '/';
	}

	public static function getFilePath($today)
	{
		return '/storage/' . $today->year . '/' . $today->month . '/';
	}

	public function showImage(String $image_size)
	{
		# https://stackoverflow.com/questions/29300331/laravel-responsedownload-to-show-images-in-laravel
		/*
		Storage::download() allows you to inject HTTP headers into the response. By default, it includes
		a sneaky 'Content-Disposition:attachment', this is why your browser doesn't "display" the picture, and triggers download instead
		You want to turn that into a 'Content-Disposition:inline'.
		Here's how to overwrite it:
		*/
		/*
		# Overwrite the annoying header
		*/
		$s_path = 'path';
		if ($image_size != '')
			$s_path .= '_' . $image_size;
		$headers = array(
			'Content-Disposition' => 'inline',
		);
		return Storage::download($this->{$s_path}, Str::ascii($this->savedname['savedname']), $headers);
	}

	public function downloadImage()
	{
		return response()->download(getcwd() . $this->url, $this->savedname['savedname'], [ 'Content-Type' => Storage::getMimeType($this->path) ]);
	}

	function getSmallImageUrlAttribute($value){
		return $value ? $value : '/admin/images/no-image-logo.jpg';
	}
}
