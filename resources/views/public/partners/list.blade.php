@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper(trans('meta.partners') . ' | ' . $festival->name . ' | ' . config('app.name'))!!}</title>
    <meta name="title" content="{!! $festival->slug . ' | ' . trans('meta.partners') !!}">
    <meta name="description" content="{!! $festival->slug . ' | ' . trans('meta.partners') !!}">
    <meta name="keywords" content="{!! $festival->slug . ',' . trans('meta.partners') !!}">
@endsection

@section('content')
<div class="content partners-page">
    <div class="container-fluid">
        <div class="title-box">
            <h1 class="title-block">{{ trans('general.partners') }}</h1>
            <ul class="nav nav-tabs" id="partnersTab" role="tablist">
                @foreach($partner_categories as $category)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : ''}}"
                            id="partners-tab"
                            data-toggle="tab"
                            href="#{{ $category->slug }}-text-tab"
                            role="tab"
                            aria-controls="partners-text-tab" aria-selected="true">
                                {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tab-content section-tab" id="partnersTabContent">
            @foreach($partner_categories as $category)
                <div class="tab-pane fade show {{ $loop->first ? 'active' : ''}}" id="{{ $category->slug }}-text-tab" role="tabpanel" aria-labelledby="partners-tab">
                    <div class="partner-inner">
                        <div class="row">
                            @foreach($partners->{$category->slug} AS $partner)
                                <div class="col-sm-3 col-6 partner-block-item">
                                    <a class="partner-block" href="{{ $partner->url }}" target="_blank">
                                        <img src="{{ $partner->image->url }}" alt="{{ $partner->title }}" title="{{ $partner->title }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection