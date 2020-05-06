<?php

namespace App;

use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'model_has_roles', 'model_id');
    }

}
