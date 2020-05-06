@extends('user.form')

@section('script')
<script type="text/javascript">
let s_route = '{!! route('api.point.issue', ':point_id') !!}'
	,i_previous = null;

function checkRestoreInitialValue(a_results)
{
	// reset dependent dropdown on "parent" change
	// or keep the selection if on of dependent elements
	// has the value that was pre-selected or re-selected
	var i_selected_value = null;
	a_results.forEach((item) => {
		if (item.id == i_previous)
			i_selected_value = item.id;
	});
	$("#issue_id").val(i_selected_value).trigger('change');
}

$(document).ready(function () {
	// reset dependent dropdown on page initialization
	$("#issue_id").select2({
		placeholder: {
			id: '-1', // the value of the option
			text: $('#point_id').data('placeholder')
		},
		data: {},
	});

	$('#point_id').change( function() {
		$(this).find(":selected").each(function () {
			var i_point_id = $(this).val();

			if ($("#issue_id").val() != null)
				i_previous = $("#issue_id").val();

			// TODO: refactor and make a common component

			// check dependent dropdown new values
			// if there is dependent selected value already
			// then keep it selected otherwise clear dependent selection
			// also notify about errors
			$.ajax({
				'type': 'get',
				'url': s_route.replace(':point_id', i_point_id),
				'data': {},
				success: (data, status, xhr) => {
					if (xhr.readyState == 4 && xhr.status == 200)
						try {
							// Do JSON handling here
							tmp = JSON.parse(xhr.responseText);
							checkRestoreInitialValue(tmp.results);

						} catch(e) {
							//JSON parse error, this is not json (or JSON isn't in the browser)
							notify(s_servererror_info, 'danger', 3000);
						}
					else
						notify(s_servererror_info, 'danger', 3000);
				},
				'error': (xhr) => {
					notify(s_servererror_info, 'danger', 3000);
				}
			});

			$("#issue_id").select2({
				ajax: {
					url: s_route.replace(':point_id', i_point_id),
					dataType: 'json',
					data: function (params) {
						var query = {
						search: params.term,
//						point: i_point_id,
						}
						// Query parameters will be ?search=[term]&point=[id]
						return query;
					},
				},
			});

		});
	});

});

</script>
@append

