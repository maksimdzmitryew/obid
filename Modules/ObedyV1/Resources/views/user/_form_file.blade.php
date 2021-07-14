@section('script-' . $control)
<script>
b_{!! $control !!}_single = {!! $b_many ? 0 : 1 !!};
$(document).ready(function(){




});
</script>
@endsection

@section('css-' . $control)
<link rel="stylesheet" href="{{ asset($theme . '/css/file.css?v=' . $version->css) }}">
@endsection

@section('js-' . $control)
<script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
<script src="{!! asset('/admin/js/plugins/ui/sortable.js') !!}"></script>

<script type="text/javascript">
	@include('modules.uploader.data2js')
</script>
<script src="{{ asset('/admin/js/plugins/uploaders/dmUploader.js') }}"></script>
<script src="{{ asset('/modules/upload/admin_form.js?v=' . $version->js) }}"></script>
@endsection

<div class="form-group row field {!! $control !!}_id" data-name="{!! $s_dataname !!}">
	<div class="col-lg-3">
		<label class="d-block float-left py-2 m-0">
			{!! $s_label !!}
			{!! $b_required ? '<span class="text-danger">*</span>' : '' !!}
		</label>
		<span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! $s_rules !!}"><i class="icon-info3"></i></span>
	</div>

@include($theme . '::user._form_previews')

</div>

@include('user._form_' . $control . '_tpl_preview')
