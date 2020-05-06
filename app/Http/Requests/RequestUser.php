<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RequestUser extends Request
{
	public $a_attr;
	public $a_rule;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->a_rule;
	}

	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		$a_tmp = array_keys($this->a_rule);
		for ($i = 0; $i < count($a_tmp); $i++)
			$this->a_attr[$a_tmp[$i]] = trans('user/form.field.' . $a_tmp[$i]);
		return $this->a_attr;
	}
}
