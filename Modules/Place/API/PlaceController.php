<?php


#namespace App\Http\Controllers\API;
namespace Modules\Place\API;

#use App\Place;
use               Modules\Complaint\Database\Complaint;
use                        Modules\Place\API\Place;
use                   Modules\Place\Database\Place as DBPlace;

#use App\Filters\PlaceFilters;
use                    Modules\Place\Filters\PlaceFilters;

#use App\Http\Requests\PlaceRequest;
#use Modules\Place\Requests\PlaceRequest;

use                        App\Http\Requests\DeleteRequest;

use                     App\Http\Controllers\ControllerAPI as Controller;
#use App\Http\Requests\PlaceApiRequest;
use                       Modules\Place\Http\PlaceRequest;
use                        Modules\Place\API\SaveRequest;

#use Modules\Place\Http\Controllers\PlaceController as Controller;

class PlaceController extends Controller
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
#	public function index(PlaceApiRequest $request, PlaceFilters $filters) : \Illuminate\Http\Response
	public function index(PlaceRequest $request, PlaceFilters $filters) : \Illuminate\Http\Response
	{
		Place::calculateRating();
		return $this->indexAPI($request, $filters, ['user']);
	}

	/**
	 * Create a new item
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function store(SaveRequest $request) : \Illuminate\Http\Response
	{
		$request->merge([
			'user_id' => \Auth::user()->id,
		]);
		$a_res = $this->storeAPI($request);
		return $a_res;
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(SaveRequest $request, DBPlace $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
