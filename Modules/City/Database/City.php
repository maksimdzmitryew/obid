<?php

namespace Modules\City\Database;

use                          Illuminate\Support\Carbon;
use                                         App\Model;
use                             Illuminate\Http\Request;
use                 Cviebrock\EloquentSluggable\Sluggable;
use        Cviebrock\EloquentSluggable\Services\SlugService;
use                          Illuminate\Support\Str;


class City extends Model
{
    use Sluggable;

	protected $connection = 'psc';
	protected $fillable = [
		'slug',
		'country_id',
		'published',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
		'country_id'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> 'integer',
		],
		'slug'		=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> ''#'sometimes|unique:pr_citys,id|max:255',
		],
	];

	public static function getItem(Request $request, Object $o_env, String $s_slug, Bool $b_published = NULL) : Object
	{
		$o_sql		= self::where('slug', $s_slug);
		if (!is_null($b_published))
		{
			$o_sql->wherePublished($b_published);
		}
		$o_city		= $o_sql->firstOrFail();
		$fn_find	= $o_env->fn_find;
		$o_city		= $fn_find($o_city->id);
		$a_atts		= [];
		$o_city->atts= $a_atts;

		return $o_city;
	}

    public static function getAllForView() : Array
    {
		$o_citys					= self::all('id', 'slug', 'published', 'country_id');
		$a_citys					= [];
		foreach ($o_citys AS $o_city)
		{
			$a_citys[$o_city->id]	=
			[
				'id' => $o_city->id,
				'country_id' => $o_city->country_id,
				'title' => $o_city->translate(app()->getLocale())->title,
				'slug' => $o_city->slug,
				'excerpt' => $o_city->translate(app()->getLocale())->excerpt,
				'published' => $o_city->published,
			];
		}
		return $a_citys;
	}

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function country()
    {
        return $this->BelongsTo('Modules\Country\Database\Country');
    }

}
