<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'url' => ['required', 'string'],
#            'image_id' => ['required', 'integer'],
            'category_id' => ['required', 'integer'],
            'promoting' => ['nullable', 'boolean']
        ];
    }
}
