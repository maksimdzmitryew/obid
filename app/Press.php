<?php

namespace App;

use App\Traits\Fileable;
use App\Traits\Imageable;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Press extends Model
{
    use Fileable;
    use Imageable;
    use Translatable;
    use GeneralTrait;

// TODO keep for backward compatibility just in case
/*
    const TYPES = [
        'press-release',
        'photo',
        'video'
    ];
*/
    protected $fillable = [
// TODO keep for backward compatibility just in case
#        'type',
        'links',
        'gallery_id',
        'festival_id',
        'category_id',
        'type_id',
        'city_id',
        'published_at',
        'published',
    ];

    protected $casts = [
        'links' => 'object'
    ];

    public $translatedAttributes = [
        'title',
        'description',
        'slug',
        'volume',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            #$builder->orderBy('fyear', 'desc');
            $builder->orderBy('created_at', 'desc');
        });

        static::deleted(function($model) {
            $model->file()->delete();
            $model->image()->delete();
            $model->archive()->delete();
        });
    }

    public function festival()
    {
        return $this->belongsTo('App\Festival')
        #->withPivot('year')
        #->orderBy('year', 'desc');
        ;
    }

    public function gallery()
    {
        return $this->belongsTo('App\Gallery')->withDefault();
    }

    public function type()
    {
        return $this->belongsTo('App\Category');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
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
