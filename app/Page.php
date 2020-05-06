<?php

namespace App;

use                           App\Traits\GeneralTrait;
use         Illuminate\Database\Eloquent\Model;
use    Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use              Astrotomic\Translatable\Translatable;
use          Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;

class Page extends Model
{
	use GeneralTrait;
	use Translatable;
    use Sluggable;

    protected $fillable = [
        'published',
		'slug',
    ];

	public $translatedAttributes = [
		'name',
		'excerpt',
		'body',
		'meta_title',
		'meta_keywords',
		'meta_description',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published'         => 'boolean',
    ];

	protected static function boot()
	{
		static::saving(function ($model) {
			$model->slug = $model->slug ?: SlugService::createSlug(
				Page::class, 'slug', $model->name #. '-' . $model->locale
			);
		});
	}

	public function scopeFilter($query, $filters)
	{
		return $filters->apply($query);
	}

	public function sluggable()
	{
		return [
			'slug' => [
				'source' => 'name'
			]
		];
	}

}
