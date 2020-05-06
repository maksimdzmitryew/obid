<?php 

namespace App\Filters;

use DB;
use App\Filters\Filters;
use Illuminate\Http\Request;

class PartnerFilters extends Filters
{
    protected $filters = [
        'title',
        'url',
        'created_at',
        'updated_at',
        'categories',
        'festivals',
    ];


    protected function title($title)
    {
        return $this->builder->where('title', 'like', '%'. $title .'%');
    }

    protected function url($url)
    {
        return $this->builder->where('url', 'like', '%'. $url .'%');
    }

    protected function categories($categories)
    {
        return $this->builder->whereIn('partners.category_id', $categories);
    }

    protected function festivals($festivals)
    {
        return $this->builder->whereHas('festivals', function($query) use ($festivals){
            return $query->whereIn('id', $festivals);
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

        $query = $this->builder->select(
                'partners.*',
                'categories.name as category'
                //'festivals.name as festival'
            )
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('festival_partner', 'partners.id', '=', 'festival_partner.partner_id')
//            ->leftJoinSub($festivals, 'festivals', function($join) {
//                $join->on('festivals.festival_id', '=', 'festival_partner.festival_id');
//            })
            ->leftJoinSub($categories, 'categories', function($join) {
                $join->on('categories.category_id', '=', 'partners.category_id');
            })
            ->orderBy($this->orderColumn, $this->orderDirection)
            ->groupBy('partners.id');

        return $query;
    }
}