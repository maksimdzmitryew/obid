<?php 

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class CategoryFilters extends Filters
{
    protected $filters = [
        'id',
        'name',
        'slug',
        'created_at',
        'updated_at',
    ];

    protected function name($name)
    {
        return $this->builder->whereTranslationLike('name', '%' . $name .'%', $this->appLocale);
    }

    protected function slug($slug)
    {
        return $this->builder->whereTranslationLike('slug', '%' . $slug .'%', $this->appLocale);
    }

    protected function types($types)
    {
        return $this->builder->whereIn('type', $types);
    }

    protected function getQuery()
    {
        return $this->builder->select(
                'categories.*',
                'category_translations.name as name',
                'category_translations.slug as slug'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->join('category_translations', function($query) {
                $query->on('category_translations.category_id', '=', 'categories.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}