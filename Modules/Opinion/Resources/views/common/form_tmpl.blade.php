@section('tmpl')
<div id="div_tmpl_{!! $s_model_name !!}">
	<div class="fest p-3 mt-2 div_mark_wrapper" style="border: 1px solid silver">
		<div class="form-group row field search-box-container" data-name="opinions.${id}.id">
			<div class="col-lg-4">
				<label class="d-block float-left py-2 m-0">
					${title}
					{!! $b_required ? '<span class="text-danger">*</span>' : '' !!}
				</label>
			</div>
			<div class="col-lg-8 field-body">
				@include('layouts._form_' . $control . '_tmpl', ['s_fname' => 'element_id'])
				<!--input type="hidden" name="{!! $s_model_nameid !!}[element_id]" class="{!! $s_model_name !!}_element_id" value="${element_id}"-->
				<select name="{!! $s_model_nameid !!}[mark_id]" class="opinions" data-placeholder="{!! trans('crud.hint.select') !!} {!! trans($name.'::crud.names.sgl') !!}">
					<option value="${option_value}">${option_title}</option>
				</select>
				@include('layouts._form_' . $control . '_tmpl', ['s_fname' => 'place_id'])
				<!--input type="hidden" name="{!! $s_model_nameid !!}[place_id]" class="{!! $s_model_name !!}_place_id" value="${place_id}"-->
			</div>
		</div>
	</div>
</div>
@append

@section('js')
<script src="{{ asset('/admin/js/plugins/templates/jquery.tmpl.js') }}"></script>
@append