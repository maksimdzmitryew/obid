@include($theme . '::' . $_env->s_utype . '._form_input',
	[
		's_id'				=> 'password',
		's_dataname'		=> 'password' . ($specific ?? ''),
		'item'				=> $user ?? NULL,
		's_field_type'		=> 'password',
		's_selected_title'	=> '',
	])
{{--
								<div class="item" data-name="password{!! $specific ?? '' !!}">
									<span class="label">
										{!! trans('user/form.field.password' . ($specific ?? '') ) !!}
									</span>
									<span class="value">
										<input type="password" class="form-control" placeholder="{!! trans('user/form.field.password' . ($specific ?? '') ) !!}" name="password{!!  ($specific ?? '') !!}">
									</span>
								</div>
--}}
