<?php


#namespace App\Http\Controllers\API;
namespace Modules\Element\API;

#use App\Element;
use Modules\Element\API\Element;
use Modules\Element\Database\Element as DBElement;

#use App\Filters\ElementFilters;
use Modules\Element\Filters\ElementFilters;

#use App\Http\Requests\ElementRequest;
#use Modules\Element\Requests\ElementRequest;

use App\Http\Requests\DeleteRequest;

use App\Http\Controllers\ControllerAPI as Controller;

#use App\Http\Requests\ElementApiRequest;
use Modules\Element\Http\ElementRequest;
use Modules\Element\API\SaveRequest;

#use Modules\Element\Http\Controllers\ElementController as Controller;

class ElementController extends Controller
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
#	public function index(ElementApiRequest $request, ElementFilters $filters) : \Illuminate\Http\Response
	public function index(ElementRequest $request, ElementFilters $filters) : \Illuminate\Http\Response
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
		$this->o_item->style()->sync($request->style_ids);
		return $a_res;
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(SaveRequest $request, DBElement $item) : \Illuminate\Http\Response
	{
		$item->style()->sync($request->style_ids);
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
