<?php

namespace Modules\Demand\Http;

use App\Http\Requests\Request;

class DemandRequest extends Request
{
	protected $_rules = [
		'published'			=> 'boolean',
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
