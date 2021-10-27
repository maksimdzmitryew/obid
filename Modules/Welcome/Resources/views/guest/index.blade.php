@extends($theme . '::' . $_env->s_utype . '.master')

@section('content')
@if (!empty(config('services.google.map.key')))
@include('public.partials._map')
@endif
@endsection
