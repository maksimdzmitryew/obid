<?php

namespace Modules\Plate\Http;

use App\Http\Requests\Request;

class PlateRequest extends Request
{
	protected $_rules = [
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