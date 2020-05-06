@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper($book->name . ' | ' . $festival->name . ' | ' . config('app.name')) !!}</title>
    <meta name="title" content="{!! $book->meta_title !!}">
    <meta name="description" content="{!! $book->meta_description !!}">
    <meta name="keywords" content="{!! $book->meta_keywords !!}">
@endsection

@section('content')

<div class="content book-page">
    <div class="container-fluid">
        <h1 class="block-title">{{ trans('general.book') }}</h1>
        <div class="single-event-wrap single-book-wrap">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-12 single-content">
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-5 col-12">
                                <div class="top d-block d-lg-none d-xl-none">
                                    <h2 class="block-title">{{ $book->name }}</h2>
                                    <div class="annotation">{{ $book->excerpt }}</div>
                                </div>
                                <div class="book-wrap">

                                    @php /*<div class="img-wrap">
                                        <img src="{{ $book->image->url }}" alt="{{ $book->image->name }}">
                                    </div>*/ @endphp

                                    @include('modules.image.user_gallery', ['item' => $book])

                                    <div class="btn-wrap">
                                        <div class="share-btn-multi">
                                            <a href="#" class="btn grey-btn share-btn">
                                                <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="26" height="27" fill="black" fill-opacity="0" transform="translate(0 27) scale(1 -1)"></rect>
                                                    <path d="M20.701 10.1884C19.063 10.1884 17.5966 9.47017 16.6236 8.34437L10.2944 11.7983C10.4913 12.3307 10.5994 12.9031 10.5994 13.4996C10.5994 14.096 10.4913 14.6684 10.2944 15.2008L16.6232 18.6555C17.596 17.5294 19.0627 16.8109 20.7008 16.8109C23.6227 16.8109 25.9999 19.0966 25.9999 21.9062C26.0001 24.715 23.6229 27 20.701 27C17.7787 27 15.4013 24.715 15.4013 21.9063C15.4013 21.3098 15.5094 20.7373 15.7063 20.2048L9.37722 16.7499C8.40436 17.8755 6.93809 18.5935 5.30046 18.5935C2.37781 18.5935 4.05591e-08 16.3085 4.05591e-08 13.4997C4.05591e-08 10.691 2.37781 8.40605 5.30046 8.40605C6.93809 8.40605 8.40424 9.12402 9.3771 10.2495L15.7063 6.79542C15.5094 6.26294 15.4012 5.6903 15.4012 5.09365C15.4012 2.28498 17.7786 0 20.7009 0C23.6228 0 26 2.2851 26 5.09365C26.0001 7.9028 23.6229 10.1884 20.701 10.1884ZM20.701 25.2175C22.6004 25.2175 24.1456 23.7322 24.1456 21.9063C24.1456 20.0796 22.6004 18.5935 20.701 18.5935C18.8013 18.5935 17.2558 20.0796 17.2558 21.9063C17.2558 23.7322 18.8013 25.2175 20.701 25.2175ZM5.30059 10.1884C3.40049 10.1884 1.8546 11.6739 1.8546 13.4996C1.8546 15.3255 3.40049 16.8109 5.30059 16.8109C7.19994 16.8109 8.74509 15.3255 8.74509 13.4996C8.74509 11.6739 7.19982 10.1884 5.30059 10.1884ZM20.701 1.78233C18.8013 1.78233 17.2558 3.26783 17.2558 5.09354C17.2558 6.91996 18.8013 8.40593 20.701 8.40593C22.6004 8.40593 24.1456 6.91996 24.1456 5.09354C24.1456 3.26783 22.6004 1.78233 20.701 1.78233Z" fill="#0E293C"></path>
                                                </svg>
                                                <span class="text">{{ trans('general.share-this') }}</span>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </a>
                                            <div class="share-drop">
                                                <div data-network="twitter" class="st-custom-button some-new-classes-here">
                                                    <i class="fa fa-twitter"></i>
                                                </div>
                                                <div data-network="facebook" class="st-custom-button some-new-classes-here">
                                                    <i class="fa fa-facebook-f"></i>
                                                    {{--<span>Facebook</span>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-12">
                                <div class="descr-wrap">
                                    <div class="top d-none d-lg-block d-xl-block">
                                        <h2 class="block-title">{{ $book->name }}</h2>
                                        <div class="annotation">{{ $book->excerpt }}</div>
                                    </div>
                                    <div class="text">{!! $book->description !!}</div>
                                    @if($book->api_code)
                                        <div class="browse-book">{{ trans('general.browse-book') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($book->api_code)
                            <div class="bottom-wrap text-center">
                                <iframe src="{!! $book->api_code !!}" width="100%" height="500" style="max-width: 815px; margin: 0 auto" frameborder="0" allowfullscreen="true"></iframe>
                            </div>
                        @endif
                    </div>

                </div>
                <aside class="right-sidebar col-lg-3 col-md-4 col-12">
                    <div class="sidebar-inner">

                        @php
                        /*
                        <div class="side-line">
                            <div class="side-title">{{ trans('general.book-editors') }}</div>
                            <div class="side-cont">
                                @foreach($book->authors as $author)
                                    <div class="book-side-item">
                                        <div class="name">{{ $author->name }}</div>
                                        <div class="post">{{ $author->profession }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        */
                       @endphp
                        <div class="side-line">
                            <div class="side-title">{{ trans('general.volume') }}</div>
                            <div class="side-cont">{{ $book->volume }}</div>
                        </div>
                        <div class="side-line">
                            <a href="{{ $book->url }}" target="_blank" class="btn btn-primary">{{ trans('general.buy-now') }}</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div class="sub-section see-also more-book-section section-line">
            <div class="container-fluid">
                <h2 class="block-title text-center">{{ trans('general.see-also') }}</h2>
                <div class="row">
                    @foreach($books as $book)
                        <div class="col-md-3 col-6">
                            <div class="more-item">
                                <div class="img-wrap">
                                    <a href="{{ route('public.festival.book', [$book->festival->slug, $book->slug]) }}">
                                        <img src="{{ $book->image->url }}" alt="">
                                    </a>
                                </div>
                                <div class="descr">
                                    <h4 class="more-title">
                                        <a href="{{ route('public.festival.book', [$book->festival->slug, $book->slug]) }}">{{ $book->name }}</a>
                                    </h4>
                                    <div class="short">{{ $book->excerpt }}</div>
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