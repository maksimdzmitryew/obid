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
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){

			let s_route_add = '{!! $s_create_route !!}';
			let s_route_del = '{!! $s_delete_route !!}';

			if (typeof a_order == 'undefined')
				a_order = [ 2, "asc" ];

			@include('admin.common.list_js')
			@include('admin.common.filters.js')

			let dt = $('.table').DataTable({
				'language': {
					'lengthMenu':		'{!! trans('common/datatable.lengthMenu') !!}',
					'zeroRecords':		'{!! trans('common/datatable.zeroRecords') !!}',
					'info':				'{!! trans('common/datatable.info') !!}',
					'infoEmpty':		'{!! trans('common/datatable.infoEmpty') !!}',
					'infoFiltered':		'{!! trans('common/datatable.infoFiltered') !!}',
				},
				dom: 'tip',
				autoWidth: false,
				processing: true,
				serverSide: true,
				searching: false,
				pageLength: 20,
				select: {
					style: 'os',
					selector: 'td:not(:last-child)'
				},
                order: a_order,
				columns: [
					@include('user._list_table_columns')
				],
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