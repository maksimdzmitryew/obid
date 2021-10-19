<?php

namespace Modules\Setting\Filters;

use                              App\Filters\FiltersAPI;

class SettingFilters extends FiltersAPI
{
	protected $filters = [
		'created_at',
		'published',
		'updated_at',
		'value',
		'slug',
	];

}
