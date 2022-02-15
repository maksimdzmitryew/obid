<?php

namespace Modules\Country\Filters;

use                              App\Filters\FiltersAPI;

class CountryFilters extends FiltersAPI
{
	protected $filters = [
		'created_at',
		'published',
		'title',
		'updated_at',
		'parent',
		'country_id',
	];

	protected function country_id(Int $i_id)
	{
		if (!is_null($i_id) && $i_id > 0)
		{
			return $this->builder->where('countrys.country_id', $i_id);
		}
	}

	protected function parent(Bool $b_type)
	{
		if ($b_type === TRUE)
		{
			return $this->builder->whereNull('countrys.country_id');
		}
		elseif ($b_type === FALSE)
		{
			return $this->builder->whereNotNull('countrys.country_id');
		}
	}
}
