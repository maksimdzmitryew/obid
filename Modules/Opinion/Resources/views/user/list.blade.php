@section('script')
	<script type="text/javascript">
		a_order = [ 5, "desc" ];
	</script>
@append
@php
$b_title = FALSE;
$a_columns = [
				'place_title' => 'text'
			];
@endphp
@extends('user.list')
