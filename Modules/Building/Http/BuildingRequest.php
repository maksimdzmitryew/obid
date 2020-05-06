<?php

namespace Modules\Building\Http;

use App\Http\Requests\Request;

class BuildingRequest extends Request
{
	protected $_rules = [
		'published'			=> 'boolean',
		'title'				=> 'required|string|max:255',
	];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [];
	}
}
