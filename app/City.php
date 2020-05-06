<?php

namespace App;

use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use GeneralTrait;
    use Translatable;

    protected $fillable = [
        'timezone'
    ];

    public $translatedAttributes = [
        'name',
    ];

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function places()
    {
        return $this->hasMany('App\Place');
    }

    public function presses()
    {
        return $this->hasMany('App\Press');
    }
}
