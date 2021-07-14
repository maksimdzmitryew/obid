@php
$b_many				= ($b_many ?? FALSE);
$b_required			= ($b_required ?? FALSE);
$s_dataname			= ($s_dataname ?? $s_id);
$s_fieldname		= ($s_fieldname ?? $s_dataname);
//
// TODO remove when users Module is ready
/********************************* my profile *********************************/
$s_label			= ($s_label ?? '');
if ('' == $s_label) {
	$s_tmp				= 'user/crud.field.' . $s_fieldname . '.label';
	$s_label			= trans($s_tmp);
}
if ($s_tmp == $s_label) {
	$s_tmp				= $_env->s_utype . '/form.field.' . $s_fieldname;
	$s_label			= trans($s_tmp);
}
if ($s_tmp == $s_label) {
	$s_tmp				= 'user/form.field.' . $s_fieldname;
	$s_label			= trans($s_tmp);
}
/********************************* /my profile *********************************/

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

/*
$code				= '';
$name				= $s_fieldname;
$o_item				= $item;
$s_category			= strtolower(class_basename(__CLASS__));
$control			= $s_field_type;
include(base_path().'/resources/views/layouts/_form_variables.php');
*/
@endphp
					<div class="field_row" data-name="{!! $s_dataname !!}">
						<label for="{!! $s_id !!}">
@include('layouts._form_label')
						</label>
@include('layouts._form_input_control')
					</div>
