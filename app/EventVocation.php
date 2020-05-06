<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventVocation extends Model
{
    protected $table = 'event_vocation';

    public function test()
    {
        return 'test';
    }

    public function event()
    {
        return $this->belongsTo('App\Event','event_id','id');
    }

    public function artists()
    {
        return $this->belongsToMany('App\Artist')->withPivot('order');
    }

}
