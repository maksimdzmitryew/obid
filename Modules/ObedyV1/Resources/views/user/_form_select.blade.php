<div class="form-group row field" data-name="{!! $s_dataname !!}" id="div_select_{!! $s_dataname !!}">
	<div class="col-lg-3">
		<label class="d-block float-left py-2 m-0">
@include('layouts._form_label')
		</label>
		<span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! $s_rules !!}"><i class="icon-info3"></i></span>
	</div>
	<div class="div_control div_select_control col-lg-7 field-body">
@include('layouts._form_select_control')
	</div>
	<div class="div_control col-lg-2 field-body">
@include('user._filter_button_filter', ['btn_id' => 'open'])
@include('user._filter_button_reset', ['btn_id' => 'restore'])
@include('user._filter_button_delete', ['btn_id' => 'clean'])
	</div>
</div>
