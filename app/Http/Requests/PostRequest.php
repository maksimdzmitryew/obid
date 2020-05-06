<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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

        if ($this->post) {
            $t_ids = $this->post->translations->pluck('id', 'locale')->toArray();
        }

        return [
            'event_id'            => ['nullable', 'integer'],
            'festival_id'         => ['required', 'integer'],
            'category_id'         => ['required', 'integer'],
            'gallery_id'          => ['nullable', 'integer'],
            'en'                  => ['required', 'array'],
            'de'                  => ['required', 'array'],
            'en.slug'             => ['nullable', 'string', 'max:255', 'unique:post_translations,slug,' . $t_ids['en']],
            'en.title'            => ['required', 'string', 'max:255'],
            'en.excerpt'          => ['required', 'string'],
            'en.meta_title'       => ['nullable', 'string', 'max:255'],
            'en.meta_keywords'    => ['nullable', 'string'],
            'en.meta_description' => ['nullable', 'string'],
            'de.slug'             => ['nullable', 'string', 'max:255', 'unique:post_translations,slug,' . $t_ids['de']],
            'de.title'            => ['required', 'string', 'max:255'],
            'de.excerpt'          => ['required', 'string'],
            'de.meta_title'       => ['nullable', 'string', 'max:255'],
            'de.meta_keywords'    => ['nullable', 'string'],
            'de.meta_description' => ['nullable', 'string'],
        ];
    }
}
