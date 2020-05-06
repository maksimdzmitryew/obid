@if( ! empty($galleries))
    <div class="form-group row field" data-name="gallery_id">
        <div class="col-lg-3">
            <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.gallery.label') !!}</label>
            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.gallery.rules') !!}"><i class="icon-info3"></i></span>
        </div>
        <div class="col-lg-9 field-body">
            <select class="multi-select" name="gallery_id" id="gallery-id" data-placeholder="{!! trans('app/news.form.fields.gallery.label') !!}">
                <option value="">{!! trans('app/news.form.fields.gallery.label') !!}</option>
                @foreach($galleries as $gallery)
                    <option value="{{ $gallery->id }}"  {!! $item->gallery && $item->gallery->id === $gallery->id ? 'selected="selected"' : '' !!}>{{ $gallery->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@else
    <div class="form-group row field" data-name="files">
        <div class="col-lg-3">
            <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.gallery.label') !!}</label>
            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.gallery.rules') !!}"><i class="icon-info3"></i></span>
        </div>
        <div class="col-lg-9 field-body">{!! trans('app/news.form.fields.gallery.label') !!}</div>
    </div>
@endif
