@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper(trans('meta.about') . ' | ' . $festival->name . ' | ' . config('app.name'))!!}</title>
    <meta name="title" content="{!! $festival->slug . ' | ' . trans('meta.about') !!}">
    <meta name="description" content="{!! $festival->slug . ' | ' . trans('meta.about') !!}">
    <meta name="keywords" content="{!! $festival->slug . ',' . trans('meta.about') !!}">
@endsection

@section('content')

<div class="content about-us-page">
    <div class="container-fluid">
        <div class="title-box">
            <h1 class="title-block">{{ trans('general.about-us') }}</h1>
            <ul class="nav nav-tabs" id="aboutTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="festival-tab" data-toggle="tab" href="#festival-text-tab" role="tab"
                       aria-controls="festival-text-tab" aria-selected="true">{{ trans('general.festival') }}</a>
                </li>
                @if($board_members->count())
                    <li class="nav-item">
                        <a class="nav-link" id="board-tab" data-toggle="tab" href="#board-text-tab" role="tab" aria-controls="board-text-tab" aria-selected="false">{{ trans('general.board') }}</a>
                    </li>
                @endif
                @if($team_members->count())
                    <li class="nav-item">
                        <a class="nav-link" id="team-tab" data-toggle="tab" href="#team-text-tab" role="tab" aria-controls="team-text-tab" aria-selected="false">{{ trans('general.team') }}</a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="tab-content section-tab" id="aboutTabContent">
            <div class="tab-pane fade show active" id="festival-text-tab" role="tabpanel"aria-labelledby="festival-tab">
                <div class="single-event-wrap single-fest-wrap">
                    <div class="row">
                        <div class="col-lg-9 col-md-8 col-12 single-content">
                            {!! $festival->translate(app()->getLocale())->about_festival !!}
                        </div>
                    </div>
                </div>
                {{--@include('public.pages.festival', ['festival' => $festival])--}}
            </div>
            @if($board_members->count())
                <div class="tab-pane fade" id="board-text-tab" role="tabpanel" aria-labelledby="board-tab">
                    @include('public.pages.board')
                </div>
            @endif
            @if($team_members->count())
                <div class="tab-pane fade" id="team-text-tab" role="tabpanel" aria-labelledby="team-tab">
                     @include('public.pages.team')
                </div>
            @endif
            @php
            /*
            @if($medias->count())
                <div class="tab-pane fade" id="media-text-tab" role="tabpanel" aria-labelledby="media-tab">
                     @include('public.pages.media')
                </div>
            @endif
            */
            @endphp
        </div>
    </div>
</div>

@endsection