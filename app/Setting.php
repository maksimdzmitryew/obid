<?php

namespace App;

use         Illuminate\Database\Eloquent\Model;
use    Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use              Astrotomic\Translatable\Translatable;

class Setting extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'value',
    ];

    public $translatedAttributes = [
        'translated_value'
    ];

    public $timestamps = false;

    public function scopeName($query, $name)
    {
        return $query->where('name', $name)->firstOrFail();
    }
}
