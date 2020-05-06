<?php

namespace App\Http\Requests;

use App\Place;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
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
            'city_id' => ['integer', 'required', 'exists:cities,id'],
            'en'      => ['array', 'required'],
            'de'      => ['array', 'required'],
            'en.name' => ['required', 'string', 'max:255'],
            'de.name' => ['required', 'string', 'max:255'],
        ];
    }
}
