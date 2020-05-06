<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
