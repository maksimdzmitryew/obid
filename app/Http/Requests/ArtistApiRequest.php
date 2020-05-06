<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistApiRequest extends FormRequest
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
            'start'						=> 'int',
            'length'					=> 'int',

            'filters'					=> 'array',
            'filters.id'				=> 'array',
            'filters.id.*'				=> 'int',
            'filters.name'				=> 'nullable|string|max:255',
            'filters.email'				=> 'nullable|string|max:255',
            'filters.festival'			=> 'array',
            'filters.vocation'			=> 'array',

            'filters.created_at'		=> 'array',
            'filters.created_at.from'	=> 'date',
            'filters.created_at.to'		=> 'date',

            'filters.updated_at'		=> 'array',
            'filters.created_at.from'	=> 'date',
            'filters.created_at.to'		=> 'date',
        ];
    }
}
