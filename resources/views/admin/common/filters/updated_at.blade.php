<div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="updated_at" data-filter-type="date-range" data-default-value="@if (!$dates['null_updated_at']){!! $dates['min_updated_at'] . '|' . $dates['max_updated_at'] !!}@endif">
    <label>{!! trans('user/crud.filter.label') !!} {!! trans('user/crud.filter.updated_at') !!}</label>
    <div class="form-group form-group-feedback form-group-feedback-left">
        <input class="form-control input-sm date-range" placeholder="{!! trans('common/list.filters.updated_at') !!}">
        <div class="form-control-feedback form-control-feedback-lg"><i class="icon-calendar2"></i></div>
    </div>
</div>
