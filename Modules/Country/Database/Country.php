<?php

namespace Modules\Country\Database;

use                                         App\Model;
use                             Illuminate\Http\Request;


class Country extends Model
{
    protected $connection = 'psc';
    protected $fillable = [
        'slug',
        'published',
    ];
    public $translatedAttributes = [];
    protected $a_form = [
        'published'     => [
            'tab'       => 'data',
            'field'     => 'checkbox',
            'rules'     => 'boolean',
            'default'   =>  TRUE,
        ],
        'slug'       => [
            'tab'       => 'data',
            'field'     => 'input',
            'rules'     => 'unique:pr_countries,slug|max:2',
        ],
    ];

    public static function getItem(Request $request, Object $o_env, String $s_slug, Bool $b_published = NULL) : Object
    {
        $o_sql          = self::where('slug', $s_slug);
        if (!is_null($b_published))
        {
            $o_sql->wherePublished($b_published);
        }
        $o_country      = $o_sql->firstOrFail();
        $fn_find        = $o_env->fn_find;
        $o_country      = $fn_find($o_country->id);
        $a_atts         = [];
        $o_country->atts= $a_atts;

        return $o_country;
    }

    public static function getAllForView() : Array
    {
        $o_countries                    = self::all('id', 'slug', 'published');
        $a_countries                    = [];
        foreach ($o_countries AS $o_country)
        {
            $a_countries[$o_country->id]    =
            [
                'id' => $o_country->id,
                'title' => $o_country->translate(app()->getLocale())->title,
                'published' => $o_country->published,
            ];
        }
        return $a_countries;
    }

}
