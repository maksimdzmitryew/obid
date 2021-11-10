					<div id="tab-change" class="tab{{ request()->segment(1) == 'change' ? ' opened' : '' }}">
						<div class="user_details">
							<div class="img" style="width: 10px;"></div>
							<div class="name">{!! trans('general.my-area', ['app_name' => trans('app.name')]) !!} <span>{{ trans('user/form.text.hint_change') }}</span></div>
							<div class="divider"></div>
						</div>
						<form action="{!! route('password_change') !!}" method="POST" class="form-page" id="password-change-form">
							@csrf

							<div class="user_fields">

@include($theme . '::' . $_env->s_utype . '._form_input',
	[
		's_id'				=> 'token',
		's_dataname'		=> 'token' . ($specific ?? ''),
		'item'				=> NULL,
		's_field_type'		=> 'text',
		's_selected_title'	=> $token ?? '',
	])

@include($theme . '::' . $_env->s_utype . '._password_twice', ['specific' => '_new'])
@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'change'])

							</div>
							<div class="buttons">
								<button type="submit" class="confirm">{!! trans('user/form.button.change') !!}</button>
							</div>

						</form>
					</div>
