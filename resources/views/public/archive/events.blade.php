@extends('layouts.public')

@section('content')

<div class="content program-page">

    <div class="filter-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-9 col-sm-7 col-12 vertical-event">
                    <div class="program-line">
                        {{-- <div class="block-title">8 September 2018</div> --}}
                        @foreach($events as $event)
                            @include('public.partials.event')
                        @endforeach
                    </div>

                    @if($festival->promotedEvents)
                        <div class="program-line">
                            <div class="block-title">{{ trans('general.more-to-see') }}</div>
                            @foreach($festival->promotedEvents as $event)
                                @include('public.partials.event')
                            @endforeach
                        </div>
                    @endif
                </div>

                <aside class="right-sidebar col-lg-3 col-sm-5 col-12">
                    <div class="sidebar-inner filter-wrap">
                        <div class="sidebar-item filter-category">
                            <h5 class="sidebar-title">{{ trans('general.category') }}</h5>
                            <div class="sidebar-item-content">
                                <div class="row">
                                    @foreach($categories as $category)
                                        <div class="col-6">
                                            <div class="filter-label">{{ $category->name }} <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-item filter-location">
                            <h5 class="sidebar-title">{{ trans('general.my-location') }}</h5>
                            <div class="sidebar-item-content">
                                <select name="local_sort" id="local-sort" class="full-width">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
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
                            <a href="#" class="btn btn-primary full-width" id="filter-btn">{{ trans('general.filter') }}</a>
                            <div id="filter-reset">
                                {{ trans('general.reset-filters') }}
                                <i id="remove-sidebar-filters" class="fa fa-times" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

@endsection