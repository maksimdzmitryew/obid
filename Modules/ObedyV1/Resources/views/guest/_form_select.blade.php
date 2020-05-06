					<div class="field_row" data-name="{!! $s_dataname !!}" id="div_select_{!! $s_dataname !!}">
						<label for="{!! $s_id !!}{!! $b_many ? '[]' : '' !!}">
@include('layouts._form_label')
						</label>
						<div class="div_control div_select_control field-body">
@include('layouts._form_select_control')
						</div>
					</div>
