<?php

namespace Modules\Page\Database;

use App\Model;
#use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
		'excerpt',
		'body',
		'meta_title',
		'meta_keywords',
		'meta_description',
	];

	public $a_form = [
		'title'			=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'required|string|max:255',
		],
		'excerpt'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'required|string',
		],
		'body'	=> [
			'tab'		=> 'data',
			'field'		=> 'textarea',
			'rules'		=> 'string|max:65536',
		],
		'meta_title'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
		],
		'meta_keywords'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
		],
		'meta_description'	=> [
			'tab'		=> 'data',
			'field'		=> 'input',
			'rules'		=> 'string|max:255',
		],
	];
}
