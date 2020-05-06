<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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
            'file_id' => ['required', 'integer'],
            'en' => ['required', 'array'],
            'de' => ['required', 'array'],
            'en.title' => ['required', 'string', 'max:255'],
            'en.author' => ['required', 'string', 'max:255'],
            'en.description' => ['required', 'string'],
            'de.title' => ['required', 'string', 'max:255'],
            'de.author' => ['required', 'string', 'max:255'],
            'de.description' => ['required', 'string']
        ];
    }
}
