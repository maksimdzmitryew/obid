@section('script')
	<script type="text/javascript">
		a_order = [ 2, "desc" ];
	</script>
@append
@php
$a_columns = [
				'ico' => 'text'
			];
@endphp
@extends('user.list')
