<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryApiRequest extends FormRequest
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
            'columns'             => ['nullable', 'array'],
            'columns.*.data'      => ['nullable', 'string'],
            'order'               => ['nullable', 'array'],
            'order.*.column'      => ['nullable', 'integer'],
            'order.*.dir'         => ['nullable', 'string'],
            'created_at'          => ['nullable', 'array'],
            'updated_at'          => ['nullable', 'array'],
            'created_at.from'     => ['nullable', 'date'],
            'created_at.to'       => ['nullable', 'date'],
            'updated_at.from'     => ['nullable', 'date'],
            'updated_at.to'       => ['nullable', 'date'],
        ];
    }
}
