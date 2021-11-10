<?php

namespace Modules\Text\Database;

use                          Illuminate\Support\Carbon;
use                                         App\Model;
use                             Illuminate\Http\Request;
use                  Illuminate\Support\Facades\Schema;
use                 Cviebrock\EloquentSluggable\Sluggable;
use        Cviebrock\EloquentSluggable\Services\SlugService;
use                          Illuminate\Support\Str;


class Text extends Model
{
    use Sluggable;

    protected $connection = 'psc';
    protected $fillable = [
        'published',
        'is_translatable',
        'slug',
        'value',
    ];
    public $translatedAttributes = [];

    protected $a_form = [
        'published'     => [
            'tab'       => 'data',
            'field'     => 'checkbox',
            'rules'     => 'boolean',
            'default'   =>  true,
        ],
        'is_translatable'     => [
            'tab'       => 'data',
            'field'     => 'checkbox',
            'rules'     => 'boolean',
            'default'   =>  false,
        ],
        'slug'      => [
            'tab'       => 'data',
            'field'     => 'input',
            'rules'     => '',#'sometimes|unique:pr_texts,id|max:255',
        ],
        'value'      => [
            'tab'       => 'data',
            'field'     => 'input',
            'rules'     => '',
        ],
    ];
/*
    public function __construct()
    {
 #       dd($this);

#        $r = self::wherePublished(1);
#        dd($r->toSql(), $r->count(), $r->first() );
/*
        foreach (self::wherePublished(1)->get() as $text) {
            $this->{$text->slug} = $text->is_translatable
                ? $text->translated_value
                : $text->value
            ;
        }
* /
        $o_texts                    = self::all('id', 'slug', 'published');

#        parent::__construct();

    }
*/

    public static function getPublishedForView() : Object
    {
        $o_texts_data            = new \stdClass;

        /**
         *  this is needed for a fresh install
         *  when tabe is not there yet
         */
        $o_model = new self;
        $s_prefix = $o_model->getConnection()->getTablePrefix();
        $s_table = $o_model->getTable();
        $s_conn = $o_model->getConnection()->getConfig()['name'];

        $b_model_table = Schema::connection($s_conn)->hasTable($s_table);
        if (!$b_model_table)
        {
            $o_texts_data->theme     = '';
            return $o_texts_data;
        }

        $o_texts_published       = self::all('id', 'slug', 'value', 'is_translatable');
        foreach ($o_texts_published AS $o_text)
        {
            $s_value = '';
            if (!$o_text->is_translatable)
            {
                $s_value = $o_text->value;
            }
            /**
             *  some texts might be missing translated value at all
             */
            elseif ($o_translated = $o_text->translate(app()->getLocale()))
            {
                $s_value = $o_translated->translated_value;
            }

            $o_texts_data->{$o_text->slug}   = $s_value;

        }
        return $o_texts_data;
    }

    public static function getItem(Request $request, Object $o_env, String $s_slug, Bool $b_published = NULL) : Object
    {
        $o_sql           = self::where('slug', $s_slug);
        if (!is_null($b_published))
        {
            $o_sql->wherePublished($b_published);
        }
        $o_text          = $o_sql->firstOrFail();
        $fn_find         = $o_env->fn_find;
        $o_text          = $fn_find($o_text->id);
        $a_atts          = [];
        $o_text->atts    = $a_atts;

        return $o_text;
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
