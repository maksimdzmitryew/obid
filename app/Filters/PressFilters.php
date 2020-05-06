<?php

namespace App\Filters;

use DB;
use App\Traits\DatesTrait;
use App\Filters\Filters;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PressFilters extends Filters
{
    use DatesTrait;
    protected $filters = [
        'id',
        'type',
        'title',
        'festivals',
        'categories',
        'cities',
        'created_at',
        'updated_at',
        'date',
        'description',
        'published'
    ];

    protected function published($published)
    {
        if ($published === '*') {
            return $this->builder;
        }

        return $this->builder->where('published', $published);
    }

    protected function date($dates)
    {
        #return $this->builder->whereBetween('published_at', [$date['from'], $date['to']]);
        return $this->builder->whereBetween('published_at', $this->getDatesRange(collect($dates)));
    }

    protected function title($title)
    {
        return $this->builder->whereTranslationLike('title', '%' . $title . '%');
    }

    protected function description($description)
    {
        return $this->builder->orWhereTranslationLike('description', '%' . $description . '%', $this->appLocale);
    }

    protected function type($type)
    {
        return $this->builder->where('presses.type_id', '=', $type);
    }

    protected function festivals($festivals)
    {
        return $this->builder->whereIn('presses.festival_id', $festivals);
    }

    protected function cities($cities)
    {
        return $this->builder->whereIn('presses.city_id', $cities);
    }

    protected function categories($categories)
    {
        return $this->builder->whereIn('presses.category_id', $categories);
    }

    protected function getQuery()
    {
        $festivals = DB::table('festival_translations')
            ->select('festival_id', 'name')
            ->where('locale', $this->appLocale);

        $categories = DB::table('category_translations')
            ->select('category_id', 'name')
            ->where('locale', $this->appLocale);

        $type = DB::table('category_translations')
            ->select('category_id', 'name', 'slug')
            ->where('locale', $this->appLocale);

        $cities = DB::table('city_translations')
            ->select('city_id', 'name')
            ->where('locale', $this->appLocale);

        return $this->builder->select(
                'presses.*',
                'press_translations.title as title',
                'fe.name as festival',
                'ca.name as category',
                'ty.name as type',
                'ty.slug as type_slug',
                'ci.name as city'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('press_translations', function($join) {
                $join->on('press_translations.press_id', '=', 'presses.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->leftJoinSub($festivals, 'fe', function($join) {
                $join->on('fe.festival_id', '=', 'presses.festival_id');
            })
            ->leftJoinSub($categories, 'ca', function($join) {
                $join->on('ca.category_id', '=', 'presses.category_id');
            })
            ->leftJoinSub($type, 'ty', function($join) {
                $join->on('ty.category_id', '=', 'presses.type_id');
            })
            ->leftJoinSub($cities, 'ci', function($join) {
                $join->on('ci.city_id', '=', 'presses.city_id');
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}
