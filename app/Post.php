<?php

namespace App;

use App\Festival;
use App\Traits\Imageable;
use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use Imageable;
    use GeneralTrait;
    use Translatable;

    protected $fillable = [
        'type',
        'category_id',
        'festival_id',
        'event_id',
        'gallery_id',
        'promoting',
        'published_at',
        'published'
    ];

    protected $with = [
        'image'
    ];

    public $translatedAttributes = [
        'slug',
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function festival()
    {
        return $this->belongsTo('App\Festival');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function event()
    {
        return $this->belongsTo('App\Event')->withDefault();
    }

    public function gallery()
    {
        return $this->belongsTo('App\Gallery');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopePromoting($query, $promoting = true)
    {
        return $query->where('promoting', $promoting);
    }

    function getPublishedAtAttribute($value){
        $date = new Carbon($value);

        return trans('general.date', [
            'day'   => $date->format('j'),
            'month' => $date->format('F'),
            'year'  => $date->format('Y')
        ]);
    }
}
