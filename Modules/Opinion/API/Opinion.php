<?php

namespace Modules\Opinion\API;

use                 Modules\Opinion\Database\Opinion as Model;
use                     Modules\Building\API\Building;
use                      Modules\Element\API\Element;
use                        Modules\Place\API\Place;
use                    Modules\Place\Filters\PlaceFilters;
use                          Illuminate\Http\Request;
use                        Modules\Style\API\Style;

class Opinion extends Model
{
	public $translationModel = '\Modules\Opinion\Database\OpinionTranslation';

	/**
	 * Create/modify opinion http://pr.max/admin/opinion/form
	 * API URL http://pr.max/api/opinion/place/32
	 * Select Place from dropdown
	 * Provides with list of Elements specific to selected Place
	 * the Elements are then dynamically shown via tmpl
	 * so it is possible to evaluate them and select specific Mark for each Element
	 * @param Request	$request		Data from request
	 * @param Integer	$id				point id
	 *
	 * @return Response	json instance of data for select2 expected format
	 */
	#  -> select a palce from dropdown

	public static function getSpecificLists($request, $pid) : String
	{
		$i_building_id			= Place::findOrFail($pid)->building_id;
		$i_style_id				= Building::findOrFail($i_building_id)->style_id;
		$a_element_ids			= Style::findOrFail($i_style_id)->element()->get()->pluck('id')->toArray();

		$a_items				= self::getIdTitle($request, NULL, 'Element', NULL, $a_element_ids, [], TRUE, FALSE);#, TRUE);

/*
		$a_items				= Element::whereIn('id', $a_element_ids);
#		$a_issue_ids = Design::findOrFail($i_design_id)->issue()->get()->pluck('id')->toArray();
#		$a_issues = Issue::whereIn('id', $a_issue_ids);

		if (!is_null($request->search))
			 $a_items = $a_items->whereTranslationLike('title', '%' . $request->search .'%', app()->getLocale());

		$a_items = $a_items->get()->map( function($o_element) {
			return ['id'=> $o_element->id, 'title' => $o_element->title];
		});
#dd($request, $id, $i_building_id, $i_style_id, $a_element_ids, $a_items);
*/
		return json_encode(['results' => $a_items]);
	}


	/**
	 * Create/modify opinion http://pr.max/admin/opinion/form
	 * API URL http://pr.max/api/opinion/13/unvoted
	 * Click Place Dropdown
	 * A list of Places is shown
	 * List will be filled with Places that current user never voted for
	 * List will include the Place that is already associated with editing existing Opinion
	 *
	 * @param Request	$request		Data from request
	 * @param Filters	$filters		Whatever filters applied
	 *
	 * @return Response	json instance of data for select2 expected format
	 */
	public static function getUnvotedPlaces(Request $request, PlaceFilters $filters) : String
	{
		$a_voted				= Opinion::select('place_id')
									# keep place for current opinion
									->where('id', '<>', $request->id)
									# exclude places where already voted
									->whereUserId(\Auth::user()->id)
									->get()
									->pluck('place_id')
									->toArray()
									;

		$a_items				= self::getIdTitle($request, $filters, 'Place', NULL, [], $a_voted, TRUE, FALSE);#, FALSE);

		return json_encode(['data' => $a_items]);
	}


}
