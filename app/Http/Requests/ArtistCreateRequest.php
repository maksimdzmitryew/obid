<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistCreateRequest extends FormRequest
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
            'url'           => 'nullable|string|max:255',
            'email'         => 'nullable|string|email|max:255',
            'facebook'      => 'nullable|string|max:255',
            'image_id'      => 'nullable|integer',
            'en'            => 'required|array',
            'de'            => 'required|array',
            'en.name'       => 'required|string|max:255|unique:artist_translations,name',
            #'en.profession' => 'nullable|string|max:255',
            'de.name'       => 'required|string|max:255|unique:artist_translations,name',
            #'de.profession' => 'nullable|string|max:255',
            'festivals'     => 'array',
            'festivals.*'   => 'array',
            'festivals.*.id'  => 'exists:festivals',
        ];
    }
}
