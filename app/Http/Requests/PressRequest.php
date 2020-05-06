<?php

namespace App\Http\Requests;

use App\Press;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PressRequest extends FormRequest
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
            // 'type'   => [
            //     'required',
            //     Rule::in(Press::TYPES)
            // ],
            // 'en'             => ['required', 'array'],
            // 'de'             => ['required', 'array'],
            // 'links'          => ['required', 'array'],
            // 'en.title'       => ['required', 'string', 'max:255'],
            // 'en.description' => ['required', 'string'],
            // 'en.slug'        => ['nullable', 'string'],
            // 'en.volume'      => ['required', 'string'],
            // 'de.title'       => ['required', 'string', 'max:255'],
            // 'de.description' => ['required', 'string'],
            // 'de.slug'        => ['nullable', 'string'],
            // 'de.volume'      => ['required', 'string'],
        ];
    }
}
