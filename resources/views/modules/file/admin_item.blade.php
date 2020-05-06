@if($file->id)
    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $file->id }}" data-id="{{ $file->id }}">
        <div class="file-thumbnail-header">
            <div class="file-actions">
                <div class="file-footer-buttons">
                    <button type="button" class="kv-file-remove" title="{!! trans('admin/file.remove-file') !!}"><i class="icon-bin"></i></button>
                </div>
            </div>
        </div>
        <div class="kv-file-content text-center">
            <img src="/admin/images/file-ico-{!! $type !!}.png" class="file-preview-file kv-preview-data" title="{{ $file->original }}" alt="{{ $file->original }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
        </div>
        <div class="file-thumbnail-footer">
            <div class="file-footer-caption" title="{{ $file->original }}">
                <div class="file-caption-info">{{ $file->original }}</div>
                <div class="file-size-info"> <samp>({{ round($file->size / 1024, 2) }} MB)</samp></div>
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
                <input type="hidden" name="{!! $s_field_name !!}" value="{{ $file->id }}">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endif

@php /*
@if($festival->id && $festival->translate($code)->file->id)
    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $festival->translate($code)->file->id }}" data-id="{{ $festival->translate($code)->file->id }}">
        <div class="kv-file-content text-center">
            <img src="/admin/files/doc.png" class="file-preview-file kv-preview-data" title="{{ $festival->translate($code)->file->name }}" alt="{{ $festival->translate($code)->file->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
        </div>
        <div class="file-thumbnail-footer">
            <div class="file-footer-caption" title="{{ $festival->translate($code)->file->name }}">
                <div class="file-caption-info">{{ $festival->translate($code)->file->name }}</div>
                <div class="file-size-info"> <samp>({{ $festival->translate($code)->file->size }} KB)</samp></div>
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
            <div class="file-actions">
                <div class="file-footer-buttons">
                    <button type="button" class="kv-file-remove" title="Remove file"><i class="icon-bin"></i></button>
                </div>
            </div>
            <div class="data d-none">
                <input type="hidden" name="{!! $code !!}[file_id]" value="{{ $festival->translate($code)->file->id }}">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endif
*/
@endphp