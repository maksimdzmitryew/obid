<?php


#namespace App\Http\Controllers\API;
namespace Modules\Plate\API;

#use App\Plate;
use               Modules\Complaint\Database\Complaint;
use                        Modules\Plate\API\Plate;
use                   Modules\Plate\Database\Plate as DBPlate;

#use App\Filters\PlateFilters;
use                    Modules\Plate\Filters\PlateFilters;

#use App\Http\Requests\PlateRequest;
#use Modules\Plate\Requests\PlateRequest;

use                        App\Http\Requests\DeleteRequest;

use                     App\Http\Controllers\ControllerAPI as Controller;
#use App\Http\Requests\PlateApiRequest;
use                       Modules\Plate\Http\PlateRequest;
use                        Modules\Plate\API\SaveRequest;

#use Modules\Plate\Http\Controllers\PlateController as Controller;

class PlateController extends Controller
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
#	public function index(PlateApiRequest $request, PlateFilters $filters) : \Illuminate\Http\Response
	public function index(PlateRequest $request, PlateFilters $filters) : \Illuminate\Http\Response
	{
		$a_res = $this->indexAPI($request, $filters, ['meal',]);
		return $a_res;
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
	public function update(SaveRequest $request, DBPlate $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
