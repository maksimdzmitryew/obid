<?php

namespace App;

use App\Traits\Imageable;
use App\Traits\GeneralTrait;
use \App\Traits\DatesTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    use Imageable;
    use GeneralTrait;
    use Translatable;

    protected $fillable = [
        'year',
        'active',
        'published',
        'slider_id',
        'color'
    ];

    public $translatedAttributes = [
        'name',
        'slug',
        'about_festival',
        'program_description',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    // protected $with = [
    //     'image'
    // ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->image->delete();
            $model->translations->each(function($translation) {
                $translation->delete();
            });
        });
    }

    public function artists()
    {
        return $this->belongsToMany('App\Artist', 'festival_artist');
    }

    public function book()
    {
        return $this->hasOne('App\Book');
    }

    public function news()
    {
        return $this->hasMany('App\Post');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function promotingEvents()
    {
        return $this->events()->promoting();
    }

    public function holdings()
    {
        return $this->hasManyThrough('App\EventHolding', 'App\Event');
    }

    public function partners()
    {
        return $this->belongsToMany('App\Partner');
    }

    public function medias()
    {
        return $this->hasMany('App\Media');
    }

    public function presses()
    {
        return $this->hasMany('App\Press');
    }

    public function slider()
    {
        return $this->belongsTo('App\Slider');
    }

    public function chosenEvents($handling_dates)
    {
        return $this->events()->chosenHandlings($handling_dates);
    }

    public function scopeCurrent($query)
    {
        return $query->where([
            'active' => 1,
            'published' => 1
        ])->first();
    }

    public function scopeSlug($query, $festival_slug)
    {
        return $query->whereTranslation('slug', $festival_slug);
    }

    public function scopeArchived($query)
    {
        return $query->where('active', 0);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
