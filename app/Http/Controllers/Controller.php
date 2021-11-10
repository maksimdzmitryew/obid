<?php

namespace App\Http\Controllers;

use                                             Auth;
use           Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use                   Illuminate\Foundation\Bus\DispatchesJobs;
use                                         App\File;
use            Illuminate\Foundation\Validation\ValidatesRequests;
use                          Illuminate\Routing\Controller     as BaseController;
use                          Illuminate\Support\Pluralizer;
use                       Modules\Page\Database\Page;
use                    Modules\Setting\Database\Setting;
use                                             ReflectionClass;
use                                             ReflectionMethod;
use                  Illuminate\Support\Facades\Schema;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $_env = [];
	protected $a_fields = [];

	public function downloadFile($i_file_id)
	{
		$res = File::findOrFail($i_file_id);
		return $res->downloadAttachment($i_file_id);
	}


	public function setEnv()
	{
		/**
		 *	sometimes Laravel's cache is not updated when file is changed
		 *	this happens when file is copied from external source
		 *	rather than edited and saved locally;
		 *
		 * 	another option would be to open file, modify (add space character) and save
		 *	however this is not convenient in case of multiple files updates
		 */
		if (app()->environment('local', 'acceptance', 'testing'))
		{
		  $exitCode = \Artisan::call('cache:clear');
		  $exitCode = \Artisan::call('view:clear');
		}

		$s_basename					= class_basename(__CLASS__);
		$this->_env					= (object) [];
		$s_tmp						= get_called_class();
		$a_tmp						= explode('\\', $s_tmp);
		$this->_env->s_name			= str_replace($s_basename, '', $a_tmp[3]);

		$o_settings		= Setting::getPublishedForView();

/*
		// TODO refactroring
		// app/Providers/ViewComposerServiceProvider.php

		// TODO refactroring
		// for purpose of unit-testing only
		if (!isset($o_settings) || !isset($o_settings->theme))
		{
			$a_modules = config('fragment.modules');
			$o_settings->theme = lcfirst($a_modules[0]);
			$o_settings->title = 'Controller';
			$o_settings->established = 2020;
			$o_settings->email = 'no@spam.com';
		}
*/

		$this->_env->s_theme		= $o_settings->theme;
		$this->_env->s_title		= $o_settings->title;
		$this->_env->s_email		= $o_settings->email;

		if ($a_tmp[0] == 'Modules')
		{
			$this->_env->s_name		= $a_tmp[1];
#			$this->_env->s_model	= '\Modules\\' . $this->_env->s_name . '\\' . $a_tmp[2] . '\\' . $this->_env->s_name ;
			$this->_env->s_model	= '\Modules\\' . $this->_env->s_name . '\\' . 'Database' . '\\' . $this->_env->s_name ;

			$this->_env->s_trans	= '\Modules\\' . $this->_env->s_name . '\\' . 'Database' . '\\' . $this->_env->s_name ;
		}
		else
		{
			$this->_env->s_name		= str_replace($s_basename, '', $a_tmp[4]);
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
		}
		$s_tmp						= $this->_env->s_trans.'Translation';
		if (class_exists($s_tmp))
		{
			$t						= new $s_tmp;
			$a_fill_trans			= $t->getFillable();
			$a_form_trans			= $t->getFields();
		}

		$this->_env->s_sgl			= strtolower($this->_env->s_name);
		$this->_env->fn_find		= $this->_env->s_model.'::findOrNew';
		$this->_env->s_plr			= Pluralizer::plural($this->_env->s_sgl, 2);
		$this->_env->s_utype		= strtolower($a_tmp[2]);
		$this->_env->b_title		= isset($a_form_trans);


		if ($a_tmp[0] == 'Modules')
			$this->_env->s_view		= $this->_env->s_sgl . '::' . $this->_env->s_utype . '.';
		else
			$this->_env->s_view		= 'admin.' . $this->_env->s_sgl . '.';

		////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($this->_env->s_utype == 'controllers'
			&& in_array($this->_env->s_sgl, [
											'password',
											'profile',
											'signin',
											'signup',
											])
			)
		{
			$this->_env->s_utype	= 'guest';
			$this->_env->fn_find	= '';
			$this->_env->s_view		= ($o_settings->theme . '::' ?: '') . $this->_env->s_utype . '.' ;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////
/*
		////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($this->_env->s_utype == 'controllers'
			&& in_array($this->_env->s_sgl, [
											'point',
											])
			)
		{
			$this->_env->s_utype	= request()->segment(1) == 'admin' ? 'user' : 'guest';
#			$this->_env->fn_find	= '';
#			$this->_env->s_view		= ($settings->theme . '::' ?: '') . $this->_env->s_utype . '.' ;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////
*/
		$a_locales					= config('translatable.locales');
		$this->a_fields				= array_merge(config('translatable.locales'), $a_fill_main);

		$this->a_field				= [];
		$this->a_types				= [];
		$this->a_default			= [];
		$this->a_rule				= [];
		$this->a_tab				= [];#['All'];
#dd($a_fill_main, $a_form_main);
		foreach ($a_form_main AS $s_name => $a_params)
		{
			$s_tab					= $a_params['tab'];
			$s_field				= $a_params['field'];
			$s_rules				= $a_params['rules'];
			$this->a_tab[]			= $s_tab;
#			$this->a_field['all'][$s_name]	= $s_field;
			$this->a_field[$s_tab][$s_name]	= $s_field;
			$this->a_types[$s_field][]	= $s_name;
			$this->a_rule[$s_name]	= $s_rules;
			$this->a_default[$s_name]= ($a_params['default'] ?? '');
		}

		foreach ($a_form_trans AS $s_name => $a_params)
		{
			$s_tab					= $a_params['tab'];
			$s_field				= $a_params['field'];
			$s_rules				= $a_params['rules'];
			$this->a_tab[]			= $s_tab;
#			$this->a_field['all']['trans'][$s_name]		= $s_field;
			$this->a_field[$s_tab]['trans'][$s_name]	= $s_field;
			for ($i = 0; $i < count($a_locales); $i++)
			{
				$this->a_types[$s_field][]	= '[' . $a_locales[$i] . ']' . $s_name;
			}
			$this->a_rule[$s_name]	= $s_rules;
			$this->a_default[$s_name]= ($a_params['default'] ?? '');
		}

#		foreach ($a_form_main AS $s_name => $a_params) {
#			$this->a_rule[$s_name]	= $a_params['rules'];
#		}

if (class_exists($this->_env->s_model))
{

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


		for ($i = 0; $i < count($a_relations); $i++)
		{
			$s_meth_name			= $a_relations[$i];
			$a_fill_rel				= $m->$s_meth_name()->getRelated()->getFillable();
			$a_form_rel				= $m->$s_meth_name()->getRelated()->getFields();

			$this->a_rule[$s_meth_name] = 'required|array';
			for ($j = 0; $j < count($a_fill_rel); $j++)
			{
				if (array_key_exists($a_fill_rel[$j], $a_form_rel))
				{
					$s_tmp = $s_meth_name.'.*.'.$a_fill_rel[$j];
					$this->a_rule[$s_tmp] = $a_form_rel[$a_fill_rel[$j]]['rules'];
				}
			}
#dump($a_fill_rel, $a_form_rel);

		}

#dd($this->a_rule);




}

		$this->_env->a_field		= $this->a_field;
		$this->_env->a_types		= $this->a_types;
		$this->_env->a_default		= $this->a_default;
		$this->_env->a_rule			= $this->a_rule;
		$this->_env->a_tab			= array_values(array_unique($this->a_tab));
#dump($this->_env->a_field, $this->_env->a_rule);
		$user = Auth::user();
		$this->_env->b_admin		= (!is_null($user) ? $user->checkAdmin() : FALSE);

		$a_pages_list				= Page::getAllForView();
		$_env						= $this->_env;
		\View::composer('*', function ($view) use ($_env, $a_pages_list) {
			$view->with([
				'_env'				=> $this->_env,
				'a_pages'			=> $a_pages_list,
			]);
		});

	}
}
