@php
$b_many				= ($b_many ?? FALSE);
$b_required			= ($b_required ?? FALSE);
$s_dataname			= ($s_dataname ?? $s_id);
$s_fieldname		= ($s_fieldname ?? $s_dataname);
$s_label			= ($s_label ?? trans('user/form.field.' . $s_fieldname));
$s_selected_title	= ($s_selected_title ??
							(
								isset($$s_id)
								? $$s_id
								: (
									old($s_id)
									? old($s_id)
									: (isset($item) ? $item->$s_id : '')
								)
						)
						);
$s_id				= ($s_id . ($b_many ? '[]' : ''));
$s_class_name		= ($s_class_name ?? '');
$s_hint				= ($s_hint ?? '');
$s_typein			= ($s_typein ?? '');
$s_field_type		= ($s_field_type ?? 'text');
@endphp
					<div class="field_row" data-name="{!! $s_dataname !!}">
						<label for="{!! $s_id !!}">
@include('layouts._form_label')
						</label>
@include('layouts._form_input_control')
					</div>
