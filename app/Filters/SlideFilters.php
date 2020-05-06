<?php 

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class SlideFilters extends Filters
{
    protected $filters = [
        'id',
        'title',
        'updated_at',
        'created_at'
    ];

    protected function title($title)
    {
        return $this->builder->whereTranslationLike('title', '%' . $title .'%', $this->appLocale);
    }

    protected function getQuery()
    {
        return $this->builder->select(
                'slides.*',
                'slide_translations.title as title'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('slide_translations', function($join) {
                $join->on('slide_translations.slide_id', '=', 'slides.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}