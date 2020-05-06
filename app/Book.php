<?php

namespace App;

use App\Festival;
use App\Traits\Imageable;
use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Imageable;
    use GeneralTrait;
    use Translatable;

    protected $fillable = [
        'url',
        'api_code',
        'festival_id',
        'gallery_id',
    ];

    public $translatedAttributes = [
        'name',
        'slug',
        'excerpt',
        'volume',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    protected $with = [
        'image'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function($model) {
            if($model->images)
                File::destroy($model->images->pluck('id')->toArray());
        });
    }

    public function gallery()
    {
        return $this->belongsTo('App\Gallery');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function authors()
    {
        return $this->belongsToMany('App\Artist');
    }

    public function festival()
    {
        return $this->belongsTo('App\Festival');
    }
}
