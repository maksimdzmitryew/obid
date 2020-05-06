<div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="festivals" data-filter-type="select" data-default-value="">
    <label>{!! trans('common/list.filters.festivals') !!}</label>
    <div>
        <select class="form-control multi-select" data-placeholder="{!! trans('common/list.filters.festivals') !!}" multiple>
            @foreach($festivals as $festival)
                <option value="{!! $festival->id !!}">{!! $festival->name !!}</option>
            @endforeach
        </select>
    </div>
</div>
