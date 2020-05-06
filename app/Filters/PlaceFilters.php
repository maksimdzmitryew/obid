<?php

namespace App\Filters;

use DB;
use App\Filters\Filters;
use Illuminate\Http\Request;

class PlaceFilters extends Filters
{
    protected $filters = [
        'id',
        'name',
        'cities',
        'created_at',
        'updated_at'
    ];

    protected function name($name)
    {
        return $this->builder->whereTranslationLike('name', '%' . $name . '%', $this->appLocale);
    }

    protected function cities($cities)
    {
        return $this->builder->whereIn('places.city_id', $cities);
    }

    protected function getQuery()
    {
        $cities = DB::table('city_translations')
            ->select('city_id', 'name')
            ->where('locale', $this->appLocale);

        return $this->builder->select(
                'places.*',
                'place_translations.name as name',
                'cities.name as city'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->join('place_translations', function($query) {
                $query->on('place_translations.place_id', '=', 'places.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->leftJoinSub($cities, 'cities', function($join) {
                $join->on('cities.city_id', '=', 'places.city_id');
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}
