@php
	if (isset($control) && !isset($b_tpl_loaded['previews']) && Route::has('api.upload.' . $control)):
@endphp

	<div class="col-lg-9 field-body">
		<div class="file-preview-thumbnails previews" id="previews">

@include('layouts._form_' . $control . '_current')

		</div>
		<div class="uniform-uploader {!! $control !!}-uploader" data-type="{!! $control !!}">
			<input type="file" class="form-control-uniform"{!! $b_many ? ' multiple' : '' !!}>
			<span class="filename" style="user-select: none;">{!! $s_hint !!} {!! $s_typein !!}</span>
			<span class="action btn btn-primary legitRipple" style="user-select: none;">{!! $s_hint !!}</span>
		</div>
	</div>

@php
	$b_tpl_loaded['previews'] = TRUE;
	endif;
@endphp
