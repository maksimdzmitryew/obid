@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper($page->name . ' | ' . config('app.name')) !!}</title>
    <meta name="title" content="{!! $page->meta_title . ' | ' . trans('meta.about') !!}">
    <meta name="description" content="{!! $page->meta_keywords . ' | ' . trans('meta.about') !!}">
    <meta name="keywords" content="{!! $page->meta_description . ',' . trans('meta.about') !!}">
@endsection

@section('content')

<div class="content about-us-page">
    <div class="container-fluid">
        <div class="title-box">
            <h1 class="title-block">{{ $page->name }}</h1>
        </div>

        <div class="tab-content section-tab" id="aboutTabContent">
            <div class="tab-pane fade show active" id="festival-text-tab" role="tabpanel"aria-labelledby="festival-tab">
                <div class="single-event-wrap single-fest-wrap">
                    <div class="row">
                        <div class="col-lg-9 col-md-8 col-12 single-content">
                            {!! $page->body !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection