<?php

namespace App\Filters;

use DB;
use App\Filters\Filters;
use Illuminate\Http\Request;

class BookFilters extends Filters
{
    protected $filters = [
        'id',
        'name',
        'festivals',
        'created_at',
        'updated_at',
    ];

    protected function name($name)
    {
        return $this->builder->whereTranslationLike('name', '%' . $name . '%', $this->appLocale);
    }

    protected function festivals($festivals)
    {
        return $this->builder->whereIn('books.festival_id', $festivals);
    }

    protected function getQuery()
    {
        $festivals = DB::table('festival_translations')
            ->select('festival_id', 'name')
            ->where('locale', $this->appLocale);

        return $this->builder->select(
                'books.*',
                'book_translations.name as name',
                'festivals.name as festival'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('book_translations', function($query) {
                $query->on('book_translations.book_id', '=', 'books.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->leftJoinSub($festivals, 'festivals', function($join) {
                $join->on('festivals.festival_id', '=', 'books.festival_id');
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}