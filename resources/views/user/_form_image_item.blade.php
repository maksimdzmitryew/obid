@if($image->id)
    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $image->id }}" data-id="{{ $image->id }}">
        <div class="file-thumbnail-header">
            <div class="file-actions">
                <div class="file-footer-buttons">
                    <button type="button" class="kv-image-remove" title="{!! trans('admin/file.remove-image') !!}"><i class="icon-bin"></i></button>
                </div>
            </div>
        </div>
        <div class="kv-file-content text-center">
            <img src="{{ $image->url }}" class="file-preview-image kv-preview-data" title="{{ $image->original }}" alt="{{ $image->original }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
        </div>
        <div class="file-thumbnail-footer">
            <div class="file-footer-caption" title="{{ $image->original }}">
                <div class="file-caption-info">{{ $image->title }}</div>
                <div class="file-size-info"> <samp>({{ round($image->size / 1024 / 1024, 2) }} MB)</samp></div>
            </div>
            <div class="file-thumb-progress kv-hidden">
                <div class="progress">
                    <div class="progress-bar bg-success progress-bar-success progress-bar-striped active" style="width:0%;">{!! trans('admin/file.initializing') !!}</div>
                </div>
            </div>
            <div class="file-upload-indicator">
                <i class="icon-check text-success d-none"></i>
                <i class="icon-cross2 text-danger d-none"></i>
            </div>
            <div class="data d-none">
                <input type="hidden" name="{!! $s_id !!}{!! $b_many ? '[]' : '' !!}" value="{{ $image->id }}">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endif
