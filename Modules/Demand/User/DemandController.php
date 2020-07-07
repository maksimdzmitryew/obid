<?php

namespace Modules\Demand\User;

#use Modules\Demand\Http\Controllers\DemandController as Controller;
use App\Http\Controllers\ControllerUser as Controller;
use Modules\Building\Database\Building;
use Illuminate\Http\Request;

class DemandController extends Controller
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
				'building'		=> Building::all()->sortBy('title'),
			]);
		});
		return parent::form($request);
	}
}