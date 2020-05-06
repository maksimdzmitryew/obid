<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FestivalRequest extends FormRequest
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
			'en'				=> ['required', 'array'],
			'de'				=> ['required', 'array'],
			'slider_id'			=> ['nullable', 'integer'],
			'image_id'			=> ['nullable', 'integer'],
			'file_id'			=> ['nullable', 'integer'],
			'active'			=> ['nullable', 'boolean'],
			'published'			=> ['nullable', 'boolean'],
			'en.name'			=> ['required', 'string', 'max:191'],
			'en.about_festival'	=> ['required', 'string', 'max:25000'],
			'en.slug'			=> ['nullable', 'string', 'alpha_dash', 'max:191'],
			'en.file_id'		=> ['nullable', 'integer'],
			'en.meta_title'		=> ['nullable', 'string', 'max:191'],
			'de.name'			=> ['required', 'string', 'max:191'],
			'de.about_festival'	=> ['required', 'string', 'max:25000'],
			'de.slug'			=> ['nullable', 'string', 'alpha_dash', 'max:191'],
			'de.file_id'		=> ['nullable', 'integer'],
			'de.meta_title'		=> ['nullable', 'string', 'max:191'],
        ];
    }
}
