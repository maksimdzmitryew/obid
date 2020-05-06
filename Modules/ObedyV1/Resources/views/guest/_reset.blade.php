					<div id="tab-reset" class="tab{{ request()->segment(1) == 'reset' ? ' opened' : '' }}">
						<div class="user_details">
							<div class="img" style="width: 10px;"></div>
							<div class="name">{!! trans('general.my-area') !!} <span>{{ trans('user/form.text.hint_reset') }}</span></div>
							<div class="divider"></div>
						</div>
						<form action="{!! route('password_token') !!}" method="POST" class="form-page" id="password-reset-form">
							@csrf

							<div class="user_fields">

@include($theme . '::' . $_env->s_utype . '._email')
@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'reset'])

							</div>
							<div class="buttons">
								<button type="submit" class="confirm">{!! trans('user/form.button.reset') !!}</button>
							</div>

						</form>
					</div>
