<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaTranslation extends Model
{
    protected $fillable = [
        'author',
        'title',
        'description'
    ];

    public $timestamps = false;
}
