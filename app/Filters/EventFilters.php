<?php

namespace App\Filters;

use DB;
use App\Filters\Filters;
use Illuminate\Http\Request;

class EventFilters extends Filters
{
    protected $filters = [
        'id',
        'slug',
        'body',
        'title',
        'festivals',
        'categories',
        'created_at',
        'updated_at',
        'holdings',
        'cities',
        'promoting',
        'published'
    ];

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    protected function promoting($promoted)
    {
        if ($promoted === '*') {
            return $this->builder;
        }

        return $this->builder->where('promoting', $promoted);
    }

    protected function published($published)
    {
        if ($published === '*') {
            return $this->builder;
        }

        return $this->builder->where('published', $published);
    }


    protected function title($title)
    {
        return $this->builder->OrWhereTranslationLike('title', '%' . $title .'%', $this->appLocale);
    }

    protected function body($body)
    {
        return $this->builder->OrWhereTranslationLike('description', '%' . $body .'%', $this->appLocale);
    }

    protected function slug($slug)
    {
        return $this->builder->whereTranslationLike('slug', '%' . $slug .'%', $this->appLocale);
    }

    protected function festivals($festivals)
    {
        return $this->builder->whereIn('events.festival_id', $festivals);
    }

    protected function categories($categories)
    {
        return $this->builder->whereIn('events.category_id', $categories);
    }

    protected function holdings($holdings)
    {
        return $this->builder->whereHas('holdings', function($query) use ($holdings) {
            dd($holdings);
            #$query->whereBetween('date_from', $holdings);
            #$query->where('date_from', '>=', today()->dateTime);
        });
    }

    protected function cities($cities)
    {
        return $this->builder->whereHas('holdings', function($query) use ($cities) {
            $query->whereIn('city_id', $cities);
        });
    }

    protected function getQuery()
    {
        $festivals = DB::table('festival_translations')
            ->select('festival_id', 'name')
            ->where('locale', $this->appLocale);

        $categories = DB::table('category_translations')
            ->select('category_id', 'name')
            ->where('locale', $this->appLocale);

        return $this->builder->select(
                'events.*',
                'event_translations.title as title',
                'event_translations.slug as slug',
                'categories.name as category',
                'festivals.name as festival'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('event_translations', function($join) {
                $join->on('event_translations.event_id', '=', 'events.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->leftJoinSub($festivals, 'festivals', function($join) {
                $join->on('festivals.festival_id', '=', 'events.festival_id');
            })
            ->leftJoinSub($categories, 'categories', function($join) {
                $join->on('categories.category_id', '=', 'events.category_id');
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}