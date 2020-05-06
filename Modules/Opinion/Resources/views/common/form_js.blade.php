function checkRestoreInitialValue(a_results)
{
	// reset dependent dropdown on "parent" change
	// or keep the selection if one of dependent elements
	// has the value that was pre-selected or re-selected
	var i_selected_value = null;
	a_results.forEach((item) => {
		if (item.id == i_previous)
			i_selected_value = item.id;
	});
//	$("#element_id").val(i_selected_value).trigger('change');
}

function resetDependentDropdown(s_parent_id, s_child_id)
{
	$("#"+s_child_id).select2({
		placeholder: {
			id: '-1', // the value of the option
			title: $("#"+s_parent_id).data('placeholder')
//			text: $("#"+s_parent_id).data('placeholder')
		},
		data: {},
	});
}

function clearMarks(s_parent_id, s_child_id)
{
	$('#'+s_parent_id).find("."+s_child_id).remove();
}

function addMarks(s_parent_id, s_child_id, i_place_id, a_results, option_title, option_value)
{
	let opinion = $.tmpl($("#"+s_child_id).html(), {
		element_id:		a_results.id,
		id:				Math.random().toString(36).substring(2),
		place_id:		i_place_id,
//		title:			a_results.text,
		title:			a_results.title,
		option_title:	option_title,
		option_value:	option_value,
	}).appendTo("#"+s_parent_id);

	opinion.find('.opinions').addClass('select2-dropdown').select2(settings({
		url: '{!! route('api.mark.index') !!}',
		filter: 'title'
	}));
}


$(document).ready(function () {

	// reset dependent dropdown on page initialization
//	resetDependentDropdown("place_id", "element_id");

//    var $example = $("#place_id").select2();

    // re-define dropdown for places at this page
	$("#place_id, #place_id_off").select2(settings({
		url: s_route_unvoted_places.replace(':opinion_id', i_item_id),
		filter: 'title'
	}));

//    $example.select2("destroy");
/*
    $(document).on('click', '#place_id', function (e) {
        console.log('ok');
	});
*/

	$('#place_id, #place_id_off').change( function() {
		$(this).find(":selected").each(function () {
			var i_place_id = $(this).val();

			if ($("#element_id").val() != null)
				i_previous = $("#element_id").val();

			// TODO
			// this is a very specific case for opinion
			// it's not related to dependent dropdowns and should be called separately somehow
			clearMarks("div_select_place_id div.field-body", "div_mark_wrapper");

			// check dependent dropdown new values
			// if there is dependent selected value already
			// then keep it selected otherwise clear dependent selection
			// also notify about errors
			$.ajax({
				'type': 'get',
				'data': {},
				'url': s_route.replace(':place_id', i_place_id),
				success: (data, status, xhr) => {
					if (xhr.readyState == 4 && xhr.status == 200)
						try {
							// Do JSON handling here
							tmp = JSON.parse(xhr.responseText);
//							checkRestoreInitialValue(tmp.results);

							// TODO
							// this is a very specific case for opinion
							// it's not related to dependent dropdowns and should be called separately somehow
//console.log(tmp.results);
							for (i = 0; i < tmp.results.length; i++)
							{
								addMarks(
										"div_select_place_id .div_control",
										"div_tmpl_opinion",
										i_place_id,
										tmp.results[i],
										'{!! trans('crud.hint.select') !!} {!! trans($name.'::crud.names.sgl') !!}',
										0,
										);
							}

						} catch(e) {
							//JSON parse error, this is not json (or JSON isn't in the browser)
							notify(s_servererror_info, 'danger', 3000);
						}
					else
						notify(s_servererror_info, 'danger', 3000);
				},
				'error': (xhr) => {
					// this is the case when no dependent information is set via admin panel
					// so the route will return 404 error
					if (!(xhr.readyState == 4 && xhr.status == 404))
						notify(s_servererror_info, 'danger', 3000);
//					resetDependentDropdown("place_id", "element_id");
				}
			});
/*
			$("#element_id").select2({
				ajax: {
					url: s_route.replace(':place_id', i_place_id),
					dataType: 'json',
					data: function (params) {
						var query = {
						search: params.term,
//						point: i_place_id,
						}
						// Query parameters will be ?search=[term]&point=[id]
						return query;
					},
				},
			});
*/
		});
	});

});

