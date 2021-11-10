<?php

namespace Modules\Text\Guest;

#use                                          Auth;
use                     App\Http\Controllers\ControllerGuest as Controller;
use                       Modules\Text\Guest\Text;
use                          Illuminate\Http\Request;


class TextController extends Controller
{
	public function __construct()
	{
		$this->setEnv();
		$a_items	= $this->_env->s_model::select('id', 'slug')->wherePublished(TRUE)->get()->sortBy('id')->pluck('value', 'slug')->toArray();
#dd($a_items);
		\View::composer($this->_env->s_theme . '::' . $this->_env->s_utype . '.*', function ($view) use ($a_items) {
			$view->with([
				$this->_env->s_plr => $a_items,
			]);
		});
	}

	/**
	 *	this is override to App\Http\Controllers\ControllerGuest::index
	 *	which is used by "ordinary" Welcome route
	 */
	public function index(Request $request) : \Illuminate\View\View
	{
		$this->setEnv();

		$o_text		= Text::getItem($request, $this->_env, 'home');

		return view('welcome::guest.index', [
				'text'					=> $o_text,
		]);
	}

}
