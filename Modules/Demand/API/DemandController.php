<?php


#namespace App\Http\Controllers\API;
namespace Modules\Demand\API;

#use App\Demand;
use                Modules\Complaint\Database\Complaint;
use                        Modules\Demand\API\Demand;
use                   Modules\Demand\Database\Demand as DBDemand;

#use App\Filters\DemandFilters;
use                    Modules\Demand\Filters\DemandFilters;

#use App\Http\Requests\DemandRequest;
#use Modules\Demand\Requests\DemandRequest;

use                         App\Http\Requests\DeleteRequest;

use                      App\Http\Controllers\ControllerAPI as Controller;
#use App\Http\Requests\DemandApiRequest;
use                       Modules\Demand\Http\DemandRequest;
use                        Modules\Demand\API\SaveRequest;

#use Modules\Demand\Http\Controllers\DemandController as Controller;

class DemandController extends Controller
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
#	public function index(DemandApiRequest $request, DemandFilters $filters) : \Illuminate\Http\Response
	public function index(DemandRequest $request, DemandFilters $filters) : \Illuminate\Http\Response
	{
		$a_res = $this->indexAPI($request, $filters, ['plate', 'meal', 'meal.course', 'meal.course.provider', ]);
		return $a_res;
	}

	/**
	 * Create a new item
	 * @param	Request	$request			Data from request
	 *
	 * @return	Array								only selected ids
	 */
	private function _prepareSync(SaveRequest $request) : Array
	{
		$a_tmp		= array_flip($request->plate_ids);
		unset($a_tmp['']);
		$a_tmp		= array_keys($a_tmp);
		return $a_tmp;
	}

	/**
	 * Create a new item
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function store(SaveRequest $request) : \Illuminate\Http\Response
	{
		$a_ids		= $this->_prepareSync($request);
		$a_res		= $this->storeAPI($request);
		$this->o_item->plate()->sync($a_ids);

		return $a_res;
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(SaveRequest $request, DBDemand $item) : \Illuminate\Http\Response
	{
		$a_ids		= $this->_prepareSync($request);
		$item->plate()->sync($a_ids);
		$a_res		= $this->updateAPI($request, $item);
		return $a_res;
	}
}
