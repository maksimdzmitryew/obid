<?php

namespace App;

use DB;
use App\Traits\Imageable;
use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use GeneralTrait;
    use Translatable;
    use Imageable;

    protected $fillable = [
        'festival_id',
        'url',
        'email',
        'facebook',
    ];

    public $translatedAttributes = [
        'description',
        'name',
    ];

    protected $with = [
        'image'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function($model) {
            $model->image->delete();
        });
    }

    public function festivals(){
        return $this->belongsToMany('App\Festival', 'festival_artist');
    }

    public function books()
    {
        return $this->belongsToMany('App\Book');
    }

    public function vocations()
    {
        return $this->belongsToMany('App\Vocation');
    }

    public function events()
    {
        return $this->belongsToMany('App\Event');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function scopeFestivalProfession($query)
    {
        return $query
                ->join('profession_translations as pt', 'pt.profession_id', '=', 'festival_artist.profession_id')
                ->where('pt.locale', app()->getLocale())
                ;
    }

    public function scopeFestivalTeam($query)
    {
        return $query
                ->where('festival_artist.team_member', 1)
                ->orderBy('festival_artist.order');
    }

    public function scopeFestivalBoard($query)
    {
        return $query
                ->where('festival_artist.board_member', 1)
                ->orderBy('festival_artist.order');
    }

    /*
    public function scopeTeamMembers($query)
    {
        return $query->join('festival_artist as fa', 'fa.artist_id', '=', 'artists.id')->where('fa.team_member', 1)->groupBy('artists.id');
    }

    public function scopeBoardMembers($query)
    {
        return $query->join('festival_artist as fa', 'fa.artist_id', '=', 'artists.id')->where('fa.board_member', 1)->groupBy('artists.id');
    }
    */
}
