@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper(trans('meta.news') . ' | ' . $festival->name . ' | ' . config('app.name'))!!}</title>
    <meta name="title" content="{!! $festival->slug . ' | ' . trans('meta.news') !!}">
    <meta name="description" content="{!! $festival->slug . ' | ' . trans('meta.news') !!}">
    <meta name="keywords" content="{!! $festival->slug . ',' . trans('meta.news') !!}">
@endsection

@section('js')
    <script src="{!! asset('/admin/js/plugins/ui/moment/moment_locales.min.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/pickers/daterangepicker.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(() => {

            moment.locale('{{ $app->getLocale() }}');
            let tpl = $('#div-tpl-post').html(),
                filter_form = $('#filter-form'),
                container = $('#posts'),
                filters = $('#filter-form .filter'),
                route = '{!! route('api.posts.index') !!}';

            filters.on('click', (e) => {
                let filter = $(e.currentTarget);

                filters.data('selected', false).removeClass('selected').find('input').attr('disabled', 'disabled');

                filter.data('selected', true).addClass('selected').find('input').removeAttr('disabled');

                applyFilters();
            });

            $(document).on('click', '.pagination .page-item a', (e) => {
                let elem = $(e.currentTarget);

                e.preventDefault();

                filter_form.find('#start').val((elem.data('page') - 1) * elem.data('limit'));
                applyFilters();
            });

            $(document).on('click', '.pagination .page-item.prev-page-item', (e) => {
                let elem = $(e.currentTarget);

                if(elem.hasClass('disabled')) return;

                filter_form.find('#start').val((elem.data('current') - 2) * elem.data('limit'));
                applyFilters();
            });

            $(document).on('click', '.pagination .page-item.next-page-item', (e) => {
                let elem = $(e.currentTarget);

                if(elem.hasClass('disabled')) return;

                filter_form.find('#start').val((elem.data('current')) * elem.data('limit'));
                applyFilters();
            });

            function applyFilters(){
                let data = filter_form.serialize();

                getEntries(data, (result) => {
                    viewEntries(result.data, tpl, container);
                    viewPagination(result.recordsFiltered, filter_form.find('#start').val(), filter_form.find('#length').val());
                });
            }
            //applyFilters();

            function getEntries(data, callback){
                $.ajax({
                    'url': route,
                    'data': data,
                    'success': function(data){
                        callback(data);
                    },
                    'error': function(){

                    }
                });
            }

            function viewEntries(data, tpl, container){

                let timeout = 0,
                    delay = 200;

                container.empty();

                data.forEach((entry) => {

                    entry.date = moment(entry.published_at).format('D MMMM YYYY');
                    entry.url = '{!! route('public.festival.post', [$festival->slug, ':slug']) !!}'.replace(':slug', entry.slug);

                    entry.image.url = entry.image.small_image_url ? entry.image.small_image_url : '/admin/images/no-image-logo.jpg';

                    $.tmpl(
                        tpl
                            // TODO refactoring
                            // 1) we need to hide the template's src="${img}" by commenting it output
                            // 2) otherwise there will be 404 not found error in browser logs:
                            // when the page first load into a browser
                            // e.g. GET /poland/$%7Bimage%7D HTTP/1.1 404
                            .replace('<!--', '')
                            .replace('-->', '')
                        , entry).appendTo(container);
                        //.delay(timeout++ * delay / 4).fadeIn(delay / 2);
                });

                let pagination = document.querySelector('#pagination'),
                    filters = document.querySelector('#filter-section'),
                    title = document.querySelector('.block-title'),
                    html = document.querySelector('html');

                    setTimeout(() => {
                        //html.scrollTop = pagination.offsetTop + pagination.offsetHeight * 2 - window.innerHeight;
                    }, timeout * delay / 4);
            }

            function viewPagination(total, start, limit){

                let container = $('.pagination'),
                    pages = Math.ceil(total / limit),
                    current = start / limit + 1,
                    arrow_left = $('#arrow-left').tmpl({
                        total: total,
                        limit: limit,
                        current: current
                    }),
                    arrow_right = $('#arrow-right').tmpl({
                        total: total,
                        limit: limit,
                        current: current
                    });

                container.empty();

                if(pages < 2) return;

                container.append(arrow_left.toggleClass('disabled', current <= 1));

                for(let page = (current - 2) < 1 ? 1 : (current - 2); page <= pages && (current + 2) >= page; page++){

                    container.append($(page === current ? '#active-page' : '#page').tmpl({
                        total: total,
                        start: start,
                        limit: limit,
                        page: page,
                        current: current
                    }));

                }

                container.append(arrow_right.toggleClass('disabled', current >= pages));
            }
        });
    </script>
@endsection

@section('content')
<div class="content news-list-page">
    <div class="container-fluid">
        <h1 class="block-title">{{ trans('general.news') }}</h1>
    </div>
    <div class="filter-section" id="filter-section">
        <div class="container-fluid">
            <form action="#" id="filter-form">
                <input type="hidden" name="start" id="start" value="0">
                <input type="hidden" name="length" id="length" value="20">
                <input type="hidden" name="columns[0][data]" id="columns" value="published_at">
                <input type="hidden" name="order[0][column]" id="order" value="0">
                <input type="hidden" name="order[0][dir]" id="direction" value="desc">
                <input type="hidden" name="filters[festivals][]" value="{!! $festival->id !!}">
                <input type="hidden" name="filters[published]" value="1">
                <div class="row">
                    <div class="col-xl col-sm-3 col-6 filter {!! ! $categories->contains($current_category) ? 'selected' : '' !!}" id="all">
                        <div class="filter-label">{{ trans('general.all') }}</div>
                    </div>
                     @foreach($categories as $category)
                        <div class="col-xl col-sm-3 col-6 filter {!! $current_category == $category->id ? 'selected' : '' !!}" data-category-id="{!! $category->id !!}">
                            <input type="hidden" name="filters[categories][]" {!! $current_category == $category->id ? '' : 'disabled="disabled"'!!} value="{!! $category->id !!}"/>
                            <div class="filter-label">{{ $category->name }}</div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>

    <div class="news-block">
        <div class="container-fluid">
            <div class="row" id="posts">
                @foreach($news as $post)
                    @include('public.partials.post', ['festival' => $festival])
                @endforeach
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>
        </div>
    </div>
</div>

@include('public.post.tpl')

<div id="arrow-left" class="d-none">
    <li class="page-item prev-page-item" data-current="${current}" data-total="${total}" data-limit="${limit}">
        <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"></rect>
            <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"></rect>
            <path d="M0.435841 9.94886L9.9585 0.435333C10.5395 -0.145111 11.4818 -0.145111 12.0628 0.435333C12.6439 1.0159 12.6439 1.95702 12.0628 2.53758L5.08016 9.5135L30.5121 9.5135C31.3338 9.5135 32 10.1791 32 11C32 11.8208 31.3338 12.4865 30.5121 12.4865L5.08016 12.4865L12.0625 19.4624C12.6437 20.0429 12.6437 20.9841 12.0625 21.5646C11.7721 21.8547 11.3912 22 11.0104 22C10.6296 22 10.2488 21.8547 9.95826 21.5646L0.435841 12.0511C-0.145279 11.4705 -0.145279 10.5294 0.435841 9.94886Z" fill="black"></path>
        </svg>
    </li>
</div>
<div id="arrow-right" class="d-none">
    <li class="page-item next-page-item" data-current="${current}" data-total="${total}" data-limit="${limit}">
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
        <a class="page-link" href="#" data-page="${page}" data-total="${total}" data-start="${start}" data-limit="${limit}">${page}</a>
    </li>
</div>
<div id="active-page" class="d-none">
    <li class="page-item active">
        <span class="page-link">${page}</span>
    </li>
</div>


@endsection