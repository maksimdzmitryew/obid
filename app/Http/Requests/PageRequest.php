<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
        $t_ids['en'] = null;
        $t_ids['de'] = null;

        if ($this->page) {
            $t_ids = $this->page->translations->pluck('id', 'locale')->toArray();
        }

        return [
            'en'					=> ['required', 'array'],
            'de'					=> ['required', 'array'],
			'published'				=> ['nullable', 'boolean'],
            'slug'					=> ['nullable', 'string', 'max:255', 'unique:pages,slug,' . $t_ids['en']],
            'en.name'				=> ['required', 'string', 'max:255'],
            'en.excerpt'         	=> ['required'],
            'en.body'         		=> ['required'],
            'en.meta_title'			=> ['nullable', 'string', 'max:255'],
            'en.meta_keywords'		=> ['nullable', 'string'],
            'en.meta_description'	=> ['nullable', 'string'],
            'de.name'				=> ['required', 'string', 'max:255'],
            'de.excerpt'			=> ['required'],
            'de.body'         		=> ['required'],
            'de.meta_title'			=> ['nullable', 'string', 'max:255'],
            'de.meta_keywords'		=> ['nullable', 'string'],
            'de.meta_description'	=> ['nullable', 'string'],
        ];
    }
}
