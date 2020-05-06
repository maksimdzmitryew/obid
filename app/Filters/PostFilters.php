<?php

namespace App\Filters;

use DB;
use App\Filters\Filters;
use Illuminate\Http\Request;

class PostFilters extends Filters
{
    protected $filters = [
        'id',
        'slug',
        'body',
        'title',
        'festivals',
        'categories',
        'updated_at',
        'created_at',
        'published'
    ];

    protected function published($published)
    {
        if ($published === '*') {
            return $this->builder;
        }

        return $this->builder->where('posts.published', $published);
    }

    protected function title($title)
    {
        return $this->builder->whereTranslationLike('title', '%' . $title .'%', $this->appLocale);
    }

    protected function body($body)
    {
        return $this->builder->orWhereTranslationLike('body', '%' . $body .'%', $this->appLocale);
    }

    protected function slug($slug)
    {
        return $this->builder->whereTranslationLike('slug', '%' . $slug .'%', $this->appLocale);
    }

    protected function categories($categories)
    {
        return $this->builder->whereIn('posts.category_id', $categories);
    }

    protected function festivals($festivals)
    {
        return $this->builder->whereIn('posts.festival_id', $festivals);
    }

    protected function getQuery()
    {
        $festivals = DB::table('festival_translations')
            ->select('festival_id', 'name')
            ->where('locale', $this->appLocale);

        $categories = DB::table('category_translations')
            ->select('category_id', 'name')
            ->where('locale', $this->appLocale);

        $events = DB::table('event_translations')
            ->select('event_id', 'title')
            ->where('locale', $this->appLocale);

        return $this->builder->select(
                'posts.*',
                'post_translations.title as title',
                'post_translations.slug as slug',
                'categories.name as category',
                'festivals.name as festival' 
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('post_translations', function($join) {
                $join->on('post_translations.post_id', '=', 'posts.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->leftJoinSub($festivals, 'festivals', function($join) {
                $join->on('festivals.festival_id', '=', 'posts.festival_id');
            })
            ->leftJoinSub($categories, 'categories', function($join) {
                $join->on('categories.category_id', '=', 'posts.category_id');
            })
            ->leftJoinSub($events, 'events', function($join) {
                $join->on('events.event_id', '=', 'posts.event_id');
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}