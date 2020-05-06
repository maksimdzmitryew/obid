@php
	$s_preview_tpl = 'image';
@endphp

@section('script')
<script>
b_{!! $s_preview_tpl !!}_single = {{ (isset($b_single) && $b_single == 'FALSE') ? 0 : 1 }};
</script>
@append

<div class="form-group row field image_id" data-name="image_ids">
    <div class="col-lg-3">
        <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.image_id.label') !!}</label>
        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.image_id.rules') !!}"><i class="icon-info3"></i></span>
    </div>
    <div class="col-lg-9 field-body">
        <div class="file-preview-thumbnails previews" id="previews">

        @if($item->images && $item->images->count())
            @foreach($item->images as $image)
                @include('modules.image.admin_item', ['image' => $image])
            @endforeach
        @elseif($item->image)
            @include('modules.image.admin_item', ['image' => $item->image])
        @endif

        </div>
        <div class="uniform-uploader image-uploader" data-type="image">
        	<input type="file" class="form-control-uniform" multiple>
        	<span class="filename" style="user-select: none;">{!! trans('common/form.fields.image_id.label') !!}</span>
        	<span class="action btn btn-primary legitRipple" style="user-select: none;">{!! trans('common/form.fields.image_id.label') !!}</span>
        </div>
    </div>

</div>

@include('modules.image.admin_tpl_preview')
