let s_route = '{!! route('api.opinion.place', ':place_id') !!}'
	,s_route_unvoted_places = '{!! route('api.opinion.unvoted', ':opinion_id') !!}'
	,i_item_id = {!! request()->id ? request()->id : 0 !!}
	,i_previous = null;
