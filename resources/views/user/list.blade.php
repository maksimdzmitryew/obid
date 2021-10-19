@extends('layouts.admin')

@php
include(base_path().'/resources/views/user/crud.php');
@endphp

@section('title-icon')<i class="{!! trans('user/' . $s_category . '.names.ico') !!} mr-2"></i>@endsection

@section('title'){!! $s_title !!}@endsection

@section('breadcrumbs')
	<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
		<div class="d-flex">
			<div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
				<span class="breadcrumb-item active">{!! $s_title !!}</span>
			</div>
			<a href="{!! $s_list_route !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ mix('/admin/css/list/list.css') }}">
@endsection

@section('js')
	<script src="{{ asset('/admin/js/plugins/sliders/ion_rangeslider.min.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/tables/datatables/extensions/select.min.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
	<script src="{{ asset('/admin/js/lists.js?v=' . $version->js) }}"></script>
@append

@php
	/**
	 *	"$b_title" is per-module specific setting is defined in list.blade.php specific to module
	 *	it overrides settings from Model as detected by Controller
	 */
	$b_title_final	= (!isset($b_title) && $_env->b_title || (isset($b_title) && $b_title));
@endphp

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){

			let s_route_add = '{!! $s_create_route !!}';
			let s_route_del = '{!! $s_delete_route !!}';

			if (typeof a_order == 'undefined')
				a_order = [ 2, "asc" ];

			if (typeof i_perpage == 'undefined')
				i_perpage = 20;

			@include('admin.common.list_js')
			@include('admin.common.filters.js')

			let dt = $('.table').DataTable({
				'language': {
					"aria"						: {
						"sortAscending"	: '{!! trans('common/datatable.sortAscending') !!}',
						"sortDescending": '{!! trans('common/datatable.sortDescending') !!}',
						},
					"decimal"					: '{!! trans('common/datatable.decimal') !!}',
					"emptyTable"			: '{!! trans('common/datatable.emptyTable') !!}',
					'info'						: '{!! trans('common/datatable.info') !!}',
					'infoEmpty'				: '{!! trans('common/datatable.infoEmpty') !!}',
					'infoFiltered'		: '{!! trans('common/datatable.infoFiltered') !!}',
					"infoPostFix"			: '{!! trans('common/datatable.infoPostFix') !!}',
					'lengthMenu'			: '{!! trans('common/datatable.lengthMenu') !!}',
					"loadingRecords"	: '{!! trans('common/datatable.loadingRecords') !!}',
					"paginate"				: {
						"first"					: '{!! trans('common/datatable.first') !!}',
						"last"					: '{!! trans('common/datatable.last') !!}',
						"next"					: '{!! trans('common/datatable.next') !!}',
						"previous"			: '{!! trans('common/datatable.previous') !!}',
						},
					"processing"			: '{!! trans('common/datatable.processing') !!}',
					"search"					: '{!! trans('common/datatable.search') !!}',
					"thousands"				: '{!! trans('common/datatable.thousands') !!}',
					'zeroRecords'			: '{!! trans('common/datatable.zeroRecords') !!}',

				},
				dom: 'tip',
				deferRender: true,
				autoWidth: false,
				processing: true,
				serverSide: true,
				searching: false,
				pageLength: i_perpage,
				select: {
					style: 'os',
					selector: 'td:not(:last-child)'
				},
				order: a_order,
				columns: [
					@include('user._list_table_columns')
				],

				// Per-row function to iterate cells
				"createdRow": function (row, data, rowIndex) {
					$(row).attr('data-id', data.id);
/*
					// Per-cell function to do whatever needed with cells
					$.each($('td', row), function (colIndex) {
						// For example, adding data-* attributes to the cell
						$(this).attr('data-content', $(this).html());
					});
*/
				},
				// Sets the attribute
				"columnDefs": [{
					"targets":'_all',
					"createdCell": function(cell, data, cellIndex){
						cell.setAttribute('data-content',data);
					}
				}],

				ajax: {
					url: '{!! route('api.'.$s_category.'.index') !!}',
					data: function(data){
						data.filters = filters;
					}
				}
			});

		});
	</script>
@append

@section('content')
	<div class="card">
		<div class="card-body p-0">
			@include('user._filter_wrap')
			@include('user._list_table_wrap')
		</div>
	</div>
@endsection
