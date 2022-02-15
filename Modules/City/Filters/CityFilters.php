<?php

namespace Modules\City\Filters;

use                              App\Filters\FiltersAPI;

class CityFilters extends FiltersAPI
{
	protected $filters = [
		'created_at',
		'published',
		'title',
		'updated_at',
		'parent',
		'city_id',
	];

	protected function city_id(Int $i_id)
	{
		if (!is_null($i_id) && $i_id > 0)
		{
			return $this->builder->where('citys.city_id', $i_id);
		}
	}

	protected function parent(Bool $b_type)
	{
		if ($b_type === TRUE)
		{
			return $this->builder->whereNull('citys.city_id');
		}
		elseif ($b_type === FALSE)
		{
			return $this->builder->whereNotNull('citys.city_id');
		}
	}
}
