@extends('layouts.public')

@section('meta')
    <title>{!! $settings->title !!} | {!! mb_strtoupper($festival->name) !!} | {{ mb_strtoupper(trans('general.search-results')) }} {{ app('request')->input('q') }}</title>
    <meta name="title" content="{!! $festival->slug . ' | ' . trans('general.search-results') !!}">
    <meta name="description" content="{!! $festival->slug . ' | ' . trans('general.search-results') !!}">
    <meta name="keywords" content="{!! $festival->slug . ',' . trans('general.search-results') !!}">
@endsection

@section('js')
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/utils/url.min.js') }}"></script>
@endsection

@php
        /*
        'artist',
        'book',
        'event',
        'gallery',
        'partner',
        'place',
        'post',
         */
    $a_types_regular =
    [
        'media',
        'artist',
        'press',
    ];
    $a_types_festival =
    [
        'book',
        'event',
        'post',
    ];
    $a_types = ['all'];
@endphp

@section('script')
<script type="text/javascript">
    @include('public.common.data2js')
</script>
<script src="{!! asset('/user/js/general.js') !!}"></script>
<script type="text/javascript">

    // init routes
    a_types = new Array();
    a_types.push('all');
    var a_route_fe = {};
    var a_route_api = {};
    @foreach($a_types_regular as $type)
    @php $a_types[] = $type; @endphp
    a_types.push('{{ $type }}');
    // festival independent route
    @if (Route::has('public.'.$type))
    a_route_fe['{{ $type }}'] = '{!! route('public.'.$type, ':slug') !!}';
    @endif
    a_route_api['{{ $type }}'] = '{!! route('api.'.str_plural($type).'.index') !!}';
    @endforeach
    @foreach($a_types_festival as $type)
    @php $a_types[] = $type; @endphp
    a_types.push('{{ $type }}');
    // festival specific route
    @if (Route::has('public.'.$type))
    a_route_fe['{{ $type }}'] = '{!! route('public.festival.'.$type, [':festival', ':slug']) !!}';
    @endif
    a_route_api['{{ $type }}'] = '{!! route('api.'.str_plural($type).'.index') !!}';
    @endforeach

//console.log(a_types, a_route_fe);

    $(document).ready(() => {

        moment.locale('{!! $app->getLocale() !!}');

        let //routes = {

                //events: '{ ! ! route('public.events', ':slug') !!}',
                //news: '{!! route('public.news', ':slug') !!}',
                //press: '{ !! route('public.presses', ':slug') !!}',

                //news: '{!! route('public.festival.post', [':festival', ':slug']) !!}',
                //events: '{!! route('public.festival.event', [':festival', ':slug']) !!}',
                //press: '{!! route('public.festival.press', [':festival', ':slug']) !!}',
                //gallery: '{!! route('public.festival.gallery', [':festival', ':slug']) !!}'
            //},
            i_total = 0,
            s_title = document.title,
            query = url('?q');//,
            //festival = '{!! $festival->id !!}';
//console.log(routes.events);
        function request(route, type, data){
            $.ajax({
                url: route,
                data: data,
                type: 'get',
                success: (response) => {
//console.log(response);
                    showSearchResults(response, type);
                    //let route = "{ { route('public.events', ':slug') }}";
                    //let route = "{{ route('public.event', ':slug') }}";
                    //viewTotal[type](data.qty_filtered);
                },
                error: function(response){}
            });
        }

        function showSearchResults(response, type)
        {
//console.log(response.data, type);
//console.log(response.data[0]);
            if (typeof response === 'object')
            {
                response.data.forEach((item) => {
//console.log(item);
                    item = setDate(item);
                    item = setUrl(item, type);
                    item = setImage(item, type);
                    item = setCategory(item);
                    //viewEntry[type](item);
//console.log(typeof item, item, type);
					if (type == 'press')
					{
//						console.log(type, item.type_id, item);
					}
					$('#' + 'all' + '-container').append(getReplaceInTpl(type, item));
					$('#' + type + '-container').append(getReplaceInTpl(type, item));
                });
                // qty_filtered
                updateTotal(type, response.recordsFiltered);
            }
        }

        function updateTotal(s_type, i_qty)
        {
        	i_total = i_total + i_qty;
            $('#results-all-tab span').html('(' + i_total + ')');
            document.title = s_title + ' (' + i_total + ')';
            $('#results-' + s_type + '-tab span').html('(' + i_qty + ')');
        }

/*
        let viewEntry = {
            post: (data) => {
                //data.url = routes.news.replace(':festival', data.festival.slug).replace(':slug', data.slug);
                data.url = routes.news.replace(':slug', data.slug);
                appendToTpl('post', data);
            },
            event: (data) => {
                //data.url = routes.events.replace(':festival', data.festival.slug).replace(':slug', data.slug);
                //data.url = routes.events.replace(':slug', data.slug);
                data.label = '{!! trans('general.events') !!}';
                data.image = data.image.url ? data.image : {
                    name: 'no image',
                    url: '/admin/images/no-image-logo.jpg'
                }
                appendToTpl('event', data);
            },
            press: (data) => {
                //data.url = data.type === 'photo' ? routes.gallery.replace(':festival', data.festival.slug).replace(':slug', data.slug) : null;
                data.url = data.type === 'photo' ? routes.gallery.replace(':slug', data.slug) : null;
                appendToTpl('press', data);
            }
        };

        let viewTotal = {
            post: (total) => {
                $('#results-post-tab span').html(`(${total})`);
            },
            event: (total) => {
                $('#results-event-tab span').html(`(${total})`);
            },
            press: (total) => {
                $('#results-press-tab span').html(`(${total})`);
            }
        };
*/
        a_types.forEach
        (
            function(s_type)
            {
                request(
                    a_route_api[s_type],
                    s_type,
                    {
                        filters: {
                            title: query,
                            name: query,
                            //festivals: [festival],
                            body: query
                        }
                    }
                );
            }
        );
/*
        request('{!! route('api.posts.index') !!}', 'post', {
            filters: {
                title: query,
                //festivals: [festival]
                //body: query
            }
        });
        request('{!! route('api.events.index') !!}', 'event', {
            filters: {
                title: query,
                //festivals: [festival]
                //body: query
            }
        });
        request('{!! route('api.presses.index') !!}', 'press', {
            filters: {
                title: query,
                //festivals: [festival]
                //body: query
            }
        });
*/
    });
</script>
@endsection

@section('content')
<div class="content result-page bg-grey">
    <div class="container-fluid">
        <div class="title-box">
            <h1 class="title-block">{{ trans('general.search-results') }}</h1>
            <ul class="nav nav-tabs" id="searchTab" role="tablist">

            @foreach($a_types as $key => $type)
            @include('public.search.tab')
            @endforeach

@php
/*
                <li class="nav-item">
                    <a class="nav-link active" id="results-event-tab" data-toggle="tab" href="#results-event-text-tab" role="tab" aria-controls="results-event-text-tab" aria-selected="true">{{ trans('general.events') }} <span></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="results-post-tab" data-toggle="tab" href="#results-post-text-tab" role="tab" aria-controls="resultNews-text-tab" aria-selected="false">{{ trans('general.news') }} <span></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="results-press-tab" data-toggle="tab" href="#results-press-text-tab" role="tab" aria-controls="results-press-text-tab" aria-selected="false">{{ trans('general.press') }} <span></span></a>
                </li>
*/
@endphp

            </ul>
        </div>

        <div class="tab-content section-tab" id="searchTabContent">

			@foreach($a_types as $key => $type)
			@include('public.search.panel')
			@endforeach

@php
/*
            <div class="tab-pane fade show active" id="results-event-text-tab" role="tabpanel" aria-labelledby="results-event-tab">
                <div class="filter-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="row media-cont-wrap different-media grey-bord-media" id="event-container">
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="results-post-text-tab" role="tabpanel" aria-labelledby="resultNews-tab">
                <div class="filter-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="row media-cont-wrap different-media grey-bord-media" id="post-container"></div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="results-press-text-tab" role="tabpanel" aria-labelledby="results-press-tab">
                <div class="filter-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="row media-cont-wrap different-media grey-bord-media" id="press-container"></div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
*/
@endphp

        </div>
    </div>
</div>

    @foreach($a_types as $type)
    @if ($type != 'all')
    @include('public.' . $type . '.tpl')
    @endif
    @endforeach

@endsection