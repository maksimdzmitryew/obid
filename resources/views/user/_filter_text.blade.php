<div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="{!! $name !!}" data-filter-type="text" data-default-value="">
    <label>{!! trans('user/crud.filter.label') !!} {!! trans('crud.field.'.$name.'.filterby') !!}</label>
    <input type="text" class="form-control input-sm" placeholder="{!! trans('crud.hint.input') !!} {!! trans('crud.field.'.$name.'.typein') !!}">
</div>

