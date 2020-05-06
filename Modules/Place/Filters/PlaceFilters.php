<?php

namespace Modules\Place\Filters;

use                              App\Filters\FiltersAPI;

class PlaceFilters extends FiltersAPI
{
	protected function building($ids)
	{
		return $this->builder->whereIn('building_id', $ids);
	}
}
