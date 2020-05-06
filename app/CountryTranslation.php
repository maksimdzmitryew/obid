<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
