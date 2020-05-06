<?php

namespace Modules\Report\API;

use Modules\Report\API\Report;
use Modules\Report\Database\Report as DBReport;
use Modules\Report\Filters\ReportFilters;
use App\Http\Controllers\ControllerAPI as Controller;
use App\Http\Requests\DeleteRequest;
use Modules\Report\API\SaveRequest;
use Modules\Report\Http\ReportRequest;

class ReportController extends Controller
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
	public function index(ReportRequest $request, ReportFilters $filters) : \Illuminate\Http\Response
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
		$request->merge([
			'user_id' => \Auth::user()->id,
		]);
		$a_res = $this->storeAPI($request);
		$this->o_item->processImages($request);
		return $a_res;
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(SaveRequest $request, DBReport $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		$item->processImages($request);
		return $a_res;
	}

}
