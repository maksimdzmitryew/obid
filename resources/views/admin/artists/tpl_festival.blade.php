<div class="form-group row field" data-name="festivals[{!! isset($festival) ? $festival->id : '${id}' !!}][order]">
    <div class="col-lg-3">
        <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.order.label') !!}</label>
        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.gallery.rules') !!}"><i class="icon-info3"></i></span>
    </div>
    <div class="col-lg-9 field-body">
        <select class="form-control new-order" name="festivals[{!! isset($festival) ? $festival->id : '${id}' !!}][order]" id="festivals[{!! isset($festival) ? $festival->id : '${id}' !!}][order]" data-placeholder="!! trans('app/artists.form.fields.order.label') !!}">
            <option value="0" {!! isset($festival) && $festival->order == 0 ? 'selected="selected"' : '' !!}>0</option>
            <option value="1" {!! isset($festival) && $festival->order == 1 ? 'selected="selected"' : '' !!}>1</option>
            <option value="2" {!! isset($festival) && $festival->order == 2 ? 'selected="selected"' : '' !!}>2</option>
            <option value="3" {!! isset($festival) && $festival->order == 3 ? 'selected="selected"' : '' !!}>3</option>
            <option value="4" {!! isset($festival) && $festival->order == 4 ? 'selected="selected"' : '' !!}>4</option>
            <option value="5" {!! isset($festival) && $festival->order == 5 ? 'selected="selected"' : '' !!}>5</option>
            <option value="6" {!! isset($festival) && $festival->order == 6 ? 'selected="selected"' : '' !!}>6</option>
            <option value="7" {!! isset($festival) && $festival->order == 7 ? 'selected="selected"' : '' !!}>7</option>
            <option value="8" {!! isset($festival) && $festival->order == 8 ? 'selected="selected"' : '' !!}>8</option>
            <option value="9" {!! isset($festival) && $festival->order == 9 ? 'selected="selected"' : '' !!}>9</option>
        </select>
    </div>
</div>
