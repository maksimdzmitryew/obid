<?php

namespace App\Http\Controllers\API;

use App\Design;
use App\Filters\DesignFilters;
use App\Http\Requests\DesignRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\ControllerAPI as Controller;
use App\Http\Requests\DesignApiRequest;

class DesignController extends Controller
{
/*
	public function __construct()
	{
#		dump($this->translatedAttributes);
#		$t = new DesignTranslation;
#		$this->translatedAttributes = $m->getFillable();
		$m = new Design;
		$this->a_fields = array_merge(config('translatable.locales'), $m->getFillable());
	}
*/
	/**
	 * Prepare data for listing all of items
	 * @param Request	$request		Data from request
	 * @param Filters	$filters		Whatever filters applied
	 *
	 * @return Response	json instance of
	 */
	public function index(DesignApiRequest $request, DesignFilters $filters) : \Illuminate\Http\Response
	{
		return $this->indexAPI($request, $filters);
	}

	/**
	 * Create a new item
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function store(DesignRequest $request) : \Illuminate\Http\Response
	{
		return $this->storeAPI($request);
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(DesignRequest $request, Design $item) : \Illuminate\Http\Response
	{
		return $this->updateAPI($request, $item);
	}

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
}