@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper(trans('meta.program') . ' | ' . $festival->name . ' | ' . config('app.name'))!!}</title>
    <meta name="title" content="{!! trans('meta.program') . ' | ' . $festival->meta_title !!}">
    <meta name="description" content="{!! trans('meta.program') . ' | ' . $festival->meta_description !!}">
    <meta name="keywords" content="{!! trans('meta.program') . ',' . $festival->meta_keywords !!}">
@endsection

@section('css')
    <link rel="stylesheet" href="{!! asset('/admin/js/plugins/pickers/air-datepicker/datepicker.min.css') !!}">
@endsection

@section('js')
    <script src="{!! asset('/admin/js/plugins/ui/moment/moment.min.js') !!}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/i18n/datepicker.de.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    {{--<script src="{ ! ! asset('/user/js/filter_category.js') ! ! }"></script>--}}
@endsection

@section('content')
<div class="content program-page">
    @include(
        'public.partials.events-list', 
        [
            'cities'            => $cities, 
            'dates_filtered'    => $dates_filtered, 
            'dates_range'       => $dates_range, 
            'categories'        => $categories, 
            'promotion'         => true
        ]
    )
</div>
@endsection
