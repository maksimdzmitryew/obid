<?php

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class ArtistFilters extends Filters
{
    protected $filters = [
        'id',
        'email',
        'festival',
        'member',
        'name',
        'vocation',
        'created_at',
        'updated_at',
    ];

    protected function email($email)
    {
        return $this->builder->where('email', 'LIKE', '%' . $email .'%');
    }

    protected function festival($festival)
    {
        if (is_null($festival[0]))
        {
            return $this->builder;
        }
        return $this->builder
            ->leftJoin('festival_artist', 'artists.id', '=', 'festival_artist.artist_id')
            ->whereIn('festival_artist.festival_id', $festival);
    }

    protected function member($member)
    {
        if (is_null($member[0])) {
            return $this->builder;
        }

        return  $this->builder
                        ->join('festival_artist as fa', 'fa.artist_id', '=', 'artists.id')
                        ->where('fa.team_member', (integer) (in_array('team', $member)) )
                        ->where('fa.board_member', (integer) (in_array('board', $member)) )
                        ;
    }

    protected function name($name)
    {
        return $this->builder->whereTranslationLike('name', '%' . $name .'%', $this->appLocale);
    }

    protected function vocation($vocation)
    {
        if (is_null($vocation[0]))
        {
            return $this->builder;
        }
        return $this->builder
            ->leftJoin('artist_vocation', 'artists.id', '=', 'artist_vocation.artist_id')
            ->whereIn('artist_vocation.vocation_id', $vocation);
    }

    protected function getQuery()
    {
        return $this->builder->select(
                'artists.*'
                ,'artist_translations.profession as profession'
                ,'artist_translations.name as name'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('artist_translations', function($join) {
                $join->on('artist_translations.artist_id', '=', 'artists.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}