					<div class="field_row" data-name="{!! $s_dataname !!}">
						<label for="{!! $s_id !!}{!! $b_many ? '[]' : '' !!}">
@include('layouts._form_label')
						</label>
@include('layouts._form_checkbox_control')
					</div>
