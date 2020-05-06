<?php

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class FestivalFilters extends Filters
{
    protected $filters = [
        'id',
        'name',
        'year',
        'active',
        'published',
        'created_at',
        'updated_at',
    ];

    protected function name($name)
    {
        return $this->builder->whereTranslationLike('name', '%' . $name . '%', $this->appLocale);
    }

    protected function year($year)
    {
        return $this->builder->where('name', 'like', '%' . $year . '%');
    }

    protected function active($active)
    {
        if ($active === '*') {
            return $this->builder;
        }

        return $this->builder->where('active', $active);
    }

    protected function published($published)
    {
        if ($published === '*') {
            return $this->builder;
        }

        return $this->builder->where('published', $published);
    }

    protected function getQuery()
    {
        $this->builder->select(
                'festivals.*',
                'festival_translations.name as name'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->join('festival_translations', function($query) {
                $query->on('festival_translations.festival_id', '=', 'festivals.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}