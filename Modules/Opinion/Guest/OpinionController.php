<?php

namespace Modules\Opinion\Guest;

use                                          Auth;
use                     App\Http\Controllers\ControllerGuest as Controller;
use                                      App\Model;
use                 Modules\Opinion\Database\Opinion;
use                   Modules\Place\Database\Place;
use                          Illuminate\Http\Request;




#use                     Modules\Building\API\Building;
#use                        Modules\Style\API\Style;

class OpinionController extends Controller
{
	/**
	 * Open CRUD form to authenticated user (aka "User" previously and now "Guest")
	 * for creating/editing the specified resource.
	 * @param Request	$request		Data from request
	 *
	 * @return View		instance of
	 */
	public function form(Request $request)
	{
		$o_item = Opinion::findOrNew($request->id);
		if ($request->type == 'place' && !is_null($request->tid))
		{
			$o_tmp				= Place::findOrFail($request->tid);
			$o_item->place_id	= $o_tmp->id;
			$o_item->readonly	= ['place_id'];
		}
		$this->setEnv();

		$user = Auth::user();

		return
			view($this->_env->s_view . 'form',
			[
				'b_admin'		=> $user->checkAdmin(),
				'opinion'		=> $o_item,
#				'element'		=> Model::getIdTitle($request, NULL, 'Element', NULL, [], [], TRUE, TRUE),#, FALSE),
#				'mark'			=> Model::getIdTitle($request, NULL, 'Mark', NULL, [], [], TRUE, TRUE),#, FALSE),
				'place'			=> Place::all()->sortBy('title'),
				'user'			=> $user,
			]);
	}
}
