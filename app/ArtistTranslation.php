<?php

namespace App;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ArtistTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
#        'profession',
        'description',
        'name'
    ];
}
