<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slides' => ['required', 'array'],
            'slides.*.image_id' => ['required', 'integer'],
            'slides.*.en' => ['required', 'array'],
            'slides.*.de' => ['required', 'array'],
            'slides.*.en.upper_title' => ['string', 'max:255'],
            //'slides.*.en.dates' => ['required', 'string', 'max:255'],
            'slides.*.en.title' => ['required', 'string', 'max:255'],
            'slides.*.en.description' => ['required', 'string', 'max:191'],
            'slides.*.en.button_text' => ['required', 'string', 'max:255'],
            'slides.*.en.button_url' => ['required', 'string', 'max:255'],
            'slides.*.de.upper_title' => ['string', 'max:255'],
            //'slides.*.de.dates' => ['required', 'string', 'max:255'],
            'slides.*.de.title' => ['required', 'string', 'max:255'],
            'slides.*.de.description' => ['required', 'string', 'max:191'],
            'slides.*.de.button_text' => ['required', 'string', 'max:255'],
            'slides.*.de.button_url' => ['required', 'string', 'max:255']
        ];
    }
}
