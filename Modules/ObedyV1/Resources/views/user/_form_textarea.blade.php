<div class="form-group row field" data-name="{!! $s_dataname !!}">
	<div class="col-lg-3">
		<label class="d-block float-left py-2 m-0">
@include('layouts._form_label')
		</label>
		<span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! $s_rules !!}">
			<i class="icon-info3"></i>
		</span>
	</div>
	<div class="div_control div_input_control col-lg-9 field-body">
@include('layouts._form_textarea_control')
	</div>
</div>
