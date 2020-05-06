<?php

namespace Modules\Personal\API;

use App\Http\Controllers\ControllerAPI as Controller;
use Modules\Personal\Filters\PersonalFilters;

class PersonalController extends Controller
{

	/**
	 * Prepare data for listing all of items
	 * @param Request	$request		Data from request
	 * @param Filters	$filters		Whatever filters applied
	 *
	 * @return Response	json instance of
	 */
	public function index(PersonalRequest $request, PersonalFilters $filters) : \Illuminate\Http\Response
	{
		return $this->indexAPI($request, $filters);
	}

}
