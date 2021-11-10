<?php
namespace Modules\Text\API;

use               Modules\Complaint\Database\Complaint;
use                        Modules\Text\API\Text;
use                   Modules\Text\Database\Text as DBText;

use                    Modules\Text\Filters\TextFilters;

use                        App\Http\Requests\DeleteRequest;

use                     App\Http\Controllers\ControllerAPI as Controller;
use                        Modules\Text\Http\TextRequest;
use                          Illuminate\Http\Request;
use                         Modules\Text\API\SaveRequest;

class TextController extends Controller
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
	public function index(TextRequest $request, TextFilters $filters) : \Illuminate\Http\Response
	{
		return $this->indexAPI($request, $filters);
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
		$a_res = Text::changeOrder($request, $this->_env);
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
	public function update(SaveRequest $request, DBText $item) : \Illuminate\Http\Response
	{
		$o_res			= $this->updateAPI($request, $item);
		return $o_res;
	}
}
