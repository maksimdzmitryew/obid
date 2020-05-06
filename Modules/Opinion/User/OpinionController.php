<?php

namespace Modules\Opinion\User;

#use Modules\Opinion\Http\Controllers\OpinionController as Controller;
use                     App\Http\Controllers\ControllerUser as Controller;
#use                 Modules\Element\Database\Element;
#use                    Modules\Mark\Database\Mark;
use                                      App\Model;
use                   Modules\Place\Database\Place;
use                          Illuminate\Http\Request;

class OpinionController extends Controller
{
	/**
	 * Open CRUD form for authenticated user (aka "Admin" previously and now "User")
	 * @param Request	$request		Data from request
	 *
	 * @return View		instance of
	 */
	public function form(Request $request) : \Illuminate\View\View
	{
		\View::composer('opinion::user.*', function ($view) use ($request) {
			$view->with([
				'element'		=> Model::getIdTitle($request, NULL, 'Element', NULL, [], [], TRUE, TRUE),#, FALSE),
				'mark'			=> Model::getIdTitle($request, NULL, 'Mark', NULL, [], [], TRUE, TRUE),#, FALSE),
				'place'			=> Place::all()->sortBy('title'),
			]);
		});

		return parent::form($request);
	}
}
