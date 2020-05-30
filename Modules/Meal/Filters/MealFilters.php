<?php

namespace Modules\Meal\Filters;

use                              App\Filters\FiltersAPI;

class MealFilters extends FiltersAPI
{
	protected function building($ids)
	{
		return $this->builder->whereIn('building_id', $ids);
	}
}
