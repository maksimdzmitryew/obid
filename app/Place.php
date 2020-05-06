<?php

namespace App;

use App\Traits\Fileable;

use App\Traits\GeneralTrait;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use Fileable;

    use Translatable;
    use GeneralTrait;

    protected $fillable = [
        'city_id'
    ];

    public $translatedAttributes = [
        'name',
    ];

    public function city()
    {
        return $this->belongsTo('App\City');
    }
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
