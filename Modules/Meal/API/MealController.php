<?php


#namespace App\Http\Controllers\API;
namespace Modules\Meal\API;

#use App\Meal;
use               Modules\Complaint\Database\Complaint;
use                        Modules\Meal\API\Meal;
use                   Modules\Meal\Database\Meal as DBMeal;

#use App\Filters\MealFilters;
use                    Modules\Meal\Filters\MealFilters;

#use App\Http\Requests\MealRequest;
#use Modules\Meal\Requests\MealRequest;

use                        App\Http\Requests\DeleteRequest;

use                     App\Http\Controllers\ControllerAPI as Controller;
#use App\Http\Requests\MealApiRequest;
use                       Modules\Meal\Http\MealRequest;
use                        Modules\Meal\API\SaveRequest;

#use Modules\Meal\Http\Controllers\MealController as Controller;

class MealController extends Controller
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
#	public function index(MealApiRequest $request, MealFilters $filters) : \Illuminate\Http\Response
	public function index(MealRequest $request, MealFilters $filters) : \Illuminate\Http\Response
	{
		$a_res = $this->indexAPI($request, $filters, ['user']);
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
	public function update(SaveRequest $request, DBMeal $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
