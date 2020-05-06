<?php

namespace App;

use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use GeneralTrait;
    use Translatable;

// TODO keep for backward compatibility just in case
/*
    const TYPES = [
        'news',
        'events',
        'partners',
        'presses'
    ];
*/
    protected $fillable = [
#        'type_id',
// TODO keep for backward compatibility just in case
#        'type'
    ];

    public $translatedAttributes = [
        'name',
        'slug'
    ];

    public function news()
    {
        return $this->hasMany('App\News');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function partners()
    {
        return $this->hasMany('App\Partner');
    }

    public function presses()
    {
        return $this->hasMany('App\Press');
    }

    public function scopeType($query, $type)
    {
        return $query->where('type',  $type);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
