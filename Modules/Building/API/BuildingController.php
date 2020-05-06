<?php


#namespace App\Http\Controllers\API;
namespace Modules\Building\API;

#use App\Building;
use Modules\Building\API\Building;
use Modules\Building\Database\Building as DBBuilding;

#use App\Filters\BuildingFilters;
use Modules\Building\Filters\BuildingFilters;

#use App\Http\Requests\BuildingRequest;
#use Modules\Building\Requests\BuildingRequest;

use App\Http\Requests\DeleteRequest;

use App\Http\Controllers\ControllerAPI as Controller;

#use App\Http\Requests\BuildingApiRequest;
use Modules\Building\Http\BuildingRequest;
use Modules\Building\API\SaveRequest;

#use Modules\Building\Http\Controllers\BuildingController as Controller;

class BuildingController extends Controller
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
#	public function index(BuildingApiRequest $request, BuildingFilters $filters) : \Illuminate\Http\Response
	public function index(BuildingRequest $request, BuildingFilters $filters) : \Illuminate\Http\Response
	{
		return $this->indexAPI($request, $filters);
	}

	/**
	 * Create a new item
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function store(SaveRequest $request) : \Illuminate\Http\Response
	{
		$a_res = $this->storeAPI($request);
		return $a_res;
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(SaveRequest $request, DBBuilding $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
