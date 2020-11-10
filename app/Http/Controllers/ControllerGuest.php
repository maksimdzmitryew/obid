<?php

namespace App\Http\Controllers;

use                          Illuminate\Http\Request;
use                     App\Http\Controllers\Controller as BaseController;

class ControllerGuest	extends BaseController
{
	/**
	 * Open list of items for unauthenticated (aka "Frontend" previously and now "Guest")
	 * @param Request	$request		Data from request
	 *
	 * @return View		instance of
	 */
	public function index(Request $request) #: \Illuminate\View\View
	{
		$this->setEnv();

		return view($this->_env->s_view . 'index', [
#			$this->_env->s_sgl => $this->_env->s_model::all()->sortByDesc('created_at'),
		]);
	}
}
