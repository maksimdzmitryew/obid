<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    public $timestamps = false;

    function user()
    {
        return $this->belongsTo('App\User', 'email', 'email');
    }
}
