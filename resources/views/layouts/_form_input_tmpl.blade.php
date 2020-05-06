@include(
	'layouts._form_' . $control . '_control',
	[
		's_class_name'		=> $s_model_name.'_'.$s_fname,
		's_fieldname'		=> $s_model_nameid.'['.$s_fname.']',
		's_field_type'		=> 'hidden',
		's_selected_title'	=> '${'.$s_fname.'}',
		's_typein'			=> '',
		's_hint'			=> '',
	]
)