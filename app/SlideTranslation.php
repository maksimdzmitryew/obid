<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlideTranslation extends Model
{
    protected $fillable = [
        'upper_title',
        'title',
        'description',
        'button_text',
        'button_url'
    ];

    public $timestamps = false;
}
