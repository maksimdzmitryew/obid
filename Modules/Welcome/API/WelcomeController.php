<?php

namespace Modules\Welcome\API;

use App\Http\Controllers\ControllerAPI as Controller;
use Modules\Welcome\Filters\WelcomeFilters;

class WelcomeController extends Controller
{

	/**
	 * Prepare data for listing all of items
	 * @param Request	$request		Data from request
	 * @param Filters	$filters		Whatever filters applied
	 *
	 * @return Response	json instance of
	 */
	public function index(WelcomeRequest $request, WelcomeFilters $filters) : \Illuminate\Http\Response
	{
		return $this->indexAPI($request, $filters);
	}

}
