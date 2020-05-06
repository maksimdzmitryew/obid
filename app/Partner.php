<?php

namespace App;

use App\Traits\Imageable;
use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use Imageable;
    use GeneralTrait;

    protected $with = [
        'image'
    ];

    protected $fillable = [
        'title',
        'url',
        'promoting',
        'category_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function($model) {
            $model->image()->delete();
        });
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function festivals()
    {
        return $this->belongsToMany('App\Festival', 'festival_partner');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function scopePromoting($query)
    {
        return $query->where('promoting', 1);
    }
}
