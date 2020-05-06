<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'url'      => 'string|max:255|nullable',
            'api_code' => 'string|max:255|nullable',
            'festival_id' => 'required|integer',
            'author_ids'  => 'array',
            'author_ids.*' => 'integer',
            'en'       => 'required|array',
            'de'       => 'required|array',
            'en.name'  => 'required|string|max:255',
            'en.slug'  => 'string|max:255',
            'en.volume'  => 'string|max:255',
            'en.meta_title'  => 'max:255',
            'de.name'  => 'required|string|max:255',
            'de.slug'  => 'string|max:255',
            'de.volume'  => 'string|max:255',
            'de.meta_title'  => 'max:255',
        ];
    }
}
