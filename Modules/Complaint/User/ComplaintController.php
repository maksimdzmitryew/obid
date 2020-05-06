<?php

namespace Modules\Complaint\User;

#use Modules\Complaint\Http\Controllers\ComplaintController as Controller;
use                     App\Http\Controllers\ControllerUser as Controller;
use                   Modules\Place\Database\Place;
use                          Illuminate\Http\Request;

class ComplaintController extends Controller
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
				'place'		=> Place::all()->sortBy('title'),
			]);
		});
		return parent::form($request);
	}
}
