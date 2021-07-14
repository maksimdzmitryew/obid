<?php

namespace Modules\Page\Database;

use                          Illuminate\Support\Carbon;
use                                  App\Traits\Fileable;
use                                         App\Model;
use                             Illuminate\Http\Request;
use                 Cviebrock\EloquentSluggable\Sluggable;
use        Cviebrock\EloquentSluggable\Services\SlugService;
use                          Illuminate\Support\Str;


class Page extends Model
{
    use Fileable;
    use Sluggable;

	protected $connection = 'psc';
	protected $fillable = [
		'slug',
		'page_id',
		'file_uk',
		'file_en',
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
		'file_uk'		=> [
			'tab'		=> 'data',
			'field'		=> 'file',
			'rules'		=> 'integer',
		],
		'file_en'		=> [
			'tab'		=> 'data',
			'field'		=> 'file',
			'rules'		=> 'integer',
		],
	];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
        	foreach ($model->files AS $o_file)
        	{
        		$o_file->delete();
        	}
        });

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
		$o_page		= $o_sql->firstOrFail();#->load(['files']);
		$fn_find	= $o_env->fn_find;
		$o_page		= $fn_find($o_page->id);
		$a_atts		= [];
		foreach ($o_page->files AS $o_file)
		{
			$a_fields = $o_env->a_types['file'];
			for ($i = 0; $i < count($a_fields); $i++)
			{
				$s_tmp	= $a_fields[$i];
				if ($o_file->id == $o_page->$s_tmp)
				{
					$a_atts[$s_tmp] = 	$o_file;
				}
			}
		}
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
