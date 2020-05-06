<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerUser as Controller;
use App\Point;
use Illuminate\Http\Request;
use Modules\Issue\Database\Issue;

class DesignController extends Controller
{
public function form(Request $request) : \Illuminate\View\View
	{
		\View::composer('user.*', function ($view) {
			$view->with([
				'issue'			=> Issue::all()->sortBy('title'),
				'point'			=> Point::all()->sortBy('title'),
			]);
		});
		return parent::form($request);
	}
}
