@extends('layouts.public')

@section('meta')
    <title>{!! $settings->title !!} | {!! mb_strtoupper($festival->name) !!}</title>
    <meta name="title" content="{!! $festival->meta_title !!}">
    <meta name="description" content="{!! $festival->meta_description !!}">
    <meta name="keywords" content="{!! $festival->meta_keywords !!}">
@endsection

@section('css')
    <link rel="stylesheet" href="{!! asset('/admin/js/plugins/pickers/air-datepicker/datepicker.min.css') !!}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
    {{--<script src="{{ asset('/admin/js/plugins/pickers/daterangepicker.js') }}"></script>--}}
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/i18n/datepicker.de.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    @if(0 & $festival->active)
    <script src="{!! asset('/user/js/filter_category.js') !!}"></script>
    @endif
@endsection

@section('content')
@if($festival->slider)
    <div class="top-slider-wrap">
        <div id="top-slider">
            @foreach($festival->slider->slides as $slide)
                <div class="slide-item">
                    <div class="img-wrap">
                        <img src="{{ $slide->image->medium_image_url }}" alt="slide"/>
                    </div>
                    <div class="descr">
                        <div class="top-text">{{ $slide->upper_title }}</div>
                        <h2 class="slide-title">{{ $slide->title }}</h2>
                        <div class="short">{{ $slide->description }}</div>
                        @if($slide->button_text)
                            <div class="btn-wrap">
                                <a href="{{ $slide->button_url }}" class="btn btn-primary">{{ $slide->button_text }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if($festival->active && $promoting_up_events->count())
    <div class="main-event-wrap">
        <div class="container-fluid">
            <div class="row">
                @foreach($promoting_up_events as $event)
                    <div class="{{ $promoting_up_events->count() == 1 ? 'offset-md-3' : '' }} col-md-6">
                        <div class="event-box d-flex flex-column" onclick="window.location.href='{{-- route('public.festival.event', [$festival->slug, $event->slug]) --}}';
                                return false;">
                            <div class="main-event mb-auto">
                                <img src="{{ $event->image->medium_image_url ? $event->image->medium_image_url : '/admin/images/no-image-logo.jpg'}}" alt="{{ $event->image->name ? $event->image->name : 'no image'}}">
                                <div class="descr">
                                    <div class="top">
                                        <div class="box">
                                            <div class="label">{{ $event->category->name }}</div>
                                            <div class="name">{{ $event->directors->implode(', ') }}</div>
                                        </div>
                                        <div class="box-hover">
                                            <div class="name">{{ $event->category->name }}</div>
                                        </div>
                                    </div>
                                    <h3>{{ $event->title }}</h3>
                                </div>
                            </div>
                            <div class="sub-event">
                                <div class="row flex-nowrap item-wrap">
                                    @foreach($event->holdings as $holding)
                                        <div class="sub-event-item col-md-3 col-sm-3 col-4">
                                            <div class="time">{{ $holding->date_from->format('H:i') }}</div>
                                            <div class="date">{{ $holding->date_from->format('d/m') }}</div>
                                            <div class="name">{{ $holding->place->name }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<div class="news-block">
    <div class="container-fluid">
        <div class="row">
            @foreach($news as $post)
                @if($post->type === 'medias')
                    @include('public.partials.media', ['media' => $post])
                @else
                    @include('public.partials.post')
                @endif
            @endforeach
        </div>
    </div>
</div>

@if($festival->active)
    @include(
        'public.partials.events-list',
        [
            'cities'            => $cities,
#            'holding_dates'     => $holding_dates,
            'dates_filtered'    => $dates_filtered,
            'dates_range'       => $dates_range,
            'categories'        => $categories,
            'promotion'         => false
        ]
    )
@endif

<div id="program-line-tpl" class="d-none">
	<!--
    <div class="program-line">
        <div class="block-title">${date_from}</div>
        {%each(i, event) events %}
        <div class="events">
            <div class="event-item">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-4 col-12">
                        <div class="img-wrap">
                            <div class="bookmark {%if is_favorite %}added{%/if%}" data-event-id="${event.id}">
                                <svg class="mark_icon" width="25" height="37" viewBox="0 0 25 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 0V34.2246C1 35.0039 1.85185 35.4837 2.51829 35.0799L12.0077 29.3289C12.339 29.1281 12.7563 29.1367 13.079 29.3509L21.5433 34.9692C22.208 35.4104 23.0963 34.9338 23.0963 34.136V0" stroke="white" stroke-width="2"/>
                                </svg>
                                <span class="mark-plus">+</span>
                            </div>
                            <a href="${event.route}"><img src="${event.image.url}" alt="${event.image.name}"></a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12">
                        <div class="descr">
                            <h5 class="event-title"><a href="${event.route}">${event.title}</a></h5>
                            <div class="short small-text">${event.description}</div>
                            <div class="box">
                                <a class="label">${event.category.name}</a>
                                <div class="name">${event.directors}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-event sub-event-stoke">
                    <div class="row flex-nowrap item-wrap">
                        {%each(i, holding) event.holdings %}
                        <div class="sub-event-item col-lg-3 col-sm-4 col-6">
                            <div class="info-box">
                                <div class="time">${holding.date_from}</div>
                                <div class="date">${holding.date_from}</div>
                                <div class="name">${holding.city}</div>
                            </div>
                        </div>
                        {%/each%}
                    </div>
                </div>
            </div>
        </div>
        {%/each%}
    </div>
	-->
</div>

<div id="arrow-left" class="d-none">
    <li class="page-item prev-page-item" data-current="${current}" data-total="${records_total}" data-limit="${limit}">
        <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"></rect>
            <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"></rect>
            <path d="M0.435841 9.94886L9.9585 0.435333C10.5395 -0.145111 11.4818 -0.145111 12.0628 0.435333C12.6439 1.0159 12.6439 1.95702 12.0628 2.53758L5.08016 9.5135L30.5121 9.5135C31.3338 9.5135 32 10.1791 32 11C32 11.8208 31.3338 12.4865 30.5121 12.4865L5.08016 12.4865L12.0625 19.4624C12.6437 20.0429 12.6437 20.9841 12.0625 21.5646C11.7721 21.8547 11.3912 22 11.0104 22C10.6296 22 10.2488 21.8547 9.95826 21.5646L0.435841 12.0511C-0.145279 11.4705 -0.145279 10.5294 0.435841 9.94886Z" fill="black"></path>
        </svg>
    </li>
</div>
<div id="arrow-right" class="d-none">
    <li class="page-item next-page-item" data-current="${current}" data-total="${records_total}" data-limit="${limit}">
        <a class="page-link" href="http://culture-scapes.loc/news?page=2">
            <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"></rect>
                <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"></rect>
                <path d="M31.5642 12.0511L22.0415 21.5647C21.4605 22.1451 20.5182 22.1451 19.9372 21.5647C19.3561 20.9841 19.3561 20.043 19.9372 19.4624L26.9198 12.4865H1.48792C0.666229 12.4865 0 11.8209 0 11C0 10.1792 0.666229 9.51353 1.48792 9.51353H26.9198L19.9375 2.53761C19.3563 1.95705 19.3563 1.01592 19.9375 0.435362C20.2279 0.145319 20.6088 0 20.9896 0C21.3704 0 21.7512 0.145319 22.0417 0.435362L31.5642 9.94889C32.1453 10.5295 32.1453 11.4706 31.5642 12.0511Z" fill="black"></path>
            </svg>
        </a>
    </li>
</div>
<div id="page" class="d-none">
    <li class="page-item">
        <a class="page-link" href="#" data-page="${page}" data-total="${records_total}" data-start="${start}" data-limit="${limit}">${page}</a>
    </li>
</div>
<div id="active-page" class="d-none">
    <li class="page-item active">
        <span class="page-link">${page}</span>
    </li>
</div>
{{--<div id="event-tpl" class="d-none">--}}
    {{--<div class="event-item" style="display: none;">--}}
        {{--<div class="row d-flex align-items-center">--}}
            {{--<div class="col-lg-4 col-12">--}}
                {{--<div class="img-wrap">--}}
                    {{--<div class="bookmark added">--}}
                        {{--<svg class="mark_icon" width="25" height="37" viewBox="0 0 25 37" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                            {{--<path d="M1 0V34.2246C1 35.0039 1.85185 35.4837 2.51829 35.0799L12.0077 29.3289C12.339 29.1281 12.7563 29.1367 13.079 29.3509L21.5433 34.9692C22.208 35.4104 23.0963 34.9338 23.0963 34.136V0" stroke="white" stroke-width="2"/>--}}
                        {{--</svg>--}}
                        {{--<span class="mark-plus">+</span>--}}
                    {{--</div>--}}
                    {{--<a href="${route}"><img src="${image_url}" alt="${image_name}"></a>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-lg-8 col-12">--}}
                {{--<div class="descr">--}}
                    {{--<h5 class="event-title"><a href="${route}">${title}</a></h5>--}}
                    {{--<div class="short small-text">${description}</div>--}}
                    {{--<div class="box">--}}
                        {{--<a href="#" class="label">${category}</a>--}}
                        {{--<div class="name">${directors}</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="sub-event sub-event-stoke">--}}
            {{--<div class="row flex-nowrap item-wrap" id="holdings"></div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--<div id="handling-tpl" class="d-none">--}}
    {{--<div class="sub-event-item col-lg-2 col-sm-4 col-6">--}}
        {{--<div class="info-box">--}}
            {{--<div class="time">${date}</div>--}}
            {{--<div class="date">${time}</div>--}}
            {{--<div class="name">${place}</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

@endsection
