{{--
1)
bootstrap makes table TH row bg-color: black
this style makes it white, maybe should try another theme

2)
also had to hide items with .ui-tooltip in override.css

@section('css')
<link href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
@append
--}}
@section('js')
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
{{--
	need the jquery .ui-tooltip to be overriden by bootstrap css
	otherwise the tooltip is shown out of place
--}}
<script src="{!! asset('/admin/js/main/bootstrap.bundle.min.js') !!}"></script>
@append

@section('script')
	<script type="text/javascript">
		a_order = [[ 6, "desc" ]];

		$('tbody').sortable(
			{
				placeholder : "ui-state-highlight",
				update  : function(event, ui)
				{
					var {!! $_env->s_sgl !!}_ids = new Array();
					$('tr').each(function(){
					// table TH row
					if (typeof $(this).attr("data-id") != 'undefined')
					{
						{!! $_env->s_sgl !!}_ids.push($(this).attr("data-id"));
					}
					});

					$.ajax({
						type: 'post',
						url: "{!! route('api.' . $_env->s_sgl . '.order') !!}",
						data: {
							'order': {!! $_env->s_sgl !!}_ids
						},
						success: function (data, status, xhr){
							s_status = 'danger';
							if (xhr.status === 200) {
								s_status = 'success';
								// this is optional
								// as datatable will update rows nicely
								// although having it bring such benefits as
								// 1) proper rows selection when holding "shift" button otherwise datatable "remembers" the rows order when table was filled at page open and selecting consecutive rows looks a bit cont-intuitive
								// 2) visual confirmation the order of the rows has changed
								$('#btn-filter').trigger('click');
							}
							notify(data.message, s_status, 2000);
						},
						error: function (data){}
					})
				}
			}
		);
	</script>
@append
@php
$a_columns = [
				'user_name' => 'name',
				'order'	=> 'id',
			];
$a_buttons = [
			];
$a_filters = [
				'page_id' => 'select',
			];
@endphp
@extends('user.list')
