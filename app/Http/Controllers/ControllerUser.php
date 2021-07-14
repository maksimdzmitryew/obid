<?php

namespace App\Http\Controllers;

use                        App\Http\Controllers\Controller     as BaseController;
use                             Illuminate\Http\Request;

class ControllerUser	extends BaseController
{
	/**
	 * Open CRUD form to authenticated user (aka "Admin" previously and now "User")
	 * for creating/editing the specified resource.
	 * @param Request	$request		Data from request
	 *
	 * @return View		instance of
	 */
	public function form(Request $request) : \Illuminate\View\View
	{
		$this->setEnv();
		$fn_find = $this->_env->fn_find;

		$this->validate($request, [
			'id' => 'integer'
		]);



		$a_data							= [];
		$a_data[$this->_env->s_sgl] 	= $fn_find($request->id);
		$a_data['form'] 				= [
										'tabs'		=> $this->_env->a_tab,
										'fields'	=> $this->_env->a_field,
										'rules'		=> $this->_env->a_rule,
										];

		/**
		 *	collect dependent data for select dropdowns
		 *	for fields like '*_id(s)'
		 */
		foreach ($this->_env->a_field AS $s_name_tab => $a_fields)
		{
			foreach ($a_fields AS $s_name_field => $s_field_type)
			{
				if (stristr($s_name_field, '_id'))
				{
					$id				= $s_name_field;
					$b_many			= (stristr($s_name_field, '_ids'));
					$s_name_field	= str_replace(['_ids','_id',], '', $s_name_field);
					$s_model		= '\Modules\\' . $s_name_field . '\\' . 'Database' . '\\' . $s_name_field;
					$fn_all			= $this->_env->s_model.'::all';
					$o_res			= $fn_all();
					$s_tmp			= $s_name_field . '_list';
					$a_data[$s_tmp] = $o_res;
				}
			}
		}
		return view($this->_env->s_view . 'form', $a_data);
	}

	/**
	 * Show list of items for authenticated user (aka "Admin" previously and now "User")
	 *
	 * @param void
	 *
	 * @return View		instance of
	 */
	public function index() : \Illuminate\View\View
	{
		$this->setEnv();
		return view($this->_env->s_view . 'list', [
			'dates'					=> $this->_env->s_model::getTimestampDates(),
		]);
	}
}
