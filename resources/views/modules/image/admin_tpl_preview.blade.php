@php
	if (!isset($b_tpl_loaded) && isset($s_preview_tpl)):
@endphp
@section('js')

<script type="text/javascript">
	@include('modules.uploader.data2js')
</script>
<script src="{{ asset('/admin/js/plugins/uploaders/dmUploader.js') }}"></script>
<script src="{{ asset('/modules/image/admin_form.js') }}"></script>
@append
@php
	endif;
@endphp

@php
	if (isset($s_preview_tpl) && !isset($b_tpl_loaded[$s_preview_tpl]) && Route::has('api.upload.' . $s_preview_tpl)):
@endphp
@php /*=====preview-tpl-{!! $s_preview_tpl !!}====*/ @endphp

<div id="preview-tpl-{!! $s_preview_tpl !!}" class="d-none">
<!--
    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-${id}" data-id="">
        <div class="kv-file-content text-center">
            <img src="${src}" class="file-preview-image kv-preview-data" title="${name}" alt="${name}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
        </div>
        <div class="file-thumbnail-footer">
            <div class="file-footer-caption" title="${name}">
                <div class="file-caption-info">${name}</div>
                <div class="file-size-info"> <samp>(${size} MB)</samp></div>
            </div>
            <div class="file-thumb-progress kv-hidden">
                <div class="progress">
                    <div class="progress-bar bg-success progress-bar-success progress-bar-striped active" style="width:0%;">Initializing... </div>
                </div>
            </div>
            <div class="file-upload-indicator">
                <i class="icon-check text-success d-none"></i>
                <i class="icon-cross2 text-danger d-none"></i>
            </div>
            <div class="file-actions">
                <div class="file-footer-buttons">
                    <button type="button" class="kv-file-remove" title="Remove file"><i class="icon-bin"></i></button>
                </div>
            </div>
            <div class="data d-none">
                <input type="hidden" name="field_name" value="uploaded_image_id" disabled="disabled">
            </div>
            <div class="clearfix"></div>
        </div>
    @if ($s_preview_tpl == 'image')
	@include('modules.image.admin_tpl_copyright')
	@endif
    </div>
-->
</div>
@php
	$b_tpl_loaded[$s_preview_tpl] = TRUE;
	endif;
@endphp
