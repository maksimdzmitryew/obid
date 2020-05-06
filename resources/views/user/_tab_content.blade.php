@php
$a_fields_trans = [];
if (isset($form['fields'][$s_tab_key]['trans']))
$a_fields_trans = $form['fields'][$s_tab_key]['trans'];
$a_fields_regular = $form['fields'][$s_tab_key];
unset($a_fields_regular['trans']);
@endphp
<div class="tab-pane px-2 {!! $b_active ? 'active' : '' !!}" id="{!! $s_tab_key !!}">
	<legend class="text-uppercase font-size-sm font-weight-bold">
		{!! trans('user/crud.tab.'.$s_tab_key.'.info') !!}
	</legend>

	@include('user._fields_loop', ['a_fields' => $a_fields_regular,])

	@if (count($a_fields_trans) > 0)
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
			@include('user._fields_loop', ['a_fields' => $a_fields_trans,])
			</div>
		@endforeach
		@php ($code = NULL) @endphp
	</div>
	@endif

{{--
	@foreach ($form['fields'][$s_tab_key] AS $s_field_name => $s_field_type)
	@if ($s_field_name != 'trans')
	{!! $s_field_type !!}
	{!! $s_field_name !!}

	@include('user._form_'.$s_field_type, ['name' => $s_field_name,])

	@else

@dd($s_field_type)
	<ul class="nav nav-tabs nav-tabs-highlight">
		@foreach($localizations as $code => $localization)
			<li class="nav-item">
				<a href="#{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!}" data-toggle="tab">
					<img src="{!! asset('images/flags/' . $code . '.png') !!}" width="30rem" class="mr-1">
					{!! $localization !!}
				</a>
			</li>
		@endforeach
	</ul>
	<div class="tab-content">
		@foreach($localizations as $code => $localization)
			<div class="tab-pane px-2 {!! $app->getLocale() === $code ? 'active' : ''!!}" id="{!! $code !!}">
			@include('user._form_input', ['name'=>'title',])
			</div>
		@endforeach
	</div>
	@endif
	@endforeach
--}}
</div>
