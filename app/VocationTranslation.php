<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VocationTranslation extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
