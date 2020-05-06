@extends('place::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('place.name') !!}
    </p>
@endsection
