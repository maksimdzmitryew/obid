<?php

namespace App;

use         Illuminate\Database\Eloquent\Model;
use    Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use              Astrotomic\Translatable\Translatable;

class Setting extends Model
{
    protected $connection = 'psc';

    use Translatable;

    protected $fillable = [
        'slug',
        'published',
        'value',
    ];

    public $translatedAttributes = [
        'translated_value'
    ];

    public $timestamps = false;

    public function scopeSlug($query, $name)
    {
        return $query->where('slug', $name)->firstOrFail();
    }
}
