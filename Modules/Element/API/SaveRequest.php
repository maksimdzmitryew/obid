<?php

namespace Modules\Element\API;

use Modules\Element\Http\ElementRequest as BaseRequest;

class SaveRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->rulesLng($this->_rules);
	}
}
