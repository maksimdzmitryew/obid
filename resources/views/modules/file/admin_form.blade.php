@php
	$s_preview_tpl = 'file';
@endphp

@section('script')
<script>
b_{!! $s_preview_tpl !!}_single = {{ (isset($b_single) && $b_single == 'FALSE') ? 0 : 1 }};
</script>
@append

@php
if (isset($code) && $code != '')
	$s_field_name = $code . '[file_id]';
else
	$s_field_name = 'file_id';
@endphp

<div class="form-group row field file_id" data-name="{!! $s_field_name !!}">
    <div class="col-lg-3">
        <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.file_id.label') !!}</label>
        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.file_id.rules') !!}"><i class="icon-info3"></i></span>
    </div>
    <div class="col-lg-9 field-body"@if(isset($code)) data-lang="{!! $code !!}"@endif>
        <div class="file-preview-thumbnails previews" id="previews">

		@php
		$s_inc = '';
		if ($type == 'arc')
		{
			$s_file = 'archive';
			$s_ext = 'zip|rar|7z';
		}

		if ($type == 'doc')
		{
			$s_file = 'file';
			$s_ext = 'doc|docx|pdf';
		}

		if($item->id)
		{
			if ($item->$s_file) $s_inc = $item->$s_file;
			if (isset($code) && $item->translate($code)->$s_file) $s_inc = $item->translate($code)->$s_file;
		}
		@endphp

		@if($s_inc)
			@include('modules.file.admin_item', ['file' => $s_inc])
		@endif

        </div>

		<div class="uniform-uploader {!! $s_file !!}-uploader" data-preview="/admin/images/file-ico-{!! $type !!}.png" data-ext="{!! $s_ext !!}" data-type="{!! $s_file !!}">
			<input type="file" class="form-control-uniform">
			<span class="filename" style="user-select: none;">{!! trans('common/form.fields.file_id.label') !!}</span>
			<span class="action btn btn-primary legitRipple" style="user-select: none;">
				{!! trans('common/form.fields.file_id.label') !!}
			</span>
		</div>

    </div>

</div>

@include('modules.image.admin_tpl_preview')
