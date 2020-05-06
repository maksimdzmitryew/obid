<?php


#namespace App\Http\Controllers\API;
namespace Modules\Mark\API;

#use App\Mark;
use Modules\Mark\API\Mark;
use Modules\Mark\Database\Mark as DBMark;

#use App\Filters\MarkFilters;
use Modules\Mark\Filters\MarkFilters;

#use App\Http\Requests\MarkRequest;
#use Modules\Mark\Requests\MarkRequest;

use App\Http\Requests\DeleteRequest;

use App\Http\Controllers\ControllerAPI as Controller;

#use App\Http\Requests\MarkApiRequest;
use Modules\Mark\Http\MarkRequest;
use Modules\Mark\API\SaveRequest;

#use Modules\Mark\Http\Controllers\MarkController as Controller;

class MarkController extends Controller
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
#	public function index(MarkApiRequest $request, MarkFilters $filters) : \Illuminate\Http\Response
	public function index(MarkRequest $request, MarkFilters $filters) : \Illuminate\Http\Response
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
	public function update(SaveRequest $request, DBMark $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
