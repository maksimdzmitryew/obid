<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="version-app" content="{{ $version->app }}">
	@yield('meta')

	<title>
	@if(View::hasSection('title'))
	@yield('title') &#60;
	@endif
	{!! mb_strtoupper($settings->title) !!}
	</title>
