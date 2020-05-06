<?php

namespace App;

use App\Traits\Fileable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;

class FestivalTranslation extends Model
{
    use Fileable;
    use Sluggable;

    public $timestamps = false;

    protected $with = [
        'file'
    ];

    protected $fillable = [
        'name',
        'slug',
        'about_festival',
        'program_description',
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
        parent::boot();

        static::deleting(function($model) {
            $model->file->delete();
        });

        static::saving(function($model) {
            $model->slug = $model->slug ?: SlugService::createSlug(
                FestivalTranslation::class, 'slug', $model->name
            );

            $model->meta_title = Str::limit($model->meta_title ?: $model->name, 160);
            $model->meta_keywords = $model->meta_keywords ?: '';
            $model->meta_description = $model->meta_description ?: Str::limit(strip_tags($model->about_festival), 160);
        });
    }
}
