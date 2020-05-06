@section('script-image')
<script>
b_{!! $control !!}_single = {!! $b_many ? 0 : 1 !!};
$(document).ready(function(){
	new Sortable(document.getElementById('previews'), {
		animation: 300,
		delay: 0
	});
});
</script>
@endsection

@section('css-image')
<link rel="stylesheet" href="{{ asset($theme . '/css/file.css?v=' . $version->css) }}">
@endsection

@section('js-image')
<script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
<script src="{!! asset('/admin/js/plugins/ui/sortable.js') !!}"></script>

<script type="text/javascript">
	@include('modules.uploader.data2js')
</script>
<script src="{{ asset('/admin/js/plugins/uploaders/dmUploader.js') }}"></script>
<script src="{{ asset('/modules/image/admin_form.js') }}"></script>
@endsection

<div class="form-group row field image_id" data-name="{!! $s_dataname !!}">
	<div class="col-lg-3">
		<label class="d-block float-left py-2 m-0">
			{!! $s_label !!}
			{!! $b_required ? '<span class="text-danger">*</span>' : '' !!}
		</label>
		<span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! $s_rules !!}"><i class="icon-info3"></i></span>
	</div>
	<div class="col-lg-9 field-body">
		<div class="file-preview-thumbnails previews" id="previews">

@include('layouts._form_' . $control . '_current');

		</div>
		<div class="uniform-uploader image-uploader" data-type="image">
			<input type="file" class="form-control-uniform"{!! $b_many ? ' multiple' : '' !!}>
			<span class="filename" style="user-select: none;">{!! trans('user/crud.hint.'.$control) !!} {!! $s_typein !!}</span>
			<span class="action btn btn-primary legitRipple" style="user-select: none;">{!! trans('user/crud.hint.'.$control) !!}</span>
		</div>
	</div>

</div>

@include('user._form_image_tpl_preview')
