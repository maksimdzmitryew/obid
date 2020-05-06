<?php

namespace Modules\Opinion\Http;

use                        App\Http\Requests\Request;

class OpinionRequest extends Request
{
	protected $_rules = [
#		'published'			=> 'boolean',
#		'title'				=> 'required|string|max:255',
	];

	/**
	 * Get the validation rules that apply to the request.
	 * used for items list in datatable
	 *
	 * @return array
	 */
	public function rules()
	{
		return [];
	}
}
