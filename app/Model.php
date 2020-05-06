<?php

namespace App;

use                               App\Traits\GeneralTrait;
use             Illuminate\Database\Eloquent\Model          as BaseModel;
use        Astrotomic\Translatable\Contracts\Translatable   as TranslatableContract;
use                  Astrotomic\Translatable\Translatable;
use                          Illuminate\Http\Request;

class Model extends BaseModel
{
	use GeneralTrait;
	use Translatable;

	public $translatedAttributes = [];

	# https://stackoverflow.com/questions/30502922/a-construct-on-an-eloquent-laravel-model#30503372
	# The first line (parent::__construct()) will run the Eloquent Model's own construct method
	# before your code runs, which will set up all the attributes for you.
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);

		$s_basename					= class_basename(__CLASS__);
#		$this->_env					= (object) [];
		$s_tmp						= get_called_class();

		$a_tmp						= explode('\\', $s_tmp);

		if (stripos($s_tmp,'Translation') === FALSE)
		{
			$s_name						= $a_tmp[1];

			if ($a_tmp[0] == 'Modules')
			{
#				$s_name					= $a_tmp[1];
#				$s_model				= '\Modules\\' . $s_name . '\\' . $a_tmp[2] . '\\' . $s_name ;
				$s_trans				= '\Modules\\' . $s_name . '\\' . 'Database' . '\\' . $s_name ;
			}
			else
			{
				$s_name					= str_replace($s_basename, '', $s_name);
				$s_model				= '\App\\'.$s_name;
				$s_trans				= $s_model ;
			}

#			$m							= new $s_model;
			$s_tmp						= $s_trans.'Translation';

			if (class_exists($s_tmp))
			{
				$t							= new $s_tmp;
				$a_fill_trans				= $t->getFillable();
#				$a_form_main				= $m->getFields();
#				$a_form_trans				= $t->getFields();
				$this->translatedAttributes = $a_fill_trans;
			}
		}
	}

	/**
	 * Unify number formatting
	 *
	 * @param Float		$i_num		Number to be formatted
	 * @param Integer	$i_num		Decimal places
	 *
	 * @return String	formatted number
	 */
	public static function formatNumber(float $i_num, int $i_decimal = NULL) : String
	{
		return number_format($i_num, $i_decimal ?? 0, ',', '’');
	}
	public function scopeFilter($query, $filters)
	{
		return $filters->apply($query);
	}

	public function getFields()
	{
		return $this->a_form;
	}

	/**
	 * check possible boolean values in submitted form and set them to request
	 * so that checkboxes can be saved correctly
	 *
	 * @param Request	$request		Model specific
	 *
	 * @return Request	as per Model specific
	 */
	public static function _addBoolsValuesFromForm($request)
	{
		$request->merge([
			'published' => !! $request->published,
		]);
	}

	/**
	 * Get 2 columns from DB and organise them for a specific need
	 * @param Request	$request		Data from request
	 * @param Filters	$filters		Whatever filters applied
	 * @param String	$s_model		Model name to retrieve data from
	 * @param Bool		$b_published	NULL (default) = all, TRUE/FALSE
	 * @param Array		$a_include_ids	if only specific ids are needed
	 * @param Array		$a_exclude_ids	if some ids are not needed
	 * @param Bool		$b_byid			id will be the key and title will be the value
	 * @param Bool		$b_sort_bytitle	default sorting is by the key
*/
#	 * @param Bool		$b_json			Data from request
/*	 *
	 * @return Array	set of results
	 */
	public static function getIdTitle(Request $request, $filters, String $s_model, $b_published, Array $a_include_ids, Array $a_exclude_ids, Bool $b_sort_bytitle, Bool $b_byid
#		, Bool $b_json
	) : Array
	{
#		$a_element_ids			= Style::findOrFail($i_style_id)->element()->get()->pluck('id')->toArray();
#		$a_issue_ids = Design::findOrFail($i_design_id)->issue()->get()->pluck('id')->toArray();
#		$t_ids = $this->event->translations->pluck('id', 'locale')->toArray();
#		$artists->pluck('id')->toArray()
#		Category::select('type')->distinct()->get()->map->type->toArray(),
#		->keyBy('id')

		/**
		 * 'text' is used when providing data directly to select2
		 * https://select2.org/data-sources/ajax
		*/
		$s_title = 'title';
#		if ($b_json)
#			$s_title = 'text';

		$fn_select				= '\Modules\\' . $s_model . '\\' . 'Database' . '\\' . $s_model . '::select';
		$fn_filter				= '\Modules\\' . $s_model . '\\' . 'Database' . '\\' . $s_model . '::filter';


		if (is_null($filters))
			$o_items			= $fn_select('id');
		else
			$o_items			= $fn_filter($filters);

		if (!empty($a_include_ids))
			$o_items			= $o_items->whereIn(strtolower($s_model).'s.id', $a_include_ids);

		if (!empty($a_exclude_ids))
			$o_items			= $o_items->whereNotIn(strtolower($s_model).'s.id', $a_exclude_ids);

		if (!is_null($b_published))
			$o_items			= $o_items->wherePublished($b_published);

		$o_items = $o_items->get()->map( function($o_item) use ($s_title) {
			return ['id' => $o_item->id, $s_title => $o_item->title];
		});

		if ($b_sort_bytitle)
			$o_items			= $o_items->sortBy('title');

#		foreach ($o_items AS $k => $v)
#			dump($k, $v);

#dd($o_items);
		$a_res = [];
		if ($b_byid)
		{
			foreach ($o_items AS $k => $v)
				$a_res[$v['id']]	= $v['title'];

#			for ($i = 0; $i < count($o_items); $i++)
#				$a_res[$o_items[$i]['id']] = $o_items[$i][$s_title];
#			if ($b_sort_bytitle)
#				asort($a_res);
		}
		else
		{
#			$a_res				= $o_items;
#			if ($b_sort_bytitle)
#				$a_res			= $a_res->sortBy('title');
#			$a_res				= $o_items->toArray();
/*
			$a_items = [];
			foreach ($a_res AS $k => $v)# ($i = 0; $i < count($a_items); $i++)
				$a_items[] = ['id' => $k, $s_title => $v];
			$a_res = $a_items;
*/
			foreach ($o_items AS $k => $v)# ($i = 0; $i < count($a_items); $i++)
				$a_res[]			= ['id' => $v['id'], $s_title => $v['title']];
		}
#dd($a_res);
		return $a_res;
	}

}
