<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BookTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'description',
        'volume',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected static function boot()
    {
        static::saving(function ($model) {
            $model->slug = $model->slug ?: SlugService::createSlug(
                BookTranslation::class, 'slug', $model->name
            );

            $model->meta_title = Str::limit($model->meta_title ?: $model->name, 160);
            $model->meta_keywords = $model->meta_keywords ?: '';
            $model->meta_description = $model->meta_description ?: Str::limit(strip_tags($model->description), 160);
        });
    }
}
