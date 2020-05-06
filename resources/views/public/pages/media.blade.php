@section('js')
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
@endsection

@section('script')
<script>
    $(document).ready(() => {
        $('#filters-form').on('submit', (e) => {
            e.preventDefault();

            console.log($(e.target).serialize());

            $.ajax({
                url: '{!! route('api.media.index') !!}',
                type: 'get',
                data: $(e.target).serialize(),
                success: viewEntries
            });
        });

        $('#filters-form').submit();

        $(document).on('click', '.pagination .page-item a', (e) => {
            let elem = $(e.currentTarget);

            e.preventDefault();

            $('#filters-form').find('#offset').val((elem.data('page') - 1) * elem.data('limit'));
            $('#filters-form').submit();
        });

        $(document).on('click', '.pagination .page-item.prev-page-item', (e) => {
            let elem = $(e.currentTarget);

            if(elem.hasClass('disabled')) return;

            $('#filters-form').find('#offset').val((elem.data('current') - 2) * elem.data('limit'));
            $('#filters-form').submit();
            //viewEntries();
        });

        $(document).on('click', '.pagination .page-item.next-page-item', (e) => {
            let elem = $(e.currentTarget);

            if(elem.hasClass('disabled')) return;

            $('#filters-form').find('#offset').val((elem.data('current')) * elem.data('limit'));
            $('#filters-form').submit();
            //viewEntries();
        });

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

        function viewEntries(data){
            let media_tpl = $('#media-tpl').html(),
                route = "{{ route('public.event', ':slug') }}";

            $('#results').empty();

            $.each(data.data, (media) => {

                if( ! media.length) return;

                media.created_at = moment().locale('{!! $app->getLocale() !!}').format('LL');

                $.tmpl(media_tpl, media).appendTo('#media-results');

            });

            viewPagination(data.total, $('#filters-form').find('#offset').val(), $('#filters-form').find('#amount').val());
        }
    });
</script>
@endsection

<div class="filter-content">
    <form action="#" id="filters-form">
        <input type="hidden" name="offset" id="offset" value="0">
        <input type="hidden" name="amount" id="amount" value="20">
        <input type="hidden" name="filters[festivals][]" value="{!! $festival->id !!}">
    </form>
    <div class="row">
        <div class="col-lg-12 col-sm-7 col-12">
            <div class="row media-cont-wrap" id="media-results">
                @foreach($medias as $media)
                    @include('public.partials.media')
                @endforeach
            </div>

            {{--<nav aria-label="Page navigation example">--}}
                {{--<ul class="pagination justify-content-center">--}}
                    {{--<li class="page-item prev-page-item">--}}
                        {{--<a class="page-link" href="#" tabindex="-1">--}}
                            {{--<svg width="32" height="22" viewBox="0 0 32 22" fill="none"--}}
                                 {{--xmlns="http://www.w3.org/2000/svg">--}}
                                {{--<rect width="32" height="22" fill="black" fill-opacity="0"--}}
                                      {{--transform="translate(32) scale(-1 1)"/>--}}
                                {{--<rect width="32" height="22" fill="black" fill-opacity="0"--}}
                                      {{--transform="translate(32) scale(-1 1)"/>--}}
                                {{--<path d="M0.435841 9.94886L9.9585 0.435333C10.5395 -0.145111 11.4818 -0.145111 12.0628 0.435333C12.6439 1.0159 12.6439 1.95702 12.0628 2.53758L5.08016 9.5135L30.5121 9.5135C31.3338 9.5135 32 10.1791 32 11C32 11.8208 31.3338 12.4865 30.5121 12.4865L5.08016 12.4865L12.0625 19.4624C12.6437 20.0429 12.6437 20.9841 12.0625 21.5646C11.7721 21.8547 11.3912 22 11.0104 22C10.6296 22 10.2488 21.8547 9.95826 21.5646L0.435841 12.0511C-0.145279 11.4705 -0.145279 10.5294 0.435841 9.94886Z"--}}
                                      {{--fill="black"/>--}}
                            {{--</svg>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">1</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">2</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">3</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">4</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">...</a></li>--}}
                    {{--<li class="page-item active"><a class="page-link" href="#">134</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">135</a></li>--}}
                    {{--<li class="page-item next-page-item">--}}
                        {{--<a class="page-link" href="#">--}}
                            {{--<svg width="32" height="22" viewBox="0 0 32 22" fill="none"--}}
                                 {{--xmlns="http://www.w3.org/2000/svg">--}}
                                {{--<rect width="32" height="22" fill="black" fill-opacity="0"--}}
                                      {{--transform="translate(0 22) scale(1 -1)"/>--}}
                                {{--<rect width="32" height="22" fill="black" fill-opacity="0"--}}
                                      {{--transform="translate(0 22) scale(1 -1)"/>--}}
                                {{--<path d="M31.5642 12.0511L22.0415 21.5647C21.4605 22.1451 20.5182 22.1451 19.9372 21.5647C19.3561 20.9841 19.3561 20.043 19.9372 19.4624L26.9198 12.4865H1.48792C0.666229 12.4865 0 11.8209 0 11C0 10.1792 0.666229 9.51353 1.48792 9.51353H26.9198L19.9375 2.53761C19.3563 1.95705 19.3563 1.01592 19.9375 0.435362C20.2279 0.145319 20.6088 0 20.9896 0C21.3704 0 21.7512 0.145319 22.0417 0.435362L31.5642 9.94889C32.1453 10.5295 32.1453 11.4706 31.5642 12.0511Z"--}}
                                      {{--fill="black"/>--}}
                            {{--</svg>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</nav>--}}
        </div>

        {{-- <aside class="right-sidebar col-lg-3 col-sm-5 col-12">
            <div class="sidebar-inner filter-wrap">
                <div class="sidebar-item filter-category">
                    <h5 class="sidebar-title">Category</h5>
                    <div class="sidebar-item-content">
                        <div class="row">
                            <div class="col-6">
                                <div class="filter-label">Art<i class="fa fa-times"
                                                                aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="filter-label">Culinary<i class="fa fa-times"
                                                                     aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="filter-label selected">Dance <i class="fa fa-times"
                                                                            aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="filter-label">Film <i class="fa fa-times"
                                                                  aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="filter-label">Focus <i class="fa fa-times"
                                                                   aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="filter-label">Literature <i class="fa fa-times"
                                                                        aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="filter-label">Music <i class="fa fa-times"
                                                                   aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="filter-label">Theater <i class="fa fa-times"
                                                                     aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar-item filter-location">
                    <h5 class="sidebar-title">Event location</h5>
                    <div class="sidebar-item-content">
                        <select name="local_sort" id="local-sort" class="full-width">
                            <option selected>Basel</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="sidebar-item filter-calendar">
                    <h5 class="sidebar-title">calendar</h5>
                    <div class="sidebar-item-content">
                        calendar content
                    </div>
                </div>


                <div class="sidebar-item filter-reset">
                    <a href="#" class="btn btn-primary full-width" id="filter-btn">Filter</a>
                    <div id="filter-reset">
                        Reset filters
                        <i id="remove-sidebar-filters" class="fa fa-times" aria-hidden="true"></i>
                    </div>
                </div>

            </div>
        </aside> --}}
    </div>
</div>

@include('public.media.tpl')

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