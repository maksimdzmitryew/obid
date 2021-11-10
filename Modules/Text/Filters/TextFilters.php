<?php

namespace Modules\Text\Filters;

use                              App\Filters\FiltersAPI;

class TextFilters extends FiltersAPI
{
	protected $filters = [
		'created_at',
		'published',
		'updated_at',
		'value',
		'slug',
	];

}
