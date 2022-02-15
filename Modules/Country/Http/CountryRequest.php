<?php

namespace Modules\Country\Http;

use App\Http\Requests\Request;

class CountryRequest extends Request
{
	protected $_rules = [
#		'building_id'		=> 'array',
		'published'			=> 'boolean',
		'title'				=> 'string',
	];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->_rules;
	}
}
