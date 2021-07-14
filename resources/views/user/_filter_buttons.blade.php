<div class="buttons col-md-12 col-lg-8 col-xl-8 text-right">
@if (isset($a_buttons) && count($a_buttons) > 0)
@foreach ($a_buttons AS $s_name => $s_type)
@php
switch ($s_type)
{
	case 'xls': $s_ico = 'file-spreadsheet';
}
@endphp
	<a href="{{ route($_env->s_utype . '.' . $s_category . '.download', $s_type) }}" class="btn btn-outline-primary tooltip-helper" id="btn-{!! $s_name !!}" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.' . $s_name . '.label') !!} {!! trans($s_category . '::crud.names.btn_' . $s_name) !!}" data-trigger="hover" title="{!! trans('user/crud.button.' . $s_name . '.label') !!} {!! trans($s_category . '::crud.names.btn_' . $s_name) !!}">
	<i class="icon-{{ $s_ico }}"></i>
</a>
@endforeach
@endif
@include('user._filter_button_add')
@include('user._filter_button_delete')
@include('user._filter_button_filter')
@include('user._filter_button_reset')
</div>
