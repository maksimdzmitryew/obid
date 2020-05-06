<?php

namespace App;

use                           App\Traits\GeneralTrait;
use         Illuminate\Database\Eloquent\Model;
use    Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use              Astrotomic\Translatable\Translatable;

class Text extends Model
{
    use GeneralTrait;
    use Translatable;

    protected $fillable = [
        'name',
        'codename',
    ];

    public $translatedAttributes = [
        'name',
        'slug',
        'description',
    ];

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
