<?php

namespace App;

use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use GeneralTrait;
    use Translatable;

    protected $fillable = [
        'iso',
        'published',
    ];

    public $translatedAttributes = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published'         => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function scopePublished($query, $published = true)
    {
        return $query->where('published', $published);
    }

}
