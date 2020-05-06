<div class="col-lg-9">
    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.preview_copyright.label') !!}</label>
    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.preview_copyright.rules') !!}"><i class="icon-info3"></i></span>
</div>
<div class="col-lg-9 field-body">
    <input type="text" id="copyright-{{ $image->id }}" name="image_copyrights[{{ $image->id }}]" class="form-control image_copyright" placeholder="{!! trans('common/form.fields.preview_copyright.label') !!}" autocomplete="off" value="{{ $image->copyright }}">
</div>
