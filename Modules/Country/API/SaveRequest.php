<?php

namespace Modules\Country\API;

use Modules\Country\Http\CountryRequest as BaseRequest;

class SaveRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->rulesLng([]);#$this->_rules);
	}
}
