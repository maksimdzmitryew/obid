<?php

#namespace App\Filters;
namespace Modules\Opinion\Filters;

#use DB;
use                              App\Filters\FiltersAPI;
#use Illuminate\Http\Request;

class OpinionFilters extends FiltersAPI
{

	protected function points($ids)
	{
		return $this->builder->whereIn('point_id', $ids);
	}


/*
	protected $filters = [
		'id',
		'title',
		'created_at',
		'updated_at',
	];

	protected function title($title)
	{
		return $this->builder->whereTranslationLike('title', '%' . $title . '%', $this->appLocale);
	}

	protected function getQuery()
	{
		return $this->builder->select(
				'opinions.*',
				'opinion_translations.title as title'
			)
			->offset($this->request->start)
			->limit($this->limit)
			->leftJoin('opinion_translations', function($query) {
				$query->on('opinion_translations.opinion_id', '=', 'opinions.id')
					->where('locale', '=', $this->appLocale);
			})
			->orderBy($this->orderColumn, $this->orderDirection);
	}*/
}
