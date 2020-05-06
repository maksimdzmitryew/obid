<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
            'position' => ['required', 'integer'],
            'slider_id' => ['required', 'integer'],
            'image_id' => ['required', 'integer'],
            'en' => ['required', 'array'],
            'de' => ['required', 'array'],
            'en.dates' => ['required', 'string', 'max:255'],
            'en.title' => ['required', 'string', 'max:255'],
            'en.description' => ['required', 'string', 'max:255'],
            'en.button_text' => ['required', 'string', 'max:255'],
            'en.button_url' => ['required', 'string', 'max:255'],
            'de.dates' => ['required', 'string', 'max:255'],
            'de.title' => ['required', 'string', 'max:255'],
            'de.description' => ['required', 'string', 'max:255'],
            'de.button_text' => ['required', 'string', 'max:255'],
            'de.button_url' => ['required', 'string', 'max:255'],
        ];
    }
}
