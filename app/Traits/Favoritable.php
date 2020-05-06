<?php

namespace App\Traits;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favorited');
    }

    public function favorite()
    {
        $attributes = [
            'user_id' => auth()->id()
        ];

        if (! $this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);    
        }
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }

    public function unfavorite()
    {
        if ($this->favorites()->where([
            'user_id' => auth()->id(),
            'favorited_id' => $this->id
        ])->exists()) {
            $this->favorites()->where('user_id', auth()->id())  
                ->where('favorited_id', $this->id)
                ->delete(); 
        }
    }
}