<div class="col-md-12 col-lg-4 col-xl-4 mb-2 lg-mb-0 text-left">
	<select class="form-control multi-select" id="page-length" data-placeholder="{!! trans('user/crud.filter.perpage') !!}">
		@for ($i = 20; $i < 120; $i+=20)
		<option value="{!! $i !!}">{!! $i !!} {!! trans('user/crud.filter.perpage') !!}</option>
		@endfor
	</select>
</div>
