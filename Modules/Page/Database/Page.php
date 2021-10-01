<?php

namespace Modules\Page\Database;

use                          Illuminate\Support\Carbon;
use                                         App\Model;
use                             Illuminate\Http\Request;
use                 Cviebrock\EloquentSluggable\Sluggable;
use        Cviebrock\EloquentSluggable\Services\SlugService;
use                          Illuminate\Support\Str;


class Page extends Model
{
    use Sluggable;

	protected $connection = 'psc';
	protected $fillable = [
		'slug',
		'page_id',
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
		'page_id'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> 'integer',
		],
		'slug'		=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> ''#'sometimes|unique:pr_pages,id|max:255',
		],
	];

    protected static function boot()
    {
        parent::boot();

        static::saving(function($model) {
            $model->meta_title = Str::limit($model->meta_title ?: $model->title, 160);
            $model->meta_keywords = $model->meta_keywords ?: '';
            $model->meta_description = $model->meta_description ?: Str::limit(strip_tags($model->description), 160);
        });
    }

	public static function getItem(Request $request, Object $o_env, String $s_slug, Bool $b_published = NULL) : Object
	{
		$o_sql		= self::where('slug', $s_slug);
		if (!is_null($b_published))
		{
			$o_sql->wherePublished($b_published);
		}
		$o_page		= $o_sql->firstOrFail();
		$fn_find	= $o_env->fn_find;
		$o_page		= $fn_find($o_page->id);
		$a_atts		= [];
		$o_page->atts= $a_atts;

		return $o_page;
	}

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function page()
    {
        return $this->BelongsTo('Modules\Page\Database\Page');
    }

}
