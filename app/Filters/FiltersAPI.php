<?php


namespace App\Filters;

use                                          DB;
use                              App\Filters\Filters;
use                          Illuminate\Http\Request;
use                       Illuminate\Support\Str;

class FiltersAPI extends Filters
{
	protected $filters = [
		'created_at',
		'id',
		'published',
		'title',
		'updated_at',
	];

	protected function title($title)
	{
		return $this->builder->whereTranslationLike('title', '%' . $title . '%', $this->appLocale);
	}

	protected function getQuery()
	{

		$s_basename					= class_basename(__CLASS__);
		$this->_env					= (object) [];
		$s_tmp						= get_called_class();
		$a_tmp						= explode('\\', $s_tmp);
		$this->_env->s_name			= str_replace($s_basename, '', $a_tmp[3]);
		$this->orderColumn			= $this->getOrderColumn('title');

		if ($a_tmp[0] == 'Modules')
		{
			$this->_env->s_name		= $a_tmp[1];
			$this->_env->s_model	= '\Modules\\' . $this->_env->s_name . '\\' . $a_tmp[2] . '\\' . $this->_env->s_name ;
			$this->_env->s_main		= '\Modules\\' . $this->_env->s_name . '\\' . 'Database' . '\\' . $this->_env->s_name ;
			$this->_env->s_trans	= $this->_env->s_main . 'Translation' ;
		}
		else
		{
			$this->_env->s_name		= str_replace($s_basename, '', $a_tmp[4]);
			$this->_env->s_model	= '\App\\'.$this->_env->s_name;
			$this->_env->s_trans	= $this->_env->s_model;
		}

		$o_query					= $this->builder;

		$a_select					= [];
		$s_tmp						= $this->_env->s_main;
		if (class_exists($s_tmp))
		{
			$m						= new $s_tmp;
			$a_fill_main			= $m->getFillable();
			$a_form_main			= $m->getFields();
			$s_table_main			= $m->getTable();
			$a_select[]				= $s_table_main.'.*';
			$s_parent_trans			= $m->translatedModel;
		}

		if (!is_null($s_parent_trans))
		{
			$s_tmp					= ucfirst($s_parent_trans);
			$this->_env->s_trans	= '\Modules\\' . $s_tmp . '\\' . 'Database' . '\\' . $s_tmp . 'Translation' ;
			$s_name_sgl				= $s_parent_trans;
		}
		else
		{
			$s_name_sgl				= Str::singular($s_table_main);
		}

		$s_tmp						= $this->_env->s_trans;
		if (class_exists($s_tmp))
		{
			$t						= new $s_tmp;
			$a_fill_trans			= $t->getFillable();
			$a_form_trans			= $t->getFields();
			$s_table_trans			= $t->getTable();
			$a_select[]				= $s_table_trans.'.title AS title';

			$s_key_on				= '';
			if (!is_null($s_parent_trans))
			{
				$s_key_on			= $s_name_sgl.'_';
			}

			$s_key_at				= $s_table_trans . '.' . $s_name_sgl . '_id';
			$s_key_on				= $s_table_main . '.' . $s_key_on . 'id';

			$o_query
				->leftJoin($s_table_trans, function($query) use ($s_key_at, $s_key_on) {
					$query->on($s_key_at, '=', $s_key_on)
						->where('locale', '=', $this->appLocale);
				});
		}

		$o_query
				->select($a_select)
				->offset($this->request->start)
				->limit($this->limit)
				->orderBy($this->orderColumn, $this->orderDirection)
			;

		return $o_query;
	}
}
