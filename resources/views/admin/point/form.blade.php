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

@section('content')
	<div class="card form">
		<div class="card-body p-0">
			<div class="card-body">
				<form class="form-validate-jquery item-form" action="{!! $s_form_route !!}" method="{!! $s_form_method !!}">
					<ul class="nav nav-tabs nav-tabs-highlight">
						<li class="nav-item">
							<a href="#data" class="nav-link active" data-toggle="tab">{!! trans('user/crud.tab.data.name') !!}</a>
						</li>
						<li class="nav-item">
							<a href="#manage" class="nav-link" data-toggle="tab">{!! trans('user/crud.tab.manage.name') !!}</a>
						</li>
					</ul>

					<div class="tab-content">
						@include('user._form_submit')
						@php ($code = NULL) @endphp
						<div class="tab-pane px-2 active" id="data">
							<legend class="text-uppercase font-size-sm font-weight-bold">
								{!! trans('user/crud.tab.data.info') !!}
							</legend>

							@include('layouts._form_control', ['control' => 'select', 'name'=>'building_id'])
{{--
							@include($theme . '::' . $_env->s_utype . '._form_select', ['name'=>'building_id'])
--}}
							<ul class="nav nav-tabs nav-tabs-highlight">
								@foreach($localizations as $code => $localization)
									<li class="nav-item">
										<a href="#{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!}" data-toggle="tab">
											<img src="{!! asset('images/flags/' . $code . '.png') !!}" width="30rem" class="mr-1">
											{!! $localization !!}
										</a>
									</li>
								@endforeach
								@php ($code = NULL) @endphp
							</ul>

							<div class="tab-content">
								@foreach($localizations as $code => $localization)
								<div class="tab-pane px-2 {!! $app->getLocale() === $code ? 'active' : ''!!}" id="{!! $code !!}">
									<fieldset class="mb-3">
									@include('layouts._form_control', ['control' => 'input', 'name'=>'title'])
									@include('layouts._form_control', ['control' => 'input', 'name'=>'annotation'])
									@include('layouts._form_control', ['control' => 'input', 'name'=>'description'])
									@include('layouts._form_control', ['control' => 'input', 'name'=>'address'])
{{--
									@include($theme . '::' . $_env->s_utype . '._form_input', ['name'=>'title'])
									@include($theme . '::' . $_env->s_utype . '._form_input', ['name'=>'annotation'])
									@include($theme . '::' . $_env->s_utype . '._form_input', ['name'=>'description'])
									@include($theme . '::' . $_env->s_utype . '._form_input', ['name'=>'address'])

									@include('user._form_input', ['name'=>'title',])
									@include('user._form_input', ['name'=>'annotation',])
									@include('user._form_input', ['name'=>'description',])
									@include('user._form_input', ['name'=>'address',])
--}}
									</fieldset>
								</div>
								@endforeach
								@php ($code = NULL) @endphp
							</div>
						</div>
						<div class="tab-pane px-2" id="manage">
							<legend class="text-uppercase font-size-sm font-weight-bold">
								{!! trans('user/crud.tab.manage.info') !!}
							</legend>
							@include('layouts._form_control', ['control' => 'checkbox', 'name'=>'published'])
							@include('layouts._form_control', ['control' => 'input', 'name'=>'lat'])
							@include('layouts._form_control', ['control' => 'input', 'name'=>'lng'])
{{--
							@include('user._form_checkbox', ['name'=>'published',])
							@include('user._form_input', ['name'=>'lat',])
							@include('user._form_input', ['name'=>'lng',])
--}}
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection