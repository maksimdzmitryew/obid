@extends('layouts.admin')

@section('content')

@php
include(base_path().'/resources/views/user/menu.php');
@endphp
@include('admin.common._card_group')

<div style="display:block; clear:both;">
@foreach ($cnt AS $s_name => $s_val)
<br />{!! $s_val !!}: {!! $s_name !!}
@endforeach
</div>

@endsection
