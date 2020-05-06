<?php 

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class TextFilters extends Filters
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
        return $this->builder->select('texts.*', 'text_translations.name as name')
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('text_translations', function($query) {
                $query->on('text_translations.text_id', '=', 'texts.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}