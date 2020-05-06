@extends($theme . '::layouts.master')

@section('css')
	<link rel="stylesheet" href="{{ asset($theme . '/css/guest_media.css?v=' . $version->css) }}">
	<link rel="stylesheet" href="{{ asset($theme . '/css/cookie_consent.css?v=' . $version->css) }}">
@append

@section('js')
<script src="{{ asset('/js/cookie_consent.js?v=' . $version->js) }}"></script>
@append
