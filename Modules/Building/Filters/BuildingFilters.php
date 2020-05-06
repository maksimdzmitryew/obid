<?php

#namespace App\Filters;
namespace Modules\Building\Filters;

#use DB;
use App\Filters\FiltersAPI;
#use Illuminate\Http\Request;

class BuildingFilters extends FiltersAPI
{

	protected function elements($ids)
	{
		return $this->builder->whereIn('element_id', $ids);
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
				'buildings.*',
				'building_translations.title as title'
			)
			->offset($this->request->start)
			->limit($this->limit)
			->leftJoin('building_translations', function($query) {
				$query->on('building_translations.building_id', '=', 'buildings.id')
					->where('locale', '=', $this->appLocale);
			})
			->orderBy($this->orderColumn, $this->orderDirection);
	}*/
}
