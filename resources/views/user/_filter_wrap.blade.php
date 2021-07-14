<div class="container-fluid">
	<div class="row filters px-4 pt-3">
		@include('user._filter_text', ['name' => 'title'])
		@include('admin.common.filters.created_at')
		@include('admin.common.filters.updated_at')

		@php
			$code				= NULL;
			$o_item			= new \stdClass();
		@endphp

		@if (isset($a_filters) && count($a_filters) > 0)
		@foreach ($a_filters AS $s_field_name => $s_field_type)
		@include('layouts._form_control', ['control' => $s_field_type, 'name' => $s_field_name, 'filter' => TRUE])
		@endforeach
		@endif

	</div>
	<div class="row my-3 px-3">
		@include('user._filter_perpage')
		@include('user._filter_buttons')
	</div>
</div>
