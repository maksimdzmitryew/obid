@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper($post->title . ' | ' . trans('meta.news') . ' | ' . $festival->name . ' | ' . config('app.name'))!!}</title>
    <meta property="og:type" content="website">
    <meta property="og:title" content="{!! $post->title !!}">
    <meta property="og:description" content="{!! $post->description !!}">
    <meta property="og:image" content="{!! $post->image ?? $post->image->medium_image_url !!}">
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
    </script>
@endsection

@section('content')

<div class="content news-page">
    <div class="container-fluid">
        <div class="inner-content">
            <h1 class="block-title">{{ $post->title }}</h1>
            <div class="date-single">{{ $post->created_at->format('d F Y') }}</div>
            <div class="short-single">{{ $post->excerpt }}</div>
            <div class="btns-wrap d-flex">
                <div class="btn-item col-md-4 col-12">
                    <a href="{!! route('public.festival.posts', [$festival->slug, 'category' => $post->category->id]) !!}" class="btn grey-btn label-btn">
                        <span class="label">{{ $post->category->name }}</span>
                        <span class="text">{{ trans('general.see-all-news') }}</span>
                    </a>
                </div>
                <div class="btn-item col-md-4 col-12 p-0">
                    <div class="share-btn-multi">
                        <a href="#" class="btn grey-btn share-btn">
                            <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="26" height="27" fill="black" fill-opacity="0" transform="translate(0 27) scale(1 -1)"/>
                                <path d="M20.701 10.1884C19.063 10.1884 17.5966 9.47017 16.6236 8.34437L10.2944 11.7983C10.4913 12.3307 10.5994 12.9031 10.5994 13.4996C10.5994 14.096 10.4913 14.6684 10.2944 15.2008L16.6232 18.6555C17.596 17.5294 19.0627 16.8109 20.7008 16.8109C23.6227 16.8109 25.9999 19.0966 25.9999 21.9062C26.0001 24.715 23.6229 27 20.701 27C17.7787 27 15.4013 24.715 15.4013 21.9063C15.4013 21.3098 15.5094 20.7373 15.7063 20.2048L9.37722 16.7499C8.40436 17.8755 6.93809 18.5935 5.30046 18.5935C2.37781 18.5935 4.05591e-08 16.3085 4.05591e-08 13.4997C4.05591e-08 10.691 2.37781 8.40605 5.30046 8.40605C6.93809 8.40605 8.40424 9.12402 9.3771 10.2495L15.7063 6.79542C15.5094 6.26294 15.4012 5.6903 15.4012 5.09365C15.4012 2.28498 17.7786 0 20.7009 0C23.6228 0 26 2.2851 26 5.09365C26.0001 7.9028 23.6229 10.1884 20.701 10.1884ZM20.701 25.2175C22.6004 25.2175 24.1456 23.7322 24.1456 21.9063C24.1456 20.0796 22.6004 18.5935 20.701 18.5935C18.8013 18.5935 17.2558 20.0796 17.2558 21.9063C17.2558 23.7322 18.8013 25.2175 20.701 25.2175ZM5.30059 10.1884C3.40049 10.1884 1.8546 11.6739 1.8546 13.4996C1.8546 15.3255 3.40049 16.8109 5.30059 16.8109C7.19994 16.8109 8.74509 15.3255 8.74509 13.4996C8.74509 11.6739 7.19982 10.1884 5.30059 10.1884ZM20.701 1.78233C18.8013 1.78233 17.2558 3.26783 17.2558 5.09354C17.2558 6.91996 18.8013 8.40593 20.701 8.40593C22.6004 8.40593 24.1456 6.91996 24.1456 5.09354C24.1456 3.26783 22.6004 1.78233 20.701 1.78233Z" fill="#0E293C"/>
                            </svg>
                            <span class="text">{{ trans('general.share-this') }}</span>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                        <div class="share-drop">
                            <div data-network="twitter" data-title="{!! $post->title !!}" data-description="{!! $post->description !!}" data-image="{!! $post->image ? url()->to('/') . $post->image->small_image_url : '' !!}" class="st-custom-button some-new-classes-here">
                                <i class="fa fa-twitter"></i>
                            </div>
                            <div data-network="facebook" data-title="{!! $post->title !!}" data-description="{!! $post->description !!}" data-image="{!! $post->image ? url()->to('/') . $post->image->small_image_url : '' !!}" class="st-custom-button some-new-classes-here">
                                <i class="fa fa-facebook-f"></i>
                                {{--<span>Facebook</span>--}}
                            </div>
                        </div>
                    </div>
                </div>
                @if($post->event_id)
                    <div class="btn-item col-md-4 col-12 p-0">
                        <a href="{{ route('public.festival.event', [$festival->slug, $post->event->slug]) }}" class="btn grey-btn">{{ trans('general.go-to-event') }}</a>
                    </div>
                @endif
            </div>

            @include('modules.image.user_gallery', ['item' => $post])

            <div class="text-wrap">
                {!! $post->body !!}
            </div>
        </div>
    </div>

    <div class="sub-section news-block more-to-see">
        <div class="container-fluid">
            <h2 class="block-title text-center">{{ trans('general.more-to-see') }}</h2>
            <div class="row">
                @foreach($news as $post)
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="news-item">
                            <div class="img-wrap">
                                <div class="label">{{ $post->category->name }}</div>
                                <a href="{{ route('public.festival.post', [$festival->slug, $post->slug]) }}"><img src="{{ $post->image->url }}" alt=""></a>
                            </div>
                            <div class="descr">
                                <div class="date">{{ $post->created_at->format('d F Y') }}</div>
                                <h4 class="news-title"><a href="{{ route('public.festival.post', [$festival->slug, $post->slug]) }}">{{ $post->title }}</a></h4>
                                <div class="short">
                                    {{ $post->excerpt }}
                                </div>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="more-events bg-grey section-line">
        <div class="container-fluid">
            <div class="inner-width">
                <h2 class="block-title text-center">{{ trans('general.more-to-see') }}</h2>
                <div class="vertical-event row">
                    @foreach($events as $event)
                        <div class="col-lg-12 col-md-6 col-12 event-item">
                            <div class="inner">
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
                                            <a href="{{ route('public.festival.event', [$festival->slug, $event->slug]) }}"><img src="{{ $event->image->small_image_url ? $event->image->small_image_url : '/admin/images/no-image-logo.jpg'}}" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-12">
                                        <div class="descr">
                                            <h5 class="event-title"><a href="{{ route('public.festival.event', [$festival->slug, $event->slug]) }}">{{ $event->title }}</a></h5>
                                            <div class="short small-text">
                                                {!! $event->description !!}
                                            </div>
                                            <div class="box">
                                                <a class="label">{{ $event->category->name }}</a>
                                                <div class="name">{{ $event->directors->map->name->implode(', ') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sub-event sub-event-stoke">
                                    <div class="row flex-nowrap item-wrap">
                                        @foreach($event->holdings as $holding)
                                            <div class="sub-event-item col-lg-2 col-sm-4 col-6">
                                                <div class="info-box">
                                                    <div class="time">{{ $holding->date_from->format('H:i') }}</div>
                                                    <div class="date">{{ $holding->date_from->format('d/m') }}</div>
                                                    <div class="name">{{ $holding->place->name }}</div>
                                                </div>
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
    </div>
</div>

@endsection