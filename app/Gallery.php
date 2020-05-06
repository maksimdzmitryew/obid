<?php

namespace App;

use App\Traits\Imageable;
use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use Imageable;
    use GeneralTrait;

    protected $fillable = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function($model) {
            File::destroy($model->images->pluck('id')->toArray());
        });
    }

    public function images()
    {
        return $this->morphMany('App\File', 'fileable');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
