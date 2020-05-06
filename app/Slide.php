<?php

namespace App;

use App\Traits\Imageable;
use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Slide extends Model
{
    use Imageable;
    use Translatable;
    use GeneralTrait;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('position');
        });

        static::deleted(function($model) {
            $model->image()->delete();
        });
    }

    protected $fillable = [
        'position',
        'slider_id'
    ];

    protected $with = [
        'image'
    ];

    public $translatedAttributes = [
        'upper_title',
        'title',
        'description',
        'button_text',
        'button_url'
    ];
}
