@php
	if (isset($control) && !isset($b_tpl_loaded[$control]) && Route::has('api.upload.' . $control)):
@endphp

<div id="preview-tpl-{!! $control !!}" class="d-none">
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
    </div>
-->
</div>
@php
	$b_tpl_loaded[$control] = TRUE;
	endif;
@endphp
