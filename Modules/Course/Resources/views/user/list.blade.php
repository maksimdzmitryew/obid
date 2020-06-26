@section('script')
	<script type="text/javascript">
		a_order = [ 2, "asc" ];
	</script>
@append
@php
$a_columns = [
				'ico' => 'text'
			];
@endphp
@extends('user.list')
