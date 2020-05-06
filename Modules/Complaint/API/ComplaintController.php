<?php


#namespace App\Http\Controllers\API;
namespace Modules\Complaint\API;

#use App\Complaint;
use                        Modules\Complaint\API\Complaint;
use                   Modules\Complaint\Database\Complaint as DBComplaint;

#use App\Filters\ComplaintFilters;
use                    Modules\Complaint\Filters\ComplaintFilters;

#use App\Http\Requests\ComplaintRequest;
#use Modules\Complaint\Requests\ComplaintRequest;

use                        App\Http\Requests\DeleteRequest;

use                     App\Http\Controllers\ControllerAPI as Controller;
use               Illuminate\Support\Facades\Mail;
use                   \Modules\Mark\Database\Mark;
use                \Modules\Element\Database\Element;
#use App\Http\Requests\ComplaintApiRequest;
use                       Modules\Complaint\Http\ComplaintRequest;
use                        Modules\Complaint\API\SaveRequest;

#use Modules\Complaint\Http\Controllers\ComplaintController as Controller;

class ComplaintController extends Controller
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
	public function index(ComplaintRequest $request, ComplaintFilters $filters) : \Illuminate\Http\Response
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
		return $a_res;
	}

	/**
	 * Updated item that is being edited
	 * @param Request	$request		Data from request
	 *
	 * @return Response	json instance of
	 */
	public function update(SaveRequest $request, DBComplaint $item) : \Illuminate\Http\Response
	{
		$a_res = $this->updateAPI($request, $item);
		return $a_res;
	}
}
