<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EventHolding extends Model
{
    protected $fillable = [
        'date_from',
        'date_to',
        'ignored_timeto',
        'place_id',
        'event_id',
        'ticket_url'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'date_from',
        'date_to',
    ];

    protected $with = [
        'place',
        'city'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('date_from', 'asc');
        });

        // static::addGlobalScope('actual', function (Builder $builder) {
        //     $builder->where('date', '>', today()->toDateTimeString());
        // });

        static::saving(function($model) {
            $model->city_id = $model->place->city_id;
        });
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function scopeActual()
    {
        return $this->where('date_from', '>=', today()->dateTime);
    }
}
