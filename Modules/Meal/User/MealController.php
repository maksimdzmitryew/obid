<?php

namespace Modules\Meal\User;

#use Modules\Meal\Http\Controllers\MealController as Controller;
use                        App\Http\Controllers\ControllerUser as Controller;
use                     Modules\Course\Database\Course;
use                      Modules\Plate\Database\Plate;
use                             Illuminate\Http\Request;

class MealController extends Controller
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
				'course'			=> Course::all()->sortBy('title'),
				'plate'				=> Plate::all()->sortBy('title'),
			]);
		});
		return parent::form($request);
	}
}
