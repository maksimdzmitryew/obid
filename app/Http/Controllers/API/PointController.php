<?php

namespace App\Http\Controllers\API;

use App\Point;
use Illuminate\Http\Request;
use App\Filters\PointFilters;
use App\Http\Requests\PointRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\ControllerAPI as Controller;
use App\Http\Requests\PointApiRequest;
use Modules\Issue\Database\Issue;

class PointController extends Controller
{
	/**
	 * Deleted selected item(s)
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function destroy(DeleteRequest $request) : \Illuminate\Http\Response
	{
		return $this->destroyAPI($request);
	}

	/**
	 * Prepare data for listing all of items
	 * @param Request	$request		Data from request
	 * @param Filters	$filters		Whatever filters applied
	 *
	 * @return Response	json instance of
	 */
	public function index(PointApiRequest $request, PointFilters $filters) : \Illuminate\Http\Response
	{
		return $this->indexAPI($request, $filters);
	}

	/**
	 * Get list of issues specific to this point
	 * @param Integer	$id				point id
	 *
	 * @return Response	json instance of
	 */
	protected function issue(Request $request, $id) : String
	{
		return Point::getSpecificIssues($request, $id);
	}

	/**
	 * Create a new item
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function store(PointRequest $request) : \Illuminate\Http\Response
	{
		$request->merge([
			'user_id' => \Auth::user()->id,
		]);
		return $this->storeAPI($request);
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(PointRequest $request, Point $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}


}