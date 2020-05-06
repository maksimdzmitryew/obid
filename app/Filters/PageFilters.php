<?php

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class PageFilters extends Filters
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
                'pages.*',
                'page_translations.name as name'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->join('page_translations', function($query) {
                $query->on('page_translations.page_id', '=', 'pages.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}