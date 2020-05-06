<?php

namespace Modules\Style\User;

#use Modules\Style\Http\Controllers\StyleController as Controller;
use            Modules\Building\Database\Building;
use                 App\Http\Controllers\ControllerUser as Controller;
use             Modules\Element\Database\Element;
use                      Illuminate\Http\Request;

class StyleController extends Controller
{
	/**
	 * Open CRUD form for authenticated user (aka "Admin" previously and now "User")
	 * @param Request	$request		Data from request
	 *
	 * @return View		instance of
	 */
	public function form(Request $request) : \Illuminate\View\View
	{
		\View::composer('user.*', function ($view) {
			$view->with([
				'building'		=> Building::all()->sortBy('name'),
				'element'		=> Element::all()->sortBy('name'),
			]);
		});
		return parent::form($request);
	}
}
