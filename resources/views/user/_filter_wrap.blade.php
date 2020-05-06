<div class="container-fluid">
	<div class="row filters px-4 pt-3">
		@include('user._filter_text', ['name' => 'title'])
		@include('admin.common.filters.created_at')
		@include('admin.common.filters.updated_at')
	</div>
	<div class="row my-3 px-3">
		@include('user._filter_perpage')
		@include('user._filter_buttons')
	</div>
</div>
