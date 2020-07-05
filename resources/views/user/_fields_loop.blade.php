@foreach ($a_fields AS $s_name => $s_field_type)
@php
$b_show_field = TRUE;
$b_show_field = $b_show_field && $s_name != 'trans';
$b_show_field = $b_show_field && $s_name != 'published';
$b_show_field = $b_show_field || $s_name == 'published' && $_env->s_utype == 'user';
@endphp
@if ($b_show_field)
@include('layouts._form_control', ['control' => $s_field_type, 'name' => $s_name])
@endif
@endforeach
