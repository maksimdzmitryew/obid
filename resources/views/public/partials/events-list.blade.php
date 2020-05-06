@section('script')
<script type="text/javascript">
    @include('public.common.data2js')

    let /*
        date_start = '{ !! $dates->first() ?? null !! }',
        date_end = '{ !! $dates->last() ?? null !! }';
        */
        //date_start = '{ ! ! $holding_dates["min"] ?? null !!}',
        //date_end = '{ ! ! $holding_dates["max"] ?? null !!}',
        date_start = '{!! $dates_range->first() ?? null !!}',
        date_end = '{!! $dates_range->last() ?? null !!}';
        route = "{{-- route('public.festival.event', [$festival->slug, ':event_slug']) --}}";
</script>

<script src="{!! asset('/user/js/general.js') !!}"></script>
@include('public.common.filters')
<script src="{!! asset('/user/js/calendar.js') !!}"></script>
<script src="{!! asset('/user/js/bookmark.js') !!}"></script>
<script src="{!! asset('/user/js/pager_loadmore.js') !!}"></script>
<script type="text/javascript">
    $(document).ready(() => {

        viewEntries = function (res, data)
        {
            // res variable is not used here
            // it is needed for compatibility with other use cases
            let program_line_tpl = $('#program-line-tpl').html();

            if (!b_load_more)
            {
                $('#results').empty();
            }


            if( ! data.records_total){
                $('<h3 class="text-center my-5">').html('{!! trans('general.events-not-found') !!}').appendTo('#results');
                return false;
            }

            if (function_exists('viewPagination'))
            {
                viewPagination(data.records_total, $('#filters-form').find('#offset').val(), $('#filters-form').find('#amount').val());
            }
            else if (function_exists('viewLoadMore'))
            {
                viewLoadMore(data.records_total, $('#filters-form').find('#offset').val(), $('#filters-form').find('#amount').val());
            }
            b_load_more = false;

            $.each(data.data, (date, events) => {
                $.tmpl(
                    program_line_tpl
                    // 1) we need to hide the template's src="${img}" by commenting it output
                    // 2) otherwise there will be 404 not found error in browser logs:
                    // when the page first load into a browser
                    // e.g. GET /poland/$%7Bimage%7D HTTP/1.1 404
                    .replace('<!--', '')
                    .replace('-->', '')
                    ,
                    {
                        date: date,
                        events: events.map(event => {
                            return {
                                id: event.id,
                                is_favorite: event.is_favorited,
                                title: event.title,
                                description: event.description,
                                image: event.image.url ? event.image : {
                                    name: 'no-mage',
                                    url: '/admin/images/no-image-logo.jpg'
                                },
                                category: event.category,
                                route: route.replace(':event_slug', event.slug),
                                directors: event.directors.map(el => el.name).join(', '),
                                holdings: event.holdings.map(holding => {
                                    return {
                                        time: (moment(holding.date_from).format('DDMMYY') == moment(holding.date_to).format('DDMMYY')
                                                ? moment(holding.date_from).format('HH:mm')
                                                	+ (
														moment(holding.date_from).format('HHmm') == moment(holding.date_to).format('HHmm')
														?
														''
														:
														'&nbsp;&mdash;&nbsp;' +
														moment(holding.date_to).format('HH:mm')
                                                	)
                                                 	+ ' {{ trans('general.time-after') }}'
                                                : ''
                                            ),
                                        date: (moment(holding.date_from).format('DDMMYY') == moment(holding.date_to).format('DDMMYY')
                                                ? moment(holding.date_from).format('DD{{ trans('general.date-split') }}MM{{ trans('general.date-after') }}')
                                                :
                                                moment(holding.date_from).format('DD{{ trans('general.date-split') }}MM{{ trans('general.date-after') }}')
                                                + '&nbsp;&mdash;&nbsp;' +
                                                moment(holding.date_to).format('DD{{ trans('general.date-split') }}MM{{ trans('general.date-after') }}')
                                            ),
                                        city: holding.city.name + ', ' + holding.place.name,
                                    }
                                })
                            }
                        })
                    })
                    .appendTo('#results');
            });
            $(window).trigger('resize');
        }
    });
</script>
@endsection

<div class="filter-content bg-grey section-line">
    <div class="container-fluid">
        <div class="row">
            {{--<div class="col-lg-9 col-sm-7 col-12 vertical-event">--}}
                {{--<div id="results">--}}
                    {{-- 06/02/2019 отображение разных фестивалей --}}
                    {{--@if ($festival->active)--}}
                        {{--@if($closest_events->count())--}}
                            {{--@foreach($closest_events as $date => $events)--}}
                                {{--<div class="program-line">--}}
                                    {{--<div class="block-title">{{ $date }}</div>--}}
                                    {{--<div class="events" id="events">--}}
                                        {{--@foreach($events as $event)--}}
                                            {{--@include('public.partials.event')--}}
                                        {{--@endforeach--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                        {{--@else--}}
                            {{--<h3 class="text-center my-5">{!! trans('general.events-not-found') !!}</h3>--}}
                        {{--@endif--}}
                    {{--@else--}}
                        {{--@if($expired_events->count())--}}
                            {{--@foreach($expired_events as $date => $events)--}}
                                {{--<div class="program-line">--}}
                                    {{--<div class="block-title">--}}{{-- $date --}}{{--</div>--}}
                                    {{--<div class="events" id="events">--}}
                                        {{--@foreach($expired_events as $event)--}}
                                            {{--@php(dump($event))--}}
                                            {{--@include('public.partials.event')--}}
                                        {{--@endforeach--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<nav class="pagination-wrap" aria-label="Page navigation example pagination-wrap"></nav>--}}
                {{--@if($promoting_events->count() && $festival->active)--}}
                    {{--<div class="block-title">{{ trans('general.more-to-see') }}</div>--}}
                    {{--@foreach($promoting_events as $event)--}}
                        {{--<div class="program-line">--}}
                            {{--@include('public.partials.event')--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                {{--@endif--}}
            {{--</div>--}}



            <div class="col-lg-9 col-sm-7 col-12 vertical-event">
                <div id="results">
                    @if($events_list->count())
                        @foreach($events_list as $date => $events)
                            <div class="program-line">
                                <div class="block-title">{{ $date }}</div>
                                <div class="events" id="events">
                                    @foreach($events as $event)
                                        @include('public.partials.event')
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3 class="text-center my-5">{!! trans('general.events-not-found') !!}</h3>
                    @endif
                </div>

                <nav aria-label="Page navigation" class="nav_pagination_wrap"></nav>

                @if($promotion && $promoting_events->count() && $festival->active)
                    <div class="block-title">{{ trans('general.more-to-see') }}</div>
                    @foreach($promoting_events as $event)
                        <div class="program-line">
                            @include('public.partials.event')
                        </div>
                    @endforeach
                @endif
            </div>

            {{--<div class="col-lg-9 col-sm-7 col-12 vertical-event">--}}
                {{--<div class="block-title">{{ trans('general.more-to-see') }}</div>--}}
                {{--<div class="row">--}}
                    {{--@if($promoting_events->count())--}}
                        {{--@foreach($promoting_events as $event)--}}
                            {{--<div class="program-line col-lg-9 col-sm-12">--}}
                                {{--@include('public.partials.event')--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}

            <aside class="right-sidebar col-lg-3 col-sm-5 col-12">
                <form action="{{-- {!! route('api.events.program') !!} --}}" class="filters-form" id="filters-form">
                    <input type="hidden" name="offset" id="offset" value="0">
                    <input type="hidden" name="amount" id="amount" value="10">
                    <input type="hidden" name="filters[festivals][]" value="{!! $festival->id !!}">
                    <div class="sidebar-inner filter-wrap">
                        <div class="sidebar-item filter-category" id="filter-category">
                            <h5 class="sidebar-title">{{ trans('general.category') }}</h5>
                            <div class="sidebar-item-content">
                                <div class="row">
                                    @foreach($events_categories as $event_category)
                                        <div class="col-6 tab">
                                            <input type="hidden" name="filters[categories][]" value="{!! $event_category->id !!}"  {!! ! $categories->contains($event_category->id) ? 'disabled="disabled"' : ''!!}>
                                            <div class="filter-label {!! $categories->contains($event_category->id) ? 'selected' : ''!!}">
                                                {{ $event_category->name }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-item filter-city" id="filter-city">
                            <h5 class="sidebar-title">{{ trans('general.event-location') }}</h5>
                            <div class="sidebar-item-content">
                                <input type="hidden" name="filters[cities][]" id="city-id" disabled="disabled">
                                <select class="full-width" id="cities">
                                    <option value="">{{ trans('general.select-city') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{!! $city->id !!}">{{ $city->translate($app->getLocale())->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sidebar-item filter-calendar" id="filter-calendar">
                            <!--h5 class="sidebar-title">{{ trans('general.calendar') }}</h5-->
                            <div class="sidebar-item-content">
                                <input type="hidden" id="date-from" name="filters[holdings][from]" value="{!! $dates_range->first() ?? null !!}">
                                <input type="hidden" id="date-to" name="filters[holdings][to]" value="{!! $dates_range->last() ?? null !!}">
                                <input type="text" class="form-control date-range" placeholder="Date" style="display: none">
                            </div>
                        </div>
                        <div class="sidebar-item filter-reset">
                            <button class="btn btn-primary full-width apply-btn" id="filter-apply-btn">
                                {{ trans('general.filter') }}
                            </button>

                            <button type="button" class="btn btn-secondary full-width mt-2 btn-reset-filters" id="filter-reset-btn">
                                {{ trans('general.reset-filters') }}
                            </button>
                        </div>
                    </div>
                </form>
            </aside>
        </div>
    </div>
</div>

<div id="program-line-tpl" class="d-none">
    <div class="program-line">
        <div class="block-title">${date}</div>
        <div class="events">
            {%each(i, event) events %}
            <div class="event-item">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-4 col-12">
                        <div class="img-wrap">
                            {{--@auth--}}
                            <div class="bookmark {%if is_favorite %}added{%/if%}" data-event-id="${event.id}">
                                <svg class="mark_icon" width="25" height="37" viewBox="0 0 25 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 0V34.2246C1 35.0039 1.85185 35.4837 2.51829 35.0799L12.0077 29.3289C12.339 29.1281 12.7563 29.1367 13.079 29.3509L21.5433 34.9692C22.208 35.4104 23.0963 34.9338 23.0963 34.136V0" stroke="white" stroke-width="2"/>
                                </svg>
                                <span class="mark-plus">+</span>
                            </div>
                            {{--@endauth--}}
                            <a href="${event.route}"><!--<img src="${event.image.url}" alt="${event.image.name}">--></a>
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
                                <div class="time">${holding.time}</div>
                                <div class="date">${holding.date}</div>
                                <div class="name">${holding.city}</div>
                            </div>
                        </div>
                        {%/each%}
                    </div>
                </div>
            </div>
            {%/each%}
        </div>
    </div>
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
<div id="loadmoreitems" class="d-none">
    <div class="box">
        <a class="btn btn-primary full-width loadmoreitems-btn" data-current="${current}" data-total="${records_total}" data-limit="${limit}">{{ trans('general.load-more-items') }}</a>
    </div>
</div>
