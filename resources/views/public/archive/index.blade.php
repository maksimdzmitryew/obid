@extends('layouts.public')

@section('content')

@if($festival->slider)
    <div class="top-slider-wrap">
        <div id="top-slider">
            @foreach($festival->slider->slides as $slide)
                <div class="slide-item">
                    <div class="img-wrap">
                        <img src="{{ $slide->image->url }}" alt="slide"/>
                    </div>
                    <div class="descr">
                        <div class="top-text">{{ $slide->upper_title }}</div>
                        <h2 class="slide-title">{{ $slide->title }}</h2>
                        <div class="short">{{ $slide->description }}</div>
                        @if($slide->button_text)
                            <div class="btn-wrap">
                                <a href="{{ $slide->button_url }}" class="btn btn-primary">{{ $slide->button_text }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<div class="news-block">
    <div class="container-fluid">
        <div class="row">
            @foreach($posts as $post)
                @include("public.partials.{$post->type}")
            @endforeach
        </div>
    </div>
</div>


@endsection