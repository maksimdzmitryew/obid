<?php

namespace Modules\Page\Filters;

use                              App\Filters\FiltersAPI;

class PageFilters extends FiltersAPI
{
	protected $filters = [
		'created_at',
		'published',
		'title',
		'updated_at',
		'parent',
		'page_id',
	];

	protected function page_id(Int $i_id)
	{
		if (!is_null($i_id) && $i_id > 0)
		{
			return $this->builder->where('pages.page_id', $i_id);
		}
	}

	protected function parent(Bool $b_type)
	{
		if ($b_type === TRUE)
		{
			return $this->builder->whereNull('pages.page_id');
		}
		elseif ($b_type === FALSE)
		{
			return $this->builder->whereNotNull('pages.page_id');
		}
	}
}
