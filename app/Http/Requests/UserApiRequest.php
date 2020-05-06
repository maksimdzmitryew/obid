<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserApiRequest extends FormRequest
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
            'first_name'          => ['nullable', 'string', 'max:191'],
            'last_name'           => ['nullable', 'string', 'max:191'],
            'email'               => ['nullable', 'string', 'max:191'],

            'start'               => ['nullable', 'integer'],
            'length'              => ['nullable', 'integer'],

            'filters'             => 'array',
            'filters.id'          => 'array',
            'filters.id.*'        => 'int',
            'filters.name'        => 'string|max:255',

            'columns'             => ['nullable', 'array'],
            'columns.*.data'      => ['nullable', 'string'],
            'order'               => ['nullable', 'array'],
            'order.*.column'      => ['nullable', 'integer'],
            'order.*.dir'         => ['nullable', 'string'],

            'created_at'          => ['nullable', 'array'],
            'created_at.from'     => ['nullable', 'date'],
            'created_at.to'       => ['nullable', 'date'],

            'updated_at'          => ['nullable', 'array'],
            'updated_at.from'     => ['nullable', 'date'],
            'updated_at.to'       => ['nullable', 'date'],
        ];
    }
}
