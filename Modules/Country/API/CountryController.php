<?php
namespace Modules\Country\API;

use               Modules\Complaint\Database\Complaint;
use                        Modules\Country\API\Country;
use                   Modules\Country\Database\Country as DBCountry;

use                    Modules\Country\Filters\CountryFilters;

use                        App\Http\Requests\DeleteRequest;

use                     App\Http\Controllers\ControllerAPI as Controller;
use                        Modules\Country\Http\CountryRequest;
use                          Illuminate\Http\Request;
use                         Modules\Country\API\SaveRequest;

class CountryController extends Controller
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
	public function index(CountryRequest $request, CountryFilters $filters) : \Illuminate\Http\Response
	{
		return $this->indexAPI($request, $filters, ['user']);
	}

	/**
	 * Prepare data for listing all of items
	 * @param Request	$request		Data from request
	 * @param Filters	$filters		Whatever filters applied
	 *
	 * @return Response	json instance of
	 */
	public function order(Request $request) : \Illuminate\Http\Response
	{
		$this->setEnv();
		$a_res = Country::changeOrder($request, $this->_env);
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
		$o_res = $this->storeAPI($request);
		return $o_res;
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(SaveRequest $request, DBCountry $item) : \Illuminate\Http\Response
	{
		$o_res			= $this->updateAPI($request, $item);
		return $o_res;
	}
}
