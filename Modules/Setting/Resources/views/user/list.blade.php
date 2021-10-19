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

@php
$b_title	= false;

$a_columns = [
				'slug' => 'text',
				'is_translatable' => 'checkbox',
			];
$a_buttons = [
			];
$a_filters = [
				'slug' => 'text',
			];
@endphp
@extends('user.list')
