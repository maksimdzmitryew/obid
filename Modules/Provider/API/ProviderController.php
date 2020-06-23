<?php


#namespace App\Http\Controllers\API;
namespace Modules\Provider\API;

#use App\Provider;
use               Modules\Complaint\Database\Complaint;
use                        Modules\Provider\API\Provider;
use                   Modules\Provider\Database\Provider as DBProvider;

#use App\Filters\ProviderFilters;
use                    Modules\Provider\Filters\ProviderFilters;

#use App\Http\Requests\ProviderRequest;
#use Modules\Provider\Requests\ProviderRequest;

use                        App\Http\Requests\DeleteRequest;

use                     App\Http\Controllers\ControllerAPI as Controller;
#use App\Http\Requests\ProviderApiRequest;
use                       Modules\Provider\Http\ProviderRequest;
use                        Modules\Provider\API\SaveRequest;

#use Modules\Provider\Http\Controllers\ProviderController as Controller;

class ProviderController extends Controller
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
#	public function index(ProviderApiRequest $request, ProviderFilters $filters) : \Illuminate\Http\Response
	public function index(ProviderRequest $request, ProviderFilters $filters) : \Illuminate\Http\Response
	{
		$a_res = $this->indexAPI($request, $filters);
		return $a_res;
	}


	/**
	 * Parse provider’s web-page for updates in menu
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function parse()
	{
		die('ok');
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
	public function update(SaveRequest $request, DBProvider $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
