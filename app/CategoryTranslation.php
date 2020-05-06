<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryTranslation extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug'
    ];

    public $timestamps = false;

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
                CategoryTranslation::class, 'slug', $model->name
            );
        });
    }
}
