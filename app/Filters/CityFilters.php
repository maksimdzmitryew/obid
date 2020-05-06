<?php 

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class CityFilters extends Filters
{
    protected $filters = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    protected function name($name)
    {
        return $this->builder->whereTranslationLike('name', '%' . $name . '%', $this->appLocale);
    }

    protected function getQuery()
    {
        return $this->builder->select(
                'cities.*',
                'city_translations.name as name')
            ->offset($this->request->start)
            ->limit($this->limit)
            ->join('city_translations', function($query) {
                $query->on('city_translations.city_id', '=', 'cities.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}