<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PointRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $a_rules = [
            'published'			=> 'boolean',
            'title'				=> 'required|string|max:255',
        ];
    	return $this->rulesLng($a_rules);
    }
}
