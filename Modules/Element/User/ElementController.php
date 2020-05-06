<?php

namespace Modules\Element\User;

#use Modules\Element\Http\Controllers\ElementController as Controller;
use App\Http\Controllers\ControllerUser as Controller;
use Modules\Style\Database\Style;
#use Modules\Element\Database\Element;
use Illuminate\Http\Request;

class ElementController extends Controller
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
				'style'		=> Style::all()->sortBy('name'),
			]);
		});
		return parent::form($request);
	}
}
