<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'type'   => [
                'required',
// TODO keep for backward compatibility just in case
#                Rule::in(Category::TYPES)
            ],
            'en'      => ['required', 'array'],
            'de'      => ['required', 'array'],
            'en.name' => ['required', 'string', 'max:255'],
            'de.name' => ['required', 'string', 'max:255'],
            'en.slug' => ['nullable', 'string', 'max:255'],
            'de.slug' => ['nullable', 'string', 'max:255'],
        ];
    }
}
