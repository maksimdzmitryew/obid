@section('script')
	<script type="text/javascript">
		a_order = [ 6, "desc" ];
	</script>
@append
@php
$a_columns = [
				'user_name' => 'name'
			];
@endphp
@extends('user.list')
