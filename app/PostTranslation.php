<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PostTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->file->delete();
        });

        static::saving(function($model) {
            $model->slug = $model->slug ?: SlugService::createSlug(
                FestivalTranslation::class, 'slug', $model->title
            );

            $model->meta_title = Str::limit($model->meta_title ?: $model->title, 160);
            $model->meta_keywords = $model->meta_keywords ?: '';
            $model->meta_description = $model->meta_description ?: Str::limit(strip_tags($model->about_festival), 160);
        });
    }
}
