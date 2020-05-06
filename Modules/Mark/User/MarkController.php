<?php

namespace Modules\Mark\User;

#use Modules\Mark\Http\Controllers\MarkController as Controller;
use App\Http\Controllers\ControllerUser as Controller;
use Modules\Element\Database\Element;
use Illuminate\Http\Request;

class MarkController extends Controller
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
				'element'		=> Element::all()->sortBy('name'),
			]);
		});
		return parent::form($request);
	}
}
