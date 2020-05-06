<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class PressTranslation extends Model
{
    use Sluggable;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'volume',
    ];

    public $timestamps = false;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
