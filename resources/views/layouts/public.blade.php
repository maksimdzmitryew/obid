@php
# $version = include_once( __DIR__ . '/../../../version.php');
@endphp<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="version-app" content="{{ $version->app }}">

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/icomoon/styles.css') }}">

    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.formstyler.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.formstyler.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">

    @yield('css')

    <link rel="stylesheet" href="{{ asset('css/app_public.css?v=' . $version->css) }}">
    <link rel="stylesheet" href="{{ asset('css/app_media.css?v=' . $version->css) }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{--
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-146132445-1"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());

     gtag('config', 'UA-146132445-1');
    </script>
    --}}

@section('script')
<script type="text/javascript">
@include('common.var2js')
</script>
@append

</head>
<body class="no-front">

@if(isset($festival) && isset($festival->color))
<style>
#main-menu > li > a:hover, #main-menu > li > a.active, .logo-wrap a, #header .navbar-brand {
    color: {{$festival->color}};
}
#festival-menu-wrap #festival-menu > li > a.active, .red-block, .newsletter-subscr .newsletter-info .festival-date,.buy-btn, .nobuy-btn {
    background: {{$festival->color}};
}
.btn-primary, .slick-dots li:hover button::before, .slick-dots li.slick-active button::before, .label, .label:hover, .label:active, .filter-label.selected, .filter-label:hover, .datepicker .-selected-.datepicker--cell-day.-other-month-, .datepicker .-selected-.datepicker--cell-year.-other-decade-, .datepicker .-in-range-.datepicker--cell-day.-other-month-, .datepicker .-in-range-.datepicker--cell-year.-other-decade-, .datepicker .datepicker--cell.-in-range-, .datepicker .datepicker--cell.-range-from-, .datepicker .datepicker--cell.-range-to-, .datepicker .-selected-.-focus-.datepicker--cell-day.-other-month-, .datepicker .-selected-.-focus-.datepicker--cell-year.-other-decade-, .datepicker .-in-range-.-focus-.datepicker--cell-day.-other-month-, .datepicker .-in-range-.-focus-.datepicker--cell-year.-other-decade-, .datepicker .datepicker--cell.-in-range-.-focus-, .datepicker .datepicker--cell.-selected-.-focus-, .datepicker--cell.-in-range-.-focus-, .filter.selected > .filter-label, .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    background: {{$festival->color}};
    border-color: {{$festival->color}};
    color:#fff!important;
}
.btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:hover, .btn-primary:focus,
.download-btn:not(:disabled):not(.disabled).active, .download-btn:not(:disabled):not(.disabled):active, .download-btn:hover, .download-btn:focus,
.filter-label:hover {
    color: {{$festival->color}}!important;
    background-color: #fff;
    border-color: {{$festival->color}};
}
.img-slider-wrap .slick-arrow:hover {
    background: {{$festival->color}};
    color: #fff;
}
.buy-btn:hover, .buy-btn:focus {
    background: {{$festival->color}};
}
.btn-success:not(:disabled):not(.disabled):hover {
    border: 1px solid {{$festival->color}};
    background: {{$festival->color}};
}
.datepicker .-selected-.-focus-.datepicker--cell-day.-other-month-,
.datepicker .-selected-.-focus-.datepicker--cell-year.-other-decade-,
.datepicker .-in-range-.-focus-.datepicker--cell-day.-other-month-,
.datepicker .-in-range-.-focus-.datepicker--cell-year.-other-decade-,
.datepicker .datepicker--cell.-in-range-.-focus-,
.datepicker .datepicker--cell.-selected-.-focus-,
.datepicker--cell.-in-range-.-focus-{
    background: {{$festival->color}};
}
.datepicker  .datepicker--cell.-focus-{
    background: none;
    color: {{$festival->color}};
}
.datepicker .datepicker--cell.-selected-,
.datepicker .datepicker--cell.-selected-.-current-{
    background: {{$festival->color}};
    color: #0E293C;
}
.datepicker .-selected-.datepicker--cell-day.-other-month-,
.datepicker .-selected-.datepicker--cell-year.-other-decade-,
.datepicker .-in-range-.datepicker--cell-day.-other-month-,
.datepicker .-in-range-.datepicker--cell-year.-other-decade-,
.datepicker .datepicker--cell.-in-range- {
    background: {{$festival->color}};
    color: #0E293C;
}
.datepicker .datepicker--cell.-range-from-,
.datepicker .datepicker--cell.-range-to-{
    background: {{$festival->color}};
    border: 1px solid {{$festival->color}};
}
.datepicker .datepicker--nav-action:hover path{
    fill: {{$festival->color}};
}
.datepicker .datepicker--cell.-current-.-focus-{
    color: {{$festival->color}};
}
.nav-tabs .nav-item .nav-link:focus, .nav-tabs .nav-item .nav-link:hover {
    border-color:{{$festival->color}};
}
.bookmark.added:hover .mark_icon, .bookmark.added .mark_icon, .bookmark.added:hover .mark_icon, .bookmark.added .mark_icon, .bookmark:hover .mark_icon {
    fill:{{$festival->color}};
}
#festival-menu-wrap #festival-menu > li > a.active::after, .newsletter-subscr .newsletter-info .festival-date:after {
    border-top-color: {{$festival->color}};
}
.form-control:focus {
    border-color: {{$festival->color}};
}
#header .stick-line:before {
    background: {{$festival->color}};
}
.theme-icon:hover, .theme-icon.show_menu, .theme-icon.active {
    border-color: {{$festival->color}};
}
.theme-icon:hover svg path, .theme-icon.show_menu svg path, .theme-icon.active svg path {
    stroke: {{$festival->color}};
}
.slick-dots li:hover button::before,
.slick-dots li.slick-active button::before {
    background: {{$festival->color}};
    border-color: {{$festival->color}};
}
.label, .label:hover, .label:active {
    background: {{$festival->color}};
}
.event-box:hover {
    background: {{$festival->color}};
    color: #0E293C;
}
.bookmark:hover .mark_icon {
    fill: {{$festival->color}};
}
.bookmark.added:hover .mark_icon,
.bookmark.added .mark_icon {
    fill: {{$festival->color}};
}
.filter.selected > .filter-label {
    background: {{$festival->color}};
}
.filter-label.selected {
    background: {{$festival->color}};
}
.jq-selectbox.opened .jq-selectbox__select,
.jq-selectbox__select:active {
    background: #fff;
    border-color: {{$festival->color}};
}
.jq-selectbox li:hover {
    color: #0E293C;
    background-color: {{$festival->color}};
}
.jq-checkbox.focused,
.jq-checkbox:focus {
    border-color: {{$festival->color}};
}
.page-item.active .page-link {
    background-color: {{$festival->color}};
}
.page-item.prev-page-item .page-link:hover svg path,
.page-item.next-page-item .page-link:hover svg path {
    fill: {{$festival->color}};
}
.img-slider-wrap .slider-nav .slick-slide.slick-current {
    border: 1px solid {{$festival->color}};
}
.img-slider-wrap .slick-arrow {
    background: {{$festival->color}};
}
.nav-tabs .nav-item .nav-link:focus, .nav-tabs .nav-item .nav-link:hover {
    border-color: {{$festival->color}};
}
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: #0E293C;
    border-color: {{$festival->color}};
    background: {{$festival->color}};
}
.buy-btn, .nobuy-btn {
    background: {{$festival->color}};
}
.arr {
    background: {{$festival->color}};
}
.daterangepicker td.active, .daterangepicker td.active:hover, .daterangepicker td.active:focus {
    background-color: {{$festival->color}};
}
.ranges ul li.active {
    background-color: {{$festival->color}};
}
.ranges .btn-success,
.ranges .btn-success:hover,
.ranges .btn-success:active,
.btn-success:not(:disabled):not(.disabled).active,
.btn-success:not(:disabled):not(.disabled):active {
    border: 1px solid {{$festival->color}};
    background: {{$festival->color}};
}
.datepicker .datepicker--nav-action:hover,
.datepicker .datepicker--nav-title:hover{
    background: none;
    color: {{$festival->color}};
}
.btn-primary {
    background-color: {{$festival->color}};
    border-color: {{$festival->color}};
}
</style>
@endif
    <div class="loaderArea"></div>
<!-- Header section -->

{{--<div id="festival-links">--}}
    {{--<a class="nav-link active" href="{{ $festival->active ? route('public.home') : route('public.archive', $festival->slug) }}">--}}
        {{--{{ $festival->name }}<br>{{ $festival->year }}--}}
    {{--</a>--}}
    {{--@foreach($festivals as $archive)--}}
        {{--<a class="nav-link" href="{{ $archive->active ? route('public.home') : route('public.archive', $archive->slug) }}">--}}
            {{--{{ $archive->name }}<br>{{ $archive->year }}--}}
        {{--</a>--}}
    {{--@endforeach--}}
{{--</div>--}}

{{--<div id="festival-menu-wrap" style="position: absolute; width: 100%; top: -200px;">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <ul class="nav" id="festival-menu">
                @foreach($festivals as $fest)
                    <li class="nav-item">
                        <a class="nav-link {!! $fest->id === $festival->id ? 'active' : '' !!}" href="{{ -- route('public.festival.index', $fest->slug) -- }}">
                            {{ $fest->name }}<br>{{ $fest->year }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div id="fest-icon-wrap">
                <div id="festival-icon"><span></span></div>
            </div>
        </div>
    </div>
</div>--}}

{{--<div id="festival-menu-wrap" id="festival-menu-wrap">--}}
    {{--<div class="container-fluid">--}}
        {{--<div class="d-flex align-items-center">--}}
            {{--<ul class="nav" id="festival-menu"></ul>--}}
            {{--<div id="fest-icon-wrap">--}}
                {{--<div id="festival-icon"><span></span></div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div id="fest-menu-box">
    <div id="fest-close"><span></span></div>
    <ul id="festival-sub-menu"></ul>
</div>

<header id="header">
    <div class="stick-line"></div>
    <div class="navi-wrap">
        <nav class="navbar navbar-expand-sm navbar-light">
            <!--a class="navbar-brand" href="{{-- route('public.festival.index', $festival->slug) --}}"><img src="/img/logo.png" height="46" width="113" alt="logo"/></a-->
            <a class="navbar-brand" href="{{-- route('public.festival.index', $festival->slug) --}}">{!! $settings->title !!}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto" id="main-menu">
            	@php
            	/*
                    <li class="nav-item">
                        <a class="nav-link {{-- $current_route_name == 'public.festival.program' ? 'active' : '' --}}" href="{{-- route('public.festival.program', $festival->slug) --}}">
                            {{ trans('general.program') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{-- $current_route_name == 'public.festival.posts' ? 'active' : '' --}}" href="{{-- route('public.festival.posts', $festival->slug) --}}">
                            {{ trans('general.news') }}
                        </a>
                    </li>
                    @if($festival->book)
                        <li class="nav-item">
                            <a class="nav-link {{-- $current_route_name == 'public.festival.book' ? 'active' : '' --}}" href="{{-- route('public.festival.book', [$festival->slug, $festival->book->slug]) --}}">
                                {{ trans('general.book') }}
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{-- $current_route_name == 'public.festival.partners' ? 'active' : '' --}}" href="{{-- route('public.festival.partners', $festival->slug) --}}">
                            {{ trans('general.partners') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{-- $current_route_name == 'public.festival.about' ? 'active' : '' --}}" href="{{-- route('public.festival.about', $festival->slug) }}">
                            {{ trans('general.about-us') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{-- $current_route_name == 'public.festival.presses' ? 'active' : '' --}}" href="{{-- route('public.festival.presses', $festival->slug) --}}">
                            {{ trans('general.press') }}
                        </a>
                    </li>
                */
                @endphp
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <a href="{{ route('public.cabinet') }}" id="user-icon" class="theme-icon">
                        <svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 22.8429C0 21.3561 0.783043 19.9908 2.04435 19.2785L5.92304 17.0887C6.29217 16.8799 6.52174 16.4804 6.52174 16.0448V14.5557C6.23043 14.1611 5.39696 12.9312 4.9987 11.299C4.58826 10.9584 4.34783 10.4476 4.34783 9.9V8.1C4.34783 7.66665 4.50435 7.2468 4.78261 6.91875V4.5252C4.75826 4.2777 4.66261 2.80395 5.69217 1.5885C6.58522 0.5346 8.03435 0 10 0C11.9657 0 13.4148 0.5346 14.3078 1.58895C15.3374 2.8044 15.2417 4.2777 15.2174 4.5252V6.91875C15.4957 7.2468 15.6522 7.66665 15.6522 8.1V9.9C15.6522 10.6087 15.2539 11.2365 14.6404 11.5276C14.3265 12.4731 13.8948 13.3497 13.3561 14.1372C13.2478 14.2956 13.143 14.4392 13.0435 14.5652V16.0866C13.0435 16.5402 13.287 16.9479 13.6787 17.1509L17.8322 19.3001C19.1691 19.9922 20 20.3836 20 21.9307" transform="translate(1 1)" stroke="#8C999E"/>
                        </svg>
                    </a>
                    <div id="search-icon" class="theme-icon">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.8401 13.0856L13.5339 13.4375L13.8638 13.7673L18.4821 18.3846C18.4925 18.3949 18.5 18.4106 18.5 18.4313C18.5 18.4519 18.4925 18.4676 18.4821 18.4779L18.4821 18.4778L18.4755 18.4846C18.4677 18.4928 18.4538 18.5 18.4354 18.5C18.4318 18.5 18.4242 18.4991 18.4143 18.4951C18.4047 18.4911 18.3958 18.4852 18.3886 18.4779L13.7702 13.8606L13.4405 13.5309L13.0886 13.8369C11.7516 14.9996 10.0088 15.7027 8.10313 15.7027C3.91254 15.7027 0.5 12.2907 0.5 8.10133C0.5 3.91178 3.9085 0.5 8.10313 0.5C12.2939 0.5 15.7063 3.9079 15.7063 8.10133C15.7063 10.0065 15.0031 11.7489 13.8401 13.0856ZM8.09891 0.637472C3.98431 0.637472 0.633511 3.98276 0.633511 8.10133C0.633511 12.2195 3.98391 15.5694 8.09891 15.5694C12.2185 15.5694 15.5643 12.2149 15.5643 8.10133C15.5643 3.98736 12.2181 0.637472 8.09891 0.637472Z" fill="black" stroke="#8C999E"/>
                        </svg>
                    </div>
                    <div class="socil d-md-none d-sm-none d-lg-block">
                       	@if ($settings->facebook)<a href="https://www.facebook.com/{!! $settings->facebook !!}" class="fb" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>@endif
                        @if ($settings->youtube)<a href="https://www.youtube.com/{!! $settings->youtube !!}" class="youtube" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>@endif
                        @if ($settings->instagram)<a href="https://www.instagram.com/{!! $settings->instagram !!}" class="im" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>@endif
                    </div>
                    <div class="lang-menu">
                        <div class="current-lang" data-lang="en"><span class="lang-text">{{ $localizations[app()->getLocale()] }}</span><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                        <div class="lang-box">
                            @foreach($localizations as $code => $localization)
                            	@if (app()->getLocale() != $code)
                                <div class="lang-item" data-lang="{{ $code }}">
                                	<a href="{{ route('change-lang', $code) }}">
                                		{{ $localization }}
                                	</a>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div id="search-wrap">
            <div class="container-fluid">
                <form action="{{-- route('public.search', $festival->slug) --}}" id="search-form" method="get">
                    <div class="form-group">
                        <div class="glass-icon">
                            <svg width="33" height="33" viewBox="0 0 33 33" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect width="33" height="33" fill="black" fill-opacity="0"/>
                                <rect width="33" height="33" fill="black" fill-opacity="0"/>
                                <path d="M32.7146 31.3171L24.6933 23.2976C26.845 20.8244 28.1477 17.5976 28.1477 14.0707C28.1477 6.30732 21.8317 0 14.0739 0C6.30872 0 0 6.31464 0 14.0707C0 21.8268 6.31603 28.1415 14.0739 28.1415C17.6015 28.1415 20.829 26.839 23.3027 24.6878L31.324 32.7073C31.5143 32.8976 31.7705 33 32.0193 33C32.2681 33 32.5243 32.9049 32.7146 32.7073C33.0951 32.3268 33.0951 31.6976 32.7146 31.3171ZM1.96873 14.0707C1.96873 7.39756 7.3992 1.97561 14.0665 1.97561C20.7412 1.97561 26.1643 7.40488 26.1643 14.0707C26.1643 20.7366 20.7412 26.1732 14.0665 26.1732C7.3992 26.1732 1.96873 20.7439 1.96873 14.0707Z" fill="#0E293C"/>
                            </svg>
                        </div>
                        <input type="text" class="form-control" id="search-text" placeholder="{{ trans('general.search-hint') }} {!! $settings->title !!}" name="q" value="{{ app('request')->input('q') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ trans('general.search-btn') }}</button>
                </form>
            </div>
        </div>
    </div>
</header>

@yield('content')

<!-- Bottom section -->

{{--@if($festival->translate(app()->getLocale())->file->url)
    <div class="download-block red-block">
        <div class="container-fluid">
            <div class="row d-flex align-items-center">
                <div class="col-lg-3 col-sm-4 col-12">
                    <div class="down-title block-title ">{{ trans('general.download-full-program') }}</div>
                </div>
                <div class="col-lg-9 col-sm-8 col-12">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6 col-12">
                            <div class="text small-text">
                                {{ $festival->program_description }}
                            </div>
                        </div>
                        <div class="col-md-6 col-12 right-block">
                            <a href="{{ $festival->translate(app()->getLocale())->file->url }}" class="btn" target="_blank">
                                {{ trans('general.download-pdf') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif--}}

@php
/*
<div class="newsletter-subscr bg-grey">
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-lg-3 col-sm-4">
                <div class="newsletter-info">
                    <div class="festival-date">
                        {{ $festival->name }}<br>{{ $festival->year }}
                    </div>
                    <div class="logo-wrap">
                        <a href="{{ route('public.home') }}">CULTURE<br>SCAPES
                            <!--img src="/img/logo.png" height="46" width="113" alt="logo"-->
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-sm-8">
                <h3 class="form-title">{{ trans('general.subscribe') }}</h3>
                <form action="{{-- route('api.subscribe') --}}" class="newsletter-form" id="subscribe-form" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <svg width="27" height="19" viewBox="0 0 27 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="25.6413" height="18.2635" fill="black" fill-opacity="0" transform="translate(0.904053)"/>
                            <rect width="25.6413" height="18.2635" fill="black" fill-opacity="0" transform="translate(0.904053)"/>
                            <path d="M26.1962 8.25914L18.5657 0.361396C18.1002 -0.120465 17.3451 -0.120465 16.8796 0.361396C16.414 0.843356 16.414 1.62464 16.8796 2.1066L22.4747 7.89772H2.09631C1.4379 7.89772 0.904053 8.45027 0.904053 9.13174C0.904053 9.81312 1.4379 10.3658 2.09631 10.3658H22.4747L16.8798 16.1569C16.4141 16.6388 16.4141 17.4201 16.8798 17.9021C17.1125 18.1429 17.4177 18.2635 17.7229 18.2635C18.028 18.2635 18.3331 18.1429 18.5659 17.9021L26.1962 10.0043C26.6618 9.52239 26.6618 8.7411 26.1962 8.25914Z" fill="#0E293C"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="partner-section">
    <div class="container-fluid">
        <div class="partner-inner">
            <div class="row">
                @if (isset($promoting_partners))
                @foreach($promoting_partners as $partner)
                    <div class="col-sm-3 col-6 partner-block-item">
                        <a class="partner-block" href="{{ $partner->url }}" target="_blank">
                            <img src="{{ $partner->image->url }}" alt="">
                        </a>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
*/
@endphp

<footer id="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 footer-block-1">
                <div class="text">
                    @if(isset($texts_footer['footer_about']))
                    {!! $texts_footer['footer_about'] !!}
                    @endif
                </div>
                <div class="socil social-bright">
                    @if ($settings->facebook)<a href="https://www.facebook.com/{!! $settings->facebook !!}" class="fb noline" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>@endif
                    @if ($settings->youtube)<a href="https://www.youtube.com/{!! $settings->youtube !!}" class="youtube noline" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>@endif
                    @if ($settings->instagram)<a href="https://www.instagram.com/{!! $settings->instagram !!}" class="im noline" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>@endif
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 footer-block-2">
                <ul class="nav">
                	@php
                	/*
                    <li class="nav-item">
                        <a class="nav-link {{-- $current_route_name == 'public.page.about-us' ? 'active' : '' --}}" href="{{-- route('public.festival.about', $festival->slug) --}}">
                            {{ trans('general.about-us') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{-- $current_route_name == 'public.presses' ? 'active' : '' --}}" href="{{-- route('public.festival.presses', $festival->slug) --}}">
                            {{ trans('general.press') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{-- $current_route_name == 'public.partners' ? 'active' : '' --}}" href="{{-- route('public.festival.partners', $festival->slug) --}}">
                            {{ trans('general.partners') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{-- route('public.page', 'impressum') --}}">
                            {{ trans('general.impressum') }}
                        </a>
                    </li>
                    */
                    @endphp
                    {{-- <li class="nav-item">
                        <a class="nav-link disabled" href="#">Site notice</a>
                    </li> --}}
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 footer-block-3 noline">
                @if(isset($texts_footer['footer_contacts']))
                {!! $texts_footer['footer_contacts'] !!}
                @endif
                <a class="noline" href="{!! $settings->domain !!}">&copy;&nbsp;{!! $settings->established !!}{{-- &nbsp;&mdash;&nbsp;< ? php echo date('Y') ? > --}}</a>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 footer-block-4">
            @php
            /*
                <h5 class="form-title">{{ trans('general.contact-us') }}</h5>
                <form action="{{-- route('public.contact-us') --}}" method="POST" id="contact-form">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" id="message" rows="3" name="message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ trans('general.write-us') }}</button>
                </form>
            */
            @endphp
            </div>
        </div>
    </div>
</footer>

<!-- Optional JavaScript -->
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm -->
@if (Cookie::get( config('cookie-consent.cookie_name') ) !== null)
@endif
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('js/jquery.formstyler.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/notifications/sweetalert1.min.js') }}"></script>
<script src="{!! asset('/js/common.js?v=' . $version->js) !!}"></script>
<script src="{{ asset('/js/app_public.js?v=' . $version->js) }}"></script>

@yield('js')
@yield('script')

</body>
</html>