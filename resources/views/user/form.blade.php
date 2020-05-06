@extends('layouts.admin')

@php
include(base_path().'/resources/views/user/crud.php');
@endphp

@section('title-icon')<i class="{!! trans('user/' . $s_category . '.names.ico') !!} mr-2"></i>@endsection

@section('title'){!! $s_page_action !!}@endsection

@section('breadcrumbs')
	<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
		<div class="d-flex">
			<div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
				<a href="{!! $s_list_route !!}" class="breadcrumb-item">{!! $s_list_name !!}</a>
				<span class="breadcrumb-item active">{!! $s_page_action !!}</span>
			</div>
			<a href="{!! $s_page_route !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}{!! '?v=' . $version->css !!}">
@endsection

@section('js')
<script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
<script src="{!! asset('/admin/js/forms.js?v=' . $version->js) !!}"></script>
@append

@section('script')
<script type="text/javascript">
@include('admin.common.data2js')
</script>
@append

@php ($code = NULL) @endphp

@section('content')
	<div class="card form">
		<div class="card-body p-0">
			<div class="card-body">
				<form class="form-validate-jquery item-form" action="{!! $s_form_route !!}" method="{!! $s_form_method !!}">
					<ul class="nav nav-tabs nav-tabs-highlight">
						@include('user._tab_loop', ['tpl' => 'user._tab_title'])
					</ul>
					<div class="tab-content">
						@include('user._form_submit')
						@include('user._tab_loop', ['tpl' => 'user._tab_content'])
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection