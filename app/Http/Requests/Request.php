<?php

namespace App\Http\Requests;

use               Illuminate\Foundation\Http\FormRequest as BaseRequest;
use                                          ReflectionClass;
use                                          ReflectionMethod;

class Request extends BaseRequest
{
	protected $_env = [];

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 * Add rules per language locale
	 * and multiply translatable rules
	 *
	 * @return array
	 */
	public function rulesLng(Array $a_rules) : Array
	{
		$s_basename					= class_basename(__CLASS__);
		$this->_env					= (object) [];
		$s_tmp						= get_called_class();
		$a_tmp						= explode('\\', $s_tmp);
		$this->_env->s_name			= str_replace($s_basename, '', $a_tmp[3]);

		if ($a_tmp[0] == 'Modules')
		{
			$this->_env->s_name		= $a_tmp[1];
			$this->_env->s_model	= '\Modules\\' . $this->_env->s_name . '\\' . $a_tmp[2] . '\\' . $this->_env->s_name ;
			$this->_env->s_trans	= '\Modules\\' . $this->_env->s_name . '\\' . 'Database' . '\\' . $this->_env->s_name ;
		}
		else
		{
			$this->_env->s_name		= str_replace($s_basename, '', $a_tmp[3]);
			$this->_env->s_model	= '\App\\'.$this->_env->s_name;
			$this->_env->s_trans	= $this->_env->s_model ;
		}

		$a_form_main				= [];
		$a_fill_main				= [];
		$a_form_trans				= [];
		$a_fill_trans				= [];

		$s_tmp						= $this->_env->s_model;
		if (class_exists($s_tmp))
		{
			$m						= new $s_tmp;
			$a_fill_main			= $m->getFillable();
			$a_form_main			= $m->getFields();
#			$a_form_main			= $m->a_form;
		}
		$s_tmp						= $this->_env->s_trans.'Translation';
		if (class_exists($s_tmp))
		{
			$t						= new $s_tmp;
			$a_fill_trans			= $t->getFillable();
			$a_form_trans			= $t->getFields();
#			$a_form_trans			= $t->a_form;
		}

		$a_rules_all = [];
		$a_locales = config('translatable.locales');

		for ($i = 0; $i < count($a_locales); $i++)
		{
			$a_rules_all[$a_locales[$i]] = 'required|array';
			for ($j = 0; $j < count($a_fill_trans); $j++)
			{
				if (array_key_exists($a_fill_trans[$j], $a_form_trans))
				{
					$s_tmp = $a_locales[$i].'.'.$a_fill_trans[$j];
					$a_rules_all[$s_tmp] = $a_form_trans[$a_fill_trans[$j]]['rules'];
				}
			}
		}

		foreach ($a_form_main AS $s_name => $a_params) {
			$a_rules_all[$s_name]	= $a_params['rules'];
		}
/*
		for ($i = 0; $i < count($a_locales); $i++)
		{
			$a_rules_all[$a_locales[$i]] = 'required|array';
			for ($j = 0; $j < count($a_fill_trans); $j++)
			{
				if (array_key_exists($a_fill_trans[$j], $a_rules))
				{
					$s_tmp = $a_locales[$i].'.'.$a_fill_trans[$j];
					$a_rules_all[$s_tmp] = $a_rules[$a_form_trans[$j]];
				}
			}
		}

		for ($j = 0; $j < count($a_form_main); $j++)
		{
			if (array_key_exists($a_form_main[$j], $a_form_trans))
			{
				$s_tmp = $a_locales[$i].'.'.$a_form_main[$j];
				$a_rules_all[$s_tmp] = $a_rules[$a_form_main[$j]];
			}
		}

		foreach ($a_rules AS $s_name => $s_rule)
		{
			if (!in_array($s_name, $a_fill_trans))
				$a_rules_all[$s_name] = $s_rule;
		}
*/

		$reflector = new ReflectionClass($this->_env->s_model);
		$a_relations = [];
		foreach ($reflector->getMethods() as $reflectionMethod) {
			$returnType = $reflectionMethod->getReturnType();
			if ($returnType) {
				$s_type = class_basename($returnType->getName());

	#            if (in_array(class_basename($returnType->getName()), ['hasOne', 'hasMany', 'belongsTo', 'belongsToMany', 'morphToMany', 'morphTo'])) {
				if (in_array($s_type, ['HasOne', 'HasMany', 'BelongsTo', 'BelongsToMany', 'MorphToMany', 'MorphTo'])) {
					$s_meth_name=$reflectionMethod->name;

				if (
					stripos($s_meth_name, 'translation') === FALSE
	#	&&
	#	method_exists($m->$s_meth_name(), 'getRelated') && is_callable(array($m->$s_meth_name(), 'getRelated'))
					&&
					method_exists($m->$s_meth_name()->getRelated(), 'getFillable') && is_callable(array($m->$s_meth_name()->getRelated(), 'getFillable'))
					&&
					method_exists($m->$s_meth_name()->getRelated(), 'getFields') && is_callable(array($m->$s_meth_name()->getRelated(), 'getFields'))
					)
					{
						$a_relations[] = $s_meth_name;
					}
				}
			}
		}

		unset($reflector);
	#    dump($a_relations);


#	$a_fields_rel = $m->$s_meth_name()->getRelated()->getFields();



		for ($i = 0; $i < count($a_relations); $i++)
		{
			$s_meth_name			= $a_relations[$i];
			$a_fill_rel				= $m->$s_meth_name()->getRelated()->getFillable();
			$a_form_rel				= $m->$s_meth_name()->getRelated()->getFields();

			$a_rules_all[$s_meth_name] = 'required|array';
			for ($j = 0; $j < count($a_fill_rel); $j++)
			{
				if (array_key_exists($a_fill_rel[$j], $a_form_rel))
				{
					$s_tmp = $s_meth_name.'.*.'.$a_fill_rel[$j];
					$a_rules_all[$s_tmp] = $a_form_rel[$a_fill_rel[$j]]['rules'];
				}
			}
#dump($a_fill_rel, $a_form_rel);

		}

#dd($a_rules_all);

  #dump($reflectionMethod->name,class_basename($returnType->getName()), $s_meth_name, method_exists($m->$s_meth_name(), 'getRelated'));


#$cm = get_class_methods($m);
#foreach ($cm AS $k => $v)
#{#getSpecificLists
	/*
	try
	{
		dd($v, $m->a_relations, $m->getA_relations(), $m->getParameters(), $m->vote);#, get_class_vars($m), get_object_vars($m), method_exists($m, $v), $m->vote());
	}
	catch (Exception $e)
	{
		echo 'ok';
	}
	die();
	*/
/*
if (
	method_exists($m->$v(), 'getRelated') && is_callable(array($m->$v(), 'getRelated'))
	&&
	method_exists($m->$v()->getRelated(), 'getFields') && is_callable(array($m->$v()->getRelated(), 'getFields'))
	)
dd($m->$v()->getRelated()->getFields());


	dd($v, $m->$v());
}
*/
/*
		dd($cm);
if (
	method_exists($m->vote(), 'getRelated') && is_callable(array($m->vote(), 'getRelated'))
	&&
	method_exists($m->vote()->getRelated(), 'getFields') && is_callable(array($m->vote()->getRelated(), 'getFields'))
	)
dd($m->vote()->getRelated()->getFields());
dd($m->vote()->getRelated()->getFields(), get_class_methods($this->_env->s_model), get_class_methods($m->vote()), $a_rules_all);
*/


#dd($a_rules_all);
		return $a_rules_all;
	}
}
