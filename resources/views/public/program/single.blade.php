@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper($event->title . ' | ' . trans('meta.program') . ' | ' . $festival->name . ' | ' . config('app.name'))!!}</title>
    <meta name="title" content="{!! $event->meta_title !!}">
    <meta name="description" content="{!! $event->meta_description !!}">
    <meta name="keywords" content="{!! $event->meta_keywords !!}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{!! $event->title !!}">
    <meta property="og:description" content="{!! $event->description !!}">
    <meta property="og:image" content="{!! $event->image->url !!}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    {{--<script src="{{ mix('/admin/js/app.js') }}"></script>--}}
@endsection

@section('script')
<script async defer src="https://apis.google.com/js/api.js" id="gapi"></script>
<script>
    $(document).ready(() => {

        let auth = Boolean('{!! auth()->check() !!}'),
            login_route = '{!! route('login') !!}';

        $(document).on('click', '.bookmark',  (e) => {
            let target = $(e.currentTarget),
                favorite = '{!! route('public.event.favorite', ':event') !!}',
                unfavorite = '{!! route('public.event.unfavorite', ':event') !!}',
                text_add = '{!! trans('general.save-to-my-festival') !!}',
                text_remove = '{!! trans('general.remove-from-my-festival') !!}';

            if( ! auth) window.location.href = login_route;

            $.ajax({
                type: 'post',
                url: target.hasClass('added') ? unfavorite.replace(':event', target.data('event-id')) : favorite.replace(':event', target.data('event-id')),
                success: (data) => {
                    target.toggleClass('added').find('span').text(target.hasClass('added') ? text_remove : text_add);

                    swal({
                        title: 'Success',
                        text: data.message,
                        type: 'success',
                        confirmButtonText: 'Ok',
                        confirmButtonClass: 'btn btn-primary',
                    });
                }
            });
        });
    });


    var CLIENT_ID = '843531194676-u2qn0mf0tc1sslkr7lerua6hvkfpaodk.apps.googleusercontent.com';
    var API_KEY = 'AIzaSyDTvOc0S22s4MfsC_MvsrSyy1olgcbY_7g';

    var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];

    var SCOPES = "https://www.googleapis.com/auth/calendar";

    function handleClientLoad() {
        gapi.load('client:auth2', initClient);
    }

    function generateId(length = 26){
        let str = '',
            chars = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','0','1','2','3','4','5','6','7','8','9'];

        for(let i = 0; i < length; i++){
            str = str.concat(chars[ Math.floor(Math.random() * chars.length) ]);
        }

        return str;
    }

    function initClient() {
        gapi.client.init({
            apiKey: API_KEY,
            clientId: CLIENT_ID,
            discoveryDocs: DISCOVERY_DOCS,
            scope: SCOPES
        }).then(function () {

            $('#sync-btn').on('click', (e) => {

                let is_auth = gapi.auth2.getAuthInstance().isSignedIn.get();

                if( ! is_auth){
                    gapi.auth2.getAuthInstance().signIn();
                }else{

                    gapi.client.calendar.events.list({
                        'calendarId': 'primary',
                        'timeMin': (new Date()).toISOString(),
                        'showDeleted': false,
                        'singleEvents': true,
                        'maxResults': 10,
                        'orderBy': 'startTime'
                    }).then(function(response) {

                        let events = response.result.items,
                            event_ids = events.map(event => Number(event.id.substr(10))),
                            event = $('#event'),
                            holding = $('.holding').first();

                        if(event_ids.indexOf(Number(holding.data('id'))) === -1){

                            addEvent({
                                'id': generateId(10).concat(holding.data('id')),
                                'title': event.data('title'),
                                'description': event.data('description'),
                                'city': holding.data('city'),
                                'date_from': moment(holding.data('dateFrom')).format(),
                                'date_to': moment(holding.data('dateTo')).format(),
                                'timezone': holding.data('timezone'),
                            });

                        }

                        swal({
                            title: 'Success',
                            text: 'Events has been synchronized!',
                            type: 'success',
                            confirmButtonText: 'Ok',
                            confirmButtonClass: 'btn btn-primary',
                        });

                    });
                }
            });

        }, function(error) {
            console.log(error);
            //appendPre(JSON.stringify(error, null, 2));
        });
    }

    function addEvent(event){

        gapi.client.calendar.events.insert({
            'calendarId': 'primary',
            'resource': {
                'id': event.id,
                'summary': event.title,
                'location': event.city,
                'description': event.description,
                'start': {
                    'dateTime': event.date_from,
                    'timeZone': event.timezone
                },
                'end': {
                    'dateTime': event.date_to,
                    'timeZone': event.timezone
                },
            }
        }).then(function(response) {

        });
    }

    document.getElementById('gapi').addEventListener('load', handleClientLoad);
</script>
@endsection
@section('content')
    <style>
        .flag.added #l1{
            stroke: none;
        }
        .flag.added path{
            fill: #FFC531;
            stroke: #FFC531;
        }
    </style>
    <div class="content event-page">
        <div class="container-fluid">
            <h1 class="block-title">{{ $event->title }}</h1>
            <div class="single-event-wrap" id="event"
                 data-id="{!! $event->id !!}"
                 data-title="{!! $event->title !!}"
                 data-description="{!! $event->description !!}"
            >
                <div class="row">
                    <div class="col-lg-9 col-sm-8 col-12 single-content">
                        <div class="inner">
                            <div class="short-single">{{ $event->description }}</div>
                            <div class="btns-wrap d-flex four-btns">

                                <div class="btn-item @if(empty($event->facebook)) col-lg-4 @else col-lg-3 @endif col-md-6 col-12 p-0">
                                    <button href="#" class="btn grey-btn save-btn w-100 flag bookmark {!! $event->isFavorited() ? 'added' : '' !!}" data-event-id="{!! $event->id !!}">
                                        <svg width="24" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="22" height="26" fill="black" fill-opacity="0" transform="translate(1 1)"/>
                                            <path d="M23 25.1315V1H1V25.2206C1 26.0008 1.85355 26.4804 2.51995 26.0748L11.9556 20.3314C12.2877 20.1292 12.7068 20.1379 13.0303 20.3535L21.4453 25.9635C22.1099 26.4066 23 25.9302 23 25.1315Z" stroke="#0E293C" stroke-width="2"/>
                                            <rect width="10" height="10" fill="black" fill-opacity="0" transform="translate(7 6)"/>
                                            <line x1="12" y1="16" x2="12" y2="6" stroke="#0E293C" stroke-width="2" id="l1"/>
                                            <line x1="7" y1="11" x2="17" y2="11" stroke="#0E293C" stroke-width="2" id="l2"/>
                                        </svg>
                                        <span class="text">{{ $event->isFavorited() ? trans('general.remove-from-my-festival') : trans('general.save-to-my-festival') }}</span>
                                    </button>
                                </div>

                                <div class="btn-item @if(empty($event->facebook)) col-lg-4 @else col-lg-3 @endif col-md-6 col-12 p-0">
                                    <div class="share-btn-multi">
                                        <div class="btn grey-btn share-btn">
                                            <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="26" height="27" fill="black" fill-opacity="0" transform="translate(0 27) scale(1 -1)"></rect>
                                                <path d="M20.701 10.1884C19.063 10.1884 17.5966 9.47017 16.6236 8.34437L10.2944 11.7983C10.4913 12.3307 10.5994 12.9031 10.5994 13.4996C10.5994 14.096 10.4913 14.6684 10.2944 15.2008L16.6232 18.6555C17.596 17.5294 19.0627 16.8109 20.7008 16.8109C23.6227 16.8109 25.9999 19.0966 25.9999 21.9062C26.0001 24.715 23.6229 27 20.701 27C17.7787 27 15.4013 24.715 15.4013 21.9063C15.4013 21.3098 15.5094 20.7373 15.7063 20.2048L9.37722 16.7499C8.40436 17.8755 6.93809 18.5935 5.30046 18.5935C2.37781 18.5935 4.05591e-08 16.3085 4.05591e-08 13.4997C4.05591e-08 10.691 2.37781 8.40605 5.30046 8.40605C6.93809 8.40605 8.40424 9.12402 9.3771 10.2495L15.7063 6.79542C15.5094 6.26294 15.4012 5.6903 15.4012 5.09365C15.4012 2.28498 17.7786 0 20.7009 0C23.6228 0 26 2.2851 26 5.09365C26.0001 7.9028 23.6229 10.1884 20.701 10.1884ZM20.701 25.2175C22.6004 25.2175 24.1456 23.7322 24.1456 21.9063C24.1456 20.0796 22.6004 18.5935 20.701 18.5935C18.8013 18.5935 17.2558 20.0796 17.2558 21.9063C17.2558 23.7322 18.8013 25.2175 20.701 25.2175ZM5.30059 10.1884C3.40049 10.1884 1.8546 11.6739 1.8546 13.4996C1.8546 15.3255 3.40049 16.8109 5.30059 16.8109C7.19994 16.8109 8.74509 15.3255 8.74509 13.4996C8.74509 11.6739 7.19982 10.1884 5.30059 10.1884ZM20.701 1.78233C18.8013 1.78233 17.2558 3.26783 17.2558 5.09354C17.2558 6.91996 18.8013 8.40593 20.701 8.40593C22.6004 8.40593 24.1456 6.91996 24.1456 5.09354C24.1456 3.26783 22.6004 1.78233 20.701 1.78233Z" fill="#0E293C"></path>
                                            </svg>
                                            <span class="text">{{ trans('general.share-this') }}</span>
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </div>
                                        <div class="share-drop">
                                            <div data-network="twitter" data-title="{!! $event->title !!}" data-description="{!! $event->description !!}" data-image="{!! url()->to('/') . $event->image->small_image_url !!}" class="st-custom-button some-new-classes-here">
                                                <i class="fa fa-twitter"></i>
                                            </div>
                                            <div data-network="facebook" data-title="{!! $event->title !!}" data-description="{!! $event->description !!}" data-image="{!! url()->to('/') . $event->image->small_image_url !!}" class="st-custom-button some-new-classes-here">
                                                <i class="fa fa-facebook-f"></i>
                                                {{--<span>Facebook</span>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($event->facebook))
                                <div class="btn-item col-lg-3 col-md-6 col-12 p-0">
                                    <a href="https://facebook.com/{!! $event->facebook !!}" target="_blank" class="btn grey-btn fb-join-btn">
                                        <svg width="13" height="25" viewBox="0 0 13 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.31452 24V12.4987H11.5687L12 8.53523H8.31452L8.32005 6.55149C8.32005 5.51777 8.42072 4.96388 9.94255 4.96388H11.977V1H8.72228C4.81288 1 3.43687 2.92269 3.43687 6.15605V8.53567H1V12.4991H3.43687V24H8.31452Z" stroke="#0E293C" stroke-width="1.5"/>
                                        </svg>
                                        <span class="text">{{ trans('general.join-fb-event') }}</span>
                                    </a>
                                </div>
                                @endif
                                <div class="btn-item @if(empty($event->facebook)) col-lg-4 @else col-lg-3 @endif col-md-6 col-12 p-0">
                                    <a href="javascript:void(0)" class="btn grey-btn fb-join-btn" id="sync-btn">
                                        <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="24" height="23" fill="black" fill-opacity="0"/>
                                            <path d="M2.51917 0.715723V3.50259H2.37817C1.06688 3.50259 0 4.58597 0 5.91783V6.04552L0.0187407 6.17173L0.845896 11.7326V11.7481V20.5848C0.845896 21.9166 1.91266 23 3.22407 23H20.7759C22.0872 23 23.1541 21.9165 23.1541 20.5848V11.7481V11.7326L23.9813 6.17173L24 6.04552V5.91783C24 4.58597 22.9331 3.50259 21.6218 3.50259H21.4808V0.715723C21.4808 0.320529 21.1652 0 20.7759 0H3.22407C2.83486 0 2.51917 0.320529 2.51917 0.715723ZM4.19245 1.69952H19.8074V3.50259H4.19245V1.69952ZM21.6218 5.2021C22.0111 5.2021 22.3267 5.52263 22.3267 5.91783L21.4807 11.6049V11.7481V16.2891V20.5848C21.4807 20.98 21.1651 21.3005 20.7758 21.3005H3.22407C2.83475 21.3005 2.51917 20.98 2.51917 20.5848V16.2891V11.7481V11.6049L1.67327 5.91783C1.67327 5.52263 1.98897 5.2021 2.37817 5.2021H21.6218ZM6.20127 15.3682L6.20216 15.3346L6.27545 15.1113H7.78575V15.3379C7.78575 15.7064 7.91292 16.0079 8.1745 16.2598C8.43944 16.5148 8.77633 16.6388 9.20435 16.6388C9.62256 16.6388 9.93936 16.5143 10.1731 16.2581C10.4112 15.9969 10.527 15.6601 10.527 15.2285C10.527 14.7347 10.4193 14.3669 10.2065 14.1356C9.99793 13.9088 9.65055 13.7937 9.17434 13.7937H7.98063V12.4094H9.17434C9.62969 12.4094 9.94795 12.3028 10.1203 12.0925C10.3027 11.8698 10.3952 11.5428 10.3952 11.1207C10.3952 10.728 10.2968 10.4237 10.0943 10.1903C9.8992 9.96562 9.60805 9.8564 9.20424 9.8564C8.80432 9.8564 8.48506 9.9765 8.22827 10.2234C7.97471 10.4669 7.85156 10.7643 7.85156 11.1328V11.3595H6.36424L6.26262 11.1531L6.26117 11.1034C6.23908 10.3715 6.51395 9.73925 7.07795 9.22395C7.63314 8.71693 8.34852 8.45996 9.20435 8.45996C10.0678 8.45996 10.7588 8.68906 11.2581 9.14113C11.7649 9.60011 12.0218 10.2743 12.0218 11.1452C12.0218 11.6008 11.9022 12.0225 11.6663 12.3988C11.5049 12.6561 11.2981 12.8762 11.0486 13.0562C11.3486 13.2395 11.5916 13.4764 11.7736 13.7642C12.0257 14.1629 12.1536 14.6473 12.1536 15.2042C12.1536 16.079 11.8736 16.7776 11.3215 17.2806C10.7763 17.7774 10.064 18.0293 9.20424 18.0293C8.41401 18.0293 7.70788 17.7891 7.1055 17.3153C6.48349 16.8266 6.17918 16.1715 6.20127 15.3682ZM15.4582 10.1505L13.5589 10.1688V8.81108L17.0907 8.43492V17.9015H15.4582V10.1505Z" fill="black"/>
                                        </svg>
                                        <span class="text">{{ trans('general.google_calendar') }}</span>
                                    </a>
                                </div>
                            </div>

                            @include('modules.image.user_gallery', ['item' => $event])

                            <ul class="nav nav-tabs" id="eventsTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="event-tab" data-toggle="tab" href="#event-text-tab" role="tab" aria-controls="event-text-tab" aria-selected="true">{{ trans('general.event') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="artist-tab" data-toggle="tab" href="#artist-text-tab" role="tab" aria-controls="artist-text-tab" aria-selected="false">{{ trans('general.artists') }}</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="eventsTabContent">
                                <div class="tab-pane fade show active" id="event-text-tab" role="tabpanel" aria-labelledby="event-tab">
                                    {!! $event->body !!}
                                </div>

                                <div class="tab-pane fade" id="artist-text-tab" role="tabpanel" aria-labelledby="artist-tab">

                                @if( ! empty($event->vocations))
                                    @foreach($event->vocations()->orderBy('event_vocation.order', 'asc')->get() as $vocation)
                                        <div class="line-item">
                                            <div class="post">
                                                {!!$vocation->name!!}
                                            </div>
                                            <div class="name-box">
                                                @if($event->eventVocations->where('vocation_id','=',$vocation->id)->first()->artists)
                                                @foreach($event->eventVocations->where('vocation_id','=',$vocation->id)->first()->artists()->orderBy('artist_event_vocation.order', 'asc')->get() as $artist)
												<div class="name">
													@if ($artist->url)
													<a target="_blank" class="reverse_underline" href="{!! $artist->url !!}">
													@endif
													{!! $artist->name !!}
													@if ($artist->url)
													<span class="arr"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
													</a>
													@endif
												</div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                </div>
                            </div>
                        </div>

                    </div>

                    <aside class="right-sidebar col-lg-3 col-sm-4 col-12">
                        <div class="sidebar-inner event-side fixed-width-side">
                            <div class="side-line info-block">
                                <div class="label-wrap">
                                    <div class="label">{{ $event->category->name }}</div>
                                </div>
                                <div class="link-wrap">
                                    <a href="{{ route('public.festival.program', ['festival_slug' => $festival->slug, 'categories[]' => $event->category->id]) }}" class="see-all">
                                        {{ trans('general.see-all-category-events', ['category' => $event->category->name]) }}
                                    </a>
                                </div>

                                <div class="name-wrap">
                                    {{ ($event->directors->map->name->implode(', ')) }}
                                </div>
                            </div>

                            <div class="side-line">
                                @foreach($cities_event_holdings as $city_event_holdings)
                                    <div class="side-cont">
                                        <div class="side-title">{{ $city_event_holdings->first()->city->name }}</div>
                                        @foreach($city_event_holdings as $holding)
                                            <div class="info-box holding"
                                                 data-id="{!! $holding->id !!}"
                                                 data-date-from="{!! $holding->date_from !!}"
                                                 data-date-to="{!! $holding->date_to !!}"
                                                 data-city="{!! $holding->city->name !!}"
                                                 data-timezone="{!! $holding->city->timezone !!}"
                                                 data-place="{!! $holding->place->name !!}"
                                            >
                                                @include('public.partials.date_format', ['from' => $holding->date_from, 'to' => $holding->date_to])

                                                <div class="name">{{ $holding->place->name }}</div></a>

                                                @if ($holding->ticket_url) <a target="_blank" href="{{ $holding->ticket_url }}" class="buy-btn"> @php /*@else <div class="nobuy-btn not-allowed"> @endif*/ @endphp
                                                    <span class="text">{{ trans('general.buy-ticket') }}</span>
                                                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="14" height="13" fill="black" fill-opacity="0" transform="translate(14) scale(-1 1)"/>
                                                        <rect width="14" height="13" fill="black" fill-opacity="0" transform="translate(14) scale(-1 1)"/>
                                                        <rect width="14" height="13" fill="black" fill-opacity="0" transform="translate(14) scale(-1 1)"/>
                                                        <path d="M10.1673 13C9.54565 13 9.04169 12.5055 9.04169 11.8955C9.04169 11.2855 9.54565 10.791 10.1673 10.791C10.789 10.791 11.293 11.2855 11.293 11.8955C11.293 12.5055 10.789 13 10.1673 13Z" fill="#0E293C"/>
                                                        <path d="M6.49399 10.791C5.87183 10.791 5.36835 11.2856 5.36835 11.8955C5.36835 12.5058 5.87183 13 6.49399 13C7.11559 13 7.61963 12.5058 7.61963 11.8955C7.61977 11.2856 7.11559 10.791 6.49399 10.791Z" fill="#0E293C"/>
                                                        <path d="M0.046917 0.394345C0.17928 0.0718465 0.553329 -0.0848816 0.884096 0.0465015L3.23786 0.98002C3.29231 1.00153 3.33909 1.03112 3.38405 1.06441C3.5502 1.14702 3.6813 1.29553 3.72333 1.4887L4.06066 3.15298C4.10841 3.14736 4.15379 3.13805 4.2021 3.13805H12.7857C13.4556 3.13805 14 3.70441 14 4.39968V4.53052L12.435 9.04344C12.2324 9.71953 11.8002 10.1537 11.1802 10.1537H5.17485C4.59388 10.1537 4.11022 9.72885 3.98987 9.16441C3.96976 9.12166 3.95078 9.07673 3.9403 9.02905L2.32612 1.97807L0.402118 1.21484C0.0727472 1.08496 -0.0858641 0.71698 0.046917 0.394345ZM4.71046 6.36029L5.24885 8.85355V8.89287H11.0121L11.1095 8.76218L12.6564 4.40064H4.3138L4.71046 6.36029Z" fill="#0E293C"/>
                                                    </svg>
                                                </a>@php /*@if ($holding->ticket_url) </a> @else </div>*/ @endphp @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <div class="more-events bg-grey section-line">
                <div class="container-fluid">
                    <div class="">
                        <h2 class="block-title">{{ trans('general.more-to-see') }}</h2>
                        <div class="vertical-event row">
                            <div class="col-lg-9 col-md-9 col-12">
                                @foreach($promoting_events as $event)
                                    <div class="event-item">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-lg-4 col-12">
                                                <div class="img-wrap">
                                                    {{--@auth--}}
                                                        @if($event->isFavorited())
                                                            <div class="bookmark added">
                                                                <svg class="mark_icon" width="25" height="37" viewBox="0 0 25 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M1 0V34.2246C1 35.0039 1.85185 35.4837 2.51829 35.0799L12.0077 29.3289C12.339 29.1281 12.7563 29.1367 13.079 29.3509L21.5433 34.9692C22.208 35.4104 23.0963 34.9338 23.0963 34.136V0" stroke="white" stroke-width="2"/>
                                                                </svg>
                                                                <span class="mark-plus">+</span>
                                                            </div>
                                                        @else
                                                            <div class="bookmark">
                                                                <svg class="mark_icon" width="25" height="37" viewBox="0 0 25 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M1 0V34.2246C1 35.0039 1.85185 35.4837 2.51829 35.0799L12.0077 29.3289C12.339 29.1281 12.7563 29.1367 13.079 29.3509L21.5433 34.9692C22.208 35.4104 23.0963 34.9338 23.0963 34.136V0" stroke="white" stroke-width="2"></path>
                                                                </svg>
                                                                <span class="mark-plus">+</span>
                                                            </div>
                                                        @endif
                                                    {{--@endauth--}}
                                                        <a href="{{ route('public.festival.event', [$festival->slug, $event->slug]) }}"><img src="{{ $event->image->url ? $event->image->url : '/admin/images/no-image-logo.jpg'}}" alt="{{ $event->image->name ? $event->image->name : 'no image'}}"></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-12">
                                                <div class="descr">
                                                    <h5 class="event-title">
                                                        <a href="{{ route('public.festival.event', [$festival->slug, $event->slug]) }}">{{ $event->title }}</a>
                                                    </h5>
                                                    <div class="short small-text">{{ $event->description }}</div>
                                                    <div class="box">
                                                        <a class="label">{{ $event->category->name }}</a>
                                                        <div class="name">{{ $event->directors->implode(', ') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sub-event sub-event-stoke">
                                            <div class="row flex-nowrap item-wrap">
                                                @foreach($event->holdings as $holding)
                                                    <div class="sub-event-item col-lg-3 col-sm-4 col-6">
                                                        <div class="info-box"><a href="{{ route('public.festival.event', [$festival->slug, $event->slug]) }}">
                                                            <div class="time">{{ $holding->date_from->format('H:i') }} {{ trans('general.time-after') }}</div>
                                                            <div class="date">{{ $holding->date_from->format('d'.trans('general.date-split').'m'.trans('general.date-after')) }}</div>
                                                            <div class="name">{{ $holding->place->name }}</div></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection