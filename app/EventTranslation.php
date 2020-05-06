<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;

class EventTranslation extends Model
{
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'locale',
        'description',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public $timestamps = false;

    public static function boot()
    {
        static::saving(function ($model) {
            $model->slug = $model->slug ?: SlugService::createSlug(
                EventTranslation::class, 'slug', $model->title #. '-' . $model->locale
            );

            $model->meta_title = Str::limit($model->meta_title ?: $model->title, 160);
            $model->meta_keywords = $model->meta_keywords ?: '';
            $model->meta_description = $model->meta_description ?: Str::limit(strip_tags($model->body), 160);
        });
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
