@if($professions)
    <div class="form-group row field" data-name="festivals[{!! isset($festival) ? $festival->id : '${id}' !!}][profession_id]">
        <div class="col-lg-3">
            <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.profession_id.label') !!}</label>
        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.profession_id.rules') !!}"><i class="icon-info3"></i></span>
        </div>
        <div class="col-lg-9 field-body">
            <select name="festivals[{!! isset($festival) ? $festival->id : '${id}' !!}][profession_id]" class="form-control new-profession" id="festivals[{!! isset($festival) ? $festival->id : '${id}' !!}][profession_id]" data-placeholder="{!! trans('app/artists.form.fields.profession_id.label') !!}">
                <option value="0" {!! isset($festival) && $festival->profession_id == NULL ? 'selected="selected"' : '' !!}>None</option>
                @foreach($professions as $profession)
                    <option value="{!! $profession->id !!}" {!! isset($festival) && $festival->profession_id == $profession->id ? 'selected="selected"' : '' !!}>{!! $profession->name !!}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif
