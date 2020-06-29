<?php


#namespace App\Http\Controllers\API;
namespace Modules\Course\API;

#use App\Course;
use               Modules\Complaint\Database\Complaint;
use                        Modules\Course\API\Course;
use                   Modules\Course\Database\Course as DBCourse;

#use App\Filters\CourseFilters;
use                    Modules\Course\Filters\CourseFilters;

#use App\Http\Requests\CourseRequest;
#use Modules\Course\Requests\CourseRequest;

use                        App\Http\Requests\DeleteRequest;

use                     App\Http\Controllers\ControllerAPI as Controller;
#use App\Http\Requests\CourseApiRequest;
use                       Modules\Course\Http\CourseRequest;
use                        Modules\Course\API\SaveRequest;

#use Modules\Course\Http\Controllers\CourseController as Controller;

class CourseController extends Controller
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
#	public function index(CourseApiRequest $request, CourseFilters $filters) : \Illuminate\Http\Response
	public function index(CourseRequest $request, CourseFilters $filters) : \Illuminate\Http\Response
	{
		$a_res = $this->indexAPI($request, $filters, ['meal', 'plate', 'provider', ]);
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
		$a_res = $this->storeAPI($request);
		return $a_res;
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(SaveRequest $request, DBCourse $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
