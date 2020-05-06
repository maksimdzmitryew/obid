<?php

namespace App;

use App\Traits\Fileable;
use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Media extends Model
{
    use Fileable;
    use GeneralTrait;
    use Translatable;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::deleted(function($model) {
            $model->file()->delete();
        });
    }

    protected $fillable = [
        'festival_id',
        'promoting',
        'published',
        'published_at'
    ];

    public $translatedAttributes = [
        'author',
        'title',
        'description'
    ];

    public function festival()
    {
        return $this->belongsTo('App\Festival');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
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
