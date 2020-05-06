<?php

namespace Modules\Complaint\Filters;

use                              App\Filters\FiltersAPI;

class ComplaintFilters extends FiltersAPI
{
	protected function building($ids)
	{
		return $this->builder->whereIn('building_id', $ids);
	}
}
