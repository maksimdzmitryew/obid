<?php 

namespace App\Filters;

use DB;
use App\Filters\Filters;
use Illuminate\Http\Request;

class MediaFilters extends Filters
{
    protected $filters = [
        'id',
        'title',
        'author',
        'festivals',
        'created_at',
        'updated_at',
        'published'
    ];

    protected function published($published)
    {
        if ($published === '*') {
            return $this->builder;
        }

        return $this->builder->where('published', $published);
    }

    protected function title($title)
    {
        return $this->builder->whereTranslationLike('title', '%' . $title . '%', $this->appLocale);
    }

    protected function author($author)
    {
        return $this->builder->whereTranslationLike('author', '%' . $author . '%', $this->appLocale);
    }

    protected function festivals($festivals)
    {
        return $this->builder->whereIn('media.festival_id', $festivals);
    }

    protected function getQuery()
    {
        $festivals = DB::table('festival_translations')
            ->select('festival_id', 'name')
            ->where('locale', $this->appLocale);

        return $this->builder->select(
                'media.*',
                'media_translations.title as title',
                'media_translations.author as author',
                'festivals.name as festival'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('media_translations', function($join) {
                $join->on('media_translations.media_id', '=', 'media.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->leftJoinSub($festivals, 'festivals', function($join) {
                $join->on('festivals.festival_id', '=', 'media.festival_id');
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}
