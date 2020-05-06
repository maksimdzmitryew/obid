<?php

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class ProfessionFilters extends Filters
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
                'professions.*',
                'profession_translations.name as name'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->join('profession_translations', function($query) {
                $query->on('profession_translations.profession_id', '=', 'professions.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}