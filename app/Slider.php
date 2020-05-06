<?php

namespace App;

use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use GeneralTrait;

    protected $fillable = [
        'name'
    ];

    protected $with = [
        'slides'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function($model) {
            $model->slides()->delete();
        });
    }

    public function festival()
    {
        return $this->hasOne('App\Festival');
    }

    public function slides()
    {
        return $this->hasMany('App\Slide');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
