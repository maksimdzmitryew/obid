<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'timezone' => [
            //     'required',
            //     Rule::in(timezone_identifiers_list()),
            // ],
            'en'       => 'required|array',
            'de'       => 'required|array',
            'en.name'  => 'required|string|max:255',
            'de.name'  => 'required|string|max:255',
        ];
    }
}
