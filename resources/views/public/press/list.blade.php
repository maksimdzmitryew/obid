@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper(trans('meta.press') . ' | ' . $festival->name . ' | ' . config('app.name'))!!}</title>
    <meta name="title" content="{!! $festival->slug . ' | ' . trans('meta.press') !!}">
    <meta name="description" content="{!! $festival->slug . ' | ' . trans('meta.press') !!}">
    <meta name="keywords" content="{!! $festival->slug . ',' . trans('meta.press') !!}">
@endsection

@section('css')
    <link rel="stylesheet" href="{!! asset('/admin/js/plugins/pickers/air-datepicker/datepicker.min.css') !!}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/i18n/datepicker.de.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/pagination/pagination.js') !!}"></script>
    {{--<script src="{{ mix('/admin/js/app.js') }}"></script>--}}
@endsection

@section('script')
<script type="text/javascript">
    @include('public.common.data2js')

    let //date_start = '{!! $dates["min"] ?? null !!}',
        //date_end = '{!! $dates["max"] ?? null !!}';
        date_start = '{!! $dates_range->first() ?? null !!}',
        date_end = '{!! $dates_range->last() ?? null !!}';

</script>

<script src="{!! asset('/user/js/general.js') !!}"></script>
@include('public.common.filters')
<script src="{!! asset('/user/js/calendar.js') !!}"></script>
{{--<script src="{!! asset('/user/js/pager_pages.js') !!}"></script>--}}
<script type="text/javascript">

    $(document).ready(() => {
/*
        $('.filters-form__').on('submit', (e) => {

            e.preventDefault();

            let form = $(e.currentTarget);

            $.ajax({
                'url': form.attr('action'),
                'data': form.serialize(),
                'success': (data) => viewEntries,
                'error': (xhr) => {
                }
            });
        });
*/

        viewEntries = function (res, data)
        {

            //let res = getFilterForm(e.currentTarget);
            //res.form.submit();
            let
                //offset = Number(form.find('#offset').val()),
                //amount = Number(form.find('#amount').val()),
                tab = res.form.closest('.tab-pane'),
                navigation_in_tab = tab.find('nav.nav_pagination_wrap'),
                pagination = Pagination(data.qty_filtered, (offset + amount) / amount),
                results = tab.find('.results'),
                html = $.tmpl($('#pagination-tpl').html(), pagination),
                entries = data.data,
                output = '';

            entries.map((item) => {
                /*
                if (typeof entry.image === 'string' && entry.image.length > 0)
                {
                    tmp = entry.image;
                    a_image = {
                                name: '',
                                url: entry.image,
                                small_image_url: entry.image
                            }
                    if (tmp.indexOf('-small.') < 0)
                    {
                        a_image.url = entry.image;
                        a_image.small_image_url = entry.image.replace('.', '-small.');
                    }
                    else
                    {
                        a_image.url = entry.image.replace('-small.', '.');
                        a_image.small_image_url = entry.image;
                    }
                }
                if (typeof entry.image === 'object' && entry.image.length > 0)
                {
                    entry.image = Object.keys(entry.image).length
                        ? entry.image.small_image_url
                        : '/admin/images/no-image-logo.jpg'
                    ;
                }
                */
                item = setCategory(item);
                item = setImage(item, item.type_id);
                output += getReplaceInTpl('press-id-' + item.type_id, item).wrap('<p>').parent().html();
            });

            results.html(output);
            navigation_in_tab.empty();

            if(pagination.pages.length)
                navigation_in_tab.html(html);
        }
/*
        $('.btn-reset-filters__').on('click', (e) => {

            res = getFilterForm(e);

            / *
            let button = $(e.currentTarget),
                form = button.closest('.filters-form'),
                offset = form.find('#offset'),
                date_start = form.find('#date-from'),
                date_end = form.find('#date-to');

                $('#filter-category .tab').each((i, checkbox) => {
                toggleCheckbox($(checkbox), true);
                });

                $('.filter-city #city-id').prop('disabled', true).attr('disabled', 'disabled').val($('.filter-city #cities option').first().prop('selected', 'selected'));
                $('.filter-city #cities').trigger('refresh');

                picker.data('datepicker').clear();
            * /

            res.offset.val(0);
            res.date_start.val(picker.data('date-from'));
            res.date_end.val(picker.data('date-to'));

            form.submit();
        });
*/
        $(document).on('click', '.page-item:not(.disabled)', (e) => {

            let res = getFilterForm(e.currentTarget);
            page = res.button.data('page');

            //let //target = $(e.currentTarget),
                //form = target.closest('.tab-pane').find('.filters-form'),
                //offset = form.find('#offset'),
                //amount = form.find('#amount'),
                //page = target.data('page');

            offset.val(page * amount.val() - amount.val());

            form.submit();
        });


    });
</script>
@endsection

@section('content')
<div class="content press-page">
    <div class="container-fluid">
        <div class="title-box">
            <h1 class="title-block">{{ trans('general.press') }}</h1>
            <ul class="nav nav-tabs" id="pressTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#tab-press-id-all" role="tab"
                       aria-controls="tab-press-id-all" aria-selected="true">{{ trans('general.all') }}</a>
                </li>
                @if($medias->count())
                    <li class="nav-item">
                        <a class="nav-link" id="media-tab" data-toggle="tab" href="#tab-press-id-media" role="tab" aria-controls="tab-press-id-media" aria-selected="false">{{ trans('general.media-about-us') }}</a>
                    </li>
                @endif
                @if($presses_categories->count())
                    @foreach($presses_categories as $type)
                        <li class="nav-item">
                            <a class="nav-link" id="tab-{{ $type->id }}" data-toggle="tab" href="#tab-press-id-{{ $type->id }}" role="tab" aria-controls="tab-press-id-{{ $type->id }}" aria-selected="true">{{ $type->name }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="tab-content section-tab" id="pressTabContent">
            <div class="tab-pane fade show active" id="tab-press-id-all" role="tabpanel" aria-labelledby="all-tab">
                <div class="filter-content">
                    <div class="row">
                        <div class="col-lg-9 col-sm-7 col-12">
                            <div class="row media-cont-wrap different-media grey-bord-media results">

                                @if($medias->count())
                                    @include('public.pages.media')
                                @endif

                                @if($presses->count())
                                    @foreach($presses as $press)
                                        @if(view()->exists("public.partials.press-id-{$press->type->id}"))
                                            @include("public.partials.press-id-{$press->type->id}", ['press' => $press])
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <aside class="right-sidebar col-lg-3 col-sm-5 col-12">
                            <form action="{!! route('api.presses.index') !!}" data-type="all" class="filters-form" id="filters-all">
                                <input type="hidden" name="offset" id="offset" value="0">
                                <input type="hidden" name="amount" id="amount" value="9">
                                <input type="hidden" name="columns[0][data]" id="column" value="published_at">
                                <input type="hidden" name="order[0][column]" id="order-column" value="0">
                                <input type="hidden" name="order[0][dir]" id="order-dir" value="desc">
                                <input type="hidden" name="filters[festivals][]" value="{!! $festival->id !!}">
                                <input type="hidden" name="filters[published]" value="1">
                                <input type="hidden" id="date-from" name="filters[date][from]" value="{!! $dates_range->first() ?? null !!}">
                                <input type="hidden" id="date-to" name="filters[date][to]" value="{!! $dates_range->last() ?? null !!}">
                                <div class="sidebar-inner filter-wrap">

                                    <div class="sidebar-item filter-category">
                                        <h5 class="sidebar-title">{{ trans('general.category') }}</h5>
                                        <div class="sidebar-item-content filter-category" id="filter-category">
                                            <div class="row">
                                              @if($events_categories->count())
                                                  @foreach($events_categories as $category)
                                                  <div class="col-6 tab">
                                                      <input type="hidden" name="filters[categories][]" value="{!! $category->id !!}" @if(!isset($categories[$category->id])) disabled="disabled" @endif>
                                                      <div class="filter-label @isset($categories[$category->id]) selected @endisset">{{ $category->name }}<i class="fa fa-times" aria-hidden="true"></i>
                                                      </div>
                                                  </div>
                                                  @endforeach
                                              @endif
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

                                    <div class="sidebar-item filter-calendar" id="filter-calendar-tab-all">
                                        <div class="sidebar-item-content">
                                            <input type="text" class="form-control date-range" placeholder="Date" style="display: none">
                                        </div>
                                    </div>
                                    <div class="sidebar-item filter-reset">
                                        <button class="btn btn-primary full-width" id="filter-apply-btn">{{ trans('general.filter') }}</button>

                                        <button type="button" class="btn full-width mt-2 btn-reset-filters">
                                            {{ trans('general.reset-filters') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </aside>
                    </div>
                </div>

                <nav aria-label="Page navigation" class="nav_pagination_wrap"></nav>
            </div>

            @if($medias->count())
                <div class="tab-pane fade" id="tab-press-id-media" role="tabpanel" aria-labelledby="tab-media">
                    <div class="filter-content">
                        <div class="row">
                            <div class="col-lg-9 col-sm-7 col-12">
                                <div class="row media-cont-wrap different-media grey-bord-media results">
                                    @include('public.pages.media')
                                </div>
                            </div>

                            <aside class="right-sidebar col-lg-3 col-sm-5 col-12">
                                <form action="{!! route('api.presses.index') !!}" class="filters-form" data-type="media" id="filters-media">
                                    <input type="hidden" name="offset" id="offset" value="0">
                                    <input type="hidden" name="amount" id="amount" value="20">
                                    <input type="hidden" name="columns[0][data]" id="column" value="published_at">
                                    <input type="hidden" name="order[0][column]" id="order-column" value="0">
                                    <input type="hidden" name="order[0][dir]" id="order-dir" value="desc">
                                    <input type="hidden" name="filters[festivals][]" value="{!! $festival->id !!}">
                                    <input type="hidden" id="type" name="filters[type]" value="media">
                                    <input type="hidden" id="date-from" name="filters[date][from]" value="{!! $dates_range->first() ?? null !!}">
                                    <input type="hidden" id="date-to" name="filters[date][to]" value="{!! $dates_range->last() ?? null !!}">
                                    <div class="sidebar-inner filter-wrap">
                                        <div class="sidebar-item filter-calendar" id="filter-calendar-tab-media">
                                            <h5 class="sidebar-title">{{ trans('general.calendar') }}</h5>
                                            <div class="sidebar-item-content">
                                                <input type="text" class="form-control date-range" placeholder="Date" style="display: none">
                                            </div>
                                        </div>
                                        <div class="sidebar-item filter-reset">
                                            <button class="btn btn-primary full-width" id="filter-apply-btn">{{ trans('general.filter') }}</button>

                                            <button type="button" class="btn btn-secondary full-width mt-2 btn-reset-filters">
                                                {{ trans('general.reset-filters') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </aside>
                        </div>
                    </div>

                    <nav aria-label="Page navigation" class="nav_pagination_wrap"></nav>
                </div>
            @endif
            @if($presses_categories->count())
                @foreach($presses_categories as $category)
                    <div class="tab-pane fade" id="tab-press-id-{{ $category->id }}" role="tabpanel" aria-labelledby="tab-press-id-{{ $category->id }}">
                        <div class="filter-content">
                            <div class="row">
                                <div class="col-lg-9 col-sm-7 col-12">
                                    <div class="row media-cont-wrap different-media grey-bord-media results">
                                        @foreach($presses as $press)
                                            @if(view()->exists("public.partials.press-id-{$press->type->id}") && $category->id == $press->type->id)
                                                @include("public.partials.press-id-{$press->type->id}", ['press' => $press])
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <aside class="right-sidebar col-lg-3 col-sm-5 col-12">
                                    <form action="{!! route('api.presses.index') !!}" class="filters-form" data-type="{!! $category->id !!}" id="filters-{!! $category->id !!}">
                                        <input type="hidden" name="offset" id="offset" value="0">
                                        <input type="hidden" name="amount" id="amount" value="20">
                                        <input type="hidden" name="columns[0][data]" id="column" value="published_at">
                                        <input type="hidden" name="order[0][column]" id="order-column" value="0">
                                        <input type="hidden" name="order[0][dir]" id="order-dir" value="desc">
                                        <input type="hidden" name="filters[festivals][]" value="{!! $festival->id !!}">
                                        <input type="hidden" id="type" name="filters[type]" value="{!! $category->id !!}">
                                        <input type="hidden" id="date-from" name="filters[date][from]" value="{!! $dates_range->first() ?? null !!}">
                                        <input type="hidden" id="date-to" name="filters[date][to]" value="{!! $dates_range->last() ?? null !!}">
                                        <div class="sidebar-inner filter-wrap">
                                            <div class="sidebar-item filter-calendar" id="filter-calendar-tab-press-id-{!! $category->id !!}">
                                                <h5 class="sidebar-title">{{ trans('general.calendar') }}</h5>
                                                <div class="sidebar-item-content">
                                                    <input type="text" class="form-control date-range" placeholder="Date" style="display: none">
                                                </div>
                                            </div>
                                            <div class="sidebar-item filter-reset">
                                                <button class="btn btn-primary full-width" id="filter-apply-btn">{{ trans('general.filter') }}</button>

                                                <button type="button" class="btn btn-secondary full-width mt-2 btn-reset-filters">
                                                    {{ trans('general.reset-filters') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </aside>
                            </div>
                        </div>

                        <nav aria-label="Page navigation" class="nav_pagination_wrap"></nav>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div id="pagination-tpl" class="d-none">
    <ul class="pagination justify-content-center">
        <li class="page-item prev-page-item {%if ! prev %}disabled{%/if%}" data-page="${prev}">
            <a class="page-link" tabindex="-1">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"/>
                    <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"/>
                    <path d="M0.435841 9.94886L9.9585 0.435333C10.5395 -0.145111 11.4818 -0.145111 12.0628 0.435333C12.6439 1.0159 12.6439 1.95702 12.0628 2.53758L5.08016 9.5135L30.5121 9.5135C31.3338 9.5135 32 10.1791 32 11C32 11.8208 31.3338 12.4865 30.5121 12.4865L5.08016 12.4865L12.0625 19.4624C12.6437 20.0429 12.6437 20.9841 12.0625 21.5646C11.7721 21.8547 11.3912 22 11.0104 22C10.6296 22 10.2488 21.8547 9.95826 21.5646L0.435841 12.0511C-0.145279 11.4705 -0.145279 10.5294 0.435841 9.94886Z" fill="black"/>
                </svg>
            </a>
        </li>
        {%each(i, page) pages %}
        <li class="page-item {%if page === current %}active{%/if%}" data-page="${page}"><a class="page-link">${page}</a></li>
        {%/each%}
        <li class="page-item next-page-item {%if ! next %}disabled{%/if%}" data-page="${next}">
            <a class="page-link">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"/>
                    <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"/>
                    <path d="M31.5642 12.0511L22.0415 21.5647C21.4605 22.1451 20.5182 22.1451 19.9372 21.5647C19.3561 20.9841 19.3561 20.043 19.9372 19.4624L26.9198 12.4865H1.48792C0.666229 12.4865 0 11.8209 0 11C0 10.1792 0.666229 9.51353 1.48792 9.51353H26.9198L19.9375 2.53761C19.3563 1.95705 19.3563 1.01592 19.9375 0.435362C20.2279 0.145319 20.6088 0 20.9896 0C21.3704 0 21.7512 0.145319 22.0417 0.435362L31.5642 9.94889C32.1453 10.5295 32.1453 11.4706 31.5642 12.0511Z" fill="black"/>
                </svg>
            </a>
        </li>
    </ul>
</div>

<div id="div-tpl-press-id-13" class="d-none">
@include('public.press.photo')
</div>

<div id="div-tpl-press-id-11" class="d-none">
@include('public.press.review')
</div>

<div id="div-tpl-press-id-23" class="d-none">
@include('public.press.video')
</div>

@endsection
