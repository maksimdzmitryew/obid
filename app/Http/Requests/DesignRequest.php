<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DesignRequest extends Request
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
/*
        return [
            'enabled'			=> 'boolean',
            'uk.title'			=> 'required|string|max:255',
            'uk.description'  => 'string|max:255',
            'en.title'			=> 'required|string|max:255',
            'en.description'  => 'string|max:255',
            'de.title'			=> 'required|string|max:255',
            'de.description'  => 'string|max:255',
        ];
*/
    }
}
