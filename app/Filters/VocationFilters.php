<?php 

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class VocationFilters extends Filters
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
                'vocations.*',
                'vocation_translations.name as name')
            ->offset($this->request->start)
            ->limit($this->limit)
            ->join('vocation_translations', function($query) {
                $query->on('vocation_translations.vocation_id', '=', 'vocations.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}