<?php


namespace App\Filters;

use                                          DB;
use                              App\Filters\Filters;
use                          Illuminate\Http\Request;
use                       Illuminate\Support\Pluralizer;

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
			$this->_env->s_trans	= '\Modules\\' . $this->_env->s_name . '\\' . 'Database' . '\\' . $this->_env->s_name ;
		}
		else
		{
			$this->_env->s_name		= str_replace($s_basename, '', $a_tmp[4]);
			$this->_env->s_model	= '\App\\'.$this->_env->s_name;
			$this->_env->s_trans	= $this->_env->s_model ;
		}
		$s_name_sgl = strtolower($this->_env->s_name);
		$s_name_plr = Pluralizer::plural($s_name_sgl, 2);
		$s_table_main = $s_name_plr;
		$s_table_trans = $s_name_sgl.'_translations';

		return $this->builder->select(
				$s_table_main.'.*',
				$s_table_trans.'.title as title'
			)
			->offset($this->request->start)
			->limit($this->limit)
			->leftJoin($s_table_trans, function($query) use ($s_name_sgl, $s_name_plr, $s_table_trans) {
				$query->on($s_table_trans.'.'.$s_name_sgl.'_id', '=', $s_name_plr.'.id')
					->where('locale', '=', $this->appLocale);
			})
			->orderBy($this->orderColumn, $this->orderDirection);
	}
}
