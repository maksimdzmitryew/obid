<?php

namespace Modules\Country\Guest;

#use                                          Auth;
use                     App\Http\Controllers\ControllerGuest as Controller;
use                       Modules\Country\Guest\Country;
use                          Illuminate\Http\Request;


class CountryController extends Controller
{
	public function __construct()
	{
		$this->setEnv();
		$a_items	= $this->_env->s_model::select('id', 'slug')->wherePublished(TRUE)->get()->sortBy('id')->pluck('title', 'slug')->toArray();
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

		$o_country		= Country::getItem($request, $this->_env, 'home');

		return view('welcome::guest.index', [
				'country'					=> $o_country,
				'attachments'		=> $o_country->atts,
		]);
	}

	public function posibnyk(Request $request){

		$this->setEnv();
#		$o_countrys					= Country::select('id', 'slug')->wherePublished(TRUE)->get();

		$o_country		= Country::getItem($request, $this->_env, $request->country_slug, TRUE);

		return view(
			$this->_env->s_theme . '::' . $this->_env->s_utype . '.posibnyk',
			[
				'country_slug'			=> $request->country_slug,
				$this->_env->s_sgl	=> $o_country,
				'attachments'		=> $o_country->atts,
			]
		);
	}

}
