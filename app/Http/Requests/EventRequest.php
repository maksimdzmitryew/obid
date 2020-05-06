<?php

namespace App\Http\Requests;

use App\Category;
use App\EventTranslation;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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

        if ($this->event) {
            $t_ids = $this->event->translations->pluck('id', 'locale')->toArray();
        }

        return [
            'festival_id'            => ['required', 'integer'],
            'category_id'            => ['required', 'integer'],
            'gallery_id'             => ['nullable', 'integer'],
            'image_id'               => ['nullable', 'integer'],
            'artists'                => ['nullable', 'array'],
            'artists.*'              => ['required_with:artists', 'array'],
            'artists.directors'      => ['array'],
            'artists.directors.*'    => ['integer'],
            'artists.artists.'       => ['array'],
            'artists.artists.*'      => ['integer'],
            'artists.producers'      => ['array'],
            'artists.producers.*'    => ['integer'],
            'artists.executive_producers'      => ['array'],
            'artists.executive_producers.*'    => ['integer'],
            'en'                     => ['required', 'array'],
            'de'                     => ['required', 'array'],
            'en.slug'                => ['nullable', 'string', 'max:255', 'unique:event_translations,slug,' . $t_ids['en']],
            'en.title'               => ['required', 'string', 'max:255'],
            'en.description'         => ['required'],
            'en.meta_title'          => ['nullable', 'string', 'max:255'],
            'en.meta_keywords'       => ['nullable', 'string'],
            'en.meta_description'    => ['nullable', 'string'],
            'de.slug'                => ['nullable', 'string', 'max:255', 'unique:event_translations,slug,' . $t_ids['de']],
            'de.title'               => ['required', 'string', 'max:255'],
            'de.description'         => ['required'],
            'de.meta_title'          => ['nullable', 'string', 'max:255'],
            'de.meta_keywords'       => ['nullable', 'string'],
            'de.meta_description'    => ['nullable', 'string'],
            'holdings'               => ['required', 'array'],
            'holdings.*.date_from'   => ['required', 'string', 'max:191'],
            'holdings.*.date_to'     => ['required', 'string', 'max:191'],
            'holdings.*.place_id'    => ['required', 'integer'],
            'holdings.*.ticket_url'  => ['nullable', 'string', 'max:255'],
        ];
    }
}
