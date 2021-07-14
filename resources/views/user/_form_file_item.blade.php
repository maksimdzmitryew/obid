@if(
    $file->id
    && (
        $name == 'file_id'
        ||
        $name != 'file_id' && $file->id == $o_item->$name
        )
    )
    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $file->id }}" data-id="{{ $file->id }}">
        <div class="file-thumbnail-header">
            <div class="file-actions">
                <div class="file-footer-buttons">
                    <button type="button" class="kv-file-remove" title="{!! trans('admin/file.remove-file') !!}"><i class="icon-bin"></i></button>
                </div>
            </div>
        </div>
        <div class="kv-file-content text-center">
            <img src="{{ $file->type == 'image' ? $file->url : '/admin/images/file-ico-' . substr($file->url, strrpos($file->url, '.')+1) . '.png' }}" class="file-preview-file kv-preview-data" title="{{ $file->original }}" alt="{{ $file->original }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
        </div>
        <div class="file-thumbnail-footer">
            <div class="file-footer-caption" title="{{ $file->original }}">
                <div class="file-caption-info">{{ $file->title }}</div>
                <div class="file-size-info"> <samp>({{ round($file->size / 1024 / 1024, 2) }} MB)</samp></div>
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
                <input type="hidden" name="{!! $s_id !!}{!! $b_many ? '[]' : '' !!}" value="{{ $file->id }}">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endif
