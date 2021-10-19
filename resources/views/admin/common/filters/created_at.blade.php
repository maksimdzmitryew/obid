<div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="created_at" data-filter-type="date-range" data-default-value="@if (!$dates['null_created_at']){!! $dates['min_created_at'] . '|' . $dates['max_created_at'] !!}@endif">
    <label>{!! trans('user/crud.filter.label') !!} {!! trans('user/crud.filter.created_at') !!}</label>
    <div class="form-group form-group-feedback form-group-feedback-left">
        <input class="form-control input-sm date-range" placeholder="{!! trans('common/list.filters.created_at') !!}">
        <div class="form-control-feedback form-control-feedback-lg"><i class="icon-calendar2"></i></div>
    </div>
</div>
