<?php

#namespace App\Filters;
namespace Modules\Element\Filters;

#use DB;
use App\Filters\FiltersAPI;
#use Illuminate\Http\Request;

class ElementFilters extends FiltersAPI
{

	protected function buildings($ids)
	{
		return $this->builder->whereIn('building_id', $ids);
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
				'elements.*',
				'element_translations.title as title'
			)
			->offset($this->request->start)
			->limit($this->limit)
			->leftJoin('element_translations', function($query) {
				$query->on('element_translations.element_id', '=', 'elements.id')
					->where('locale', '=', $this->appLocale);
			})
			->orderBy($this->orderColumn, $this->orderDirection);
	}*/
}
