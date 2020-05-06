					<div id="tab-signin" class="tab{{ request()->segment(1) == 'signin' ? ' opened' : '' }}">
						<div class="user_details">
							<div class="img" style="width: 10px;"></div>
							<div class="name">{!! trans('general.my-area') !!} <span>{{ trans('user/form.text.hint_in') }}</span></div>
							<div class="divider"></div>
						</div>
						<form action="{!! route('signin_page') !!}" method="POST" class="form-page" id="signin-form">
							@csrf

							<div class="user_fields">

@include($theme . '::' . $_env->s_utype . '._email')
@include($theme . '::' . $_env->s_utype . '._password')

								<div class="item">
									<span class="label">
										{!! trans('user/form.field.safety_options') !!}
									</span>
									<span class="value">
										@for ($i = 0; $i < 3; $i++)
										<div class="radio_wrap">
											<div><input type="radio" name="login_safety" value=" {!! $i !!}"  {!! $i == $safety ? 'checked="checked"' : '' !!}></div>
											<div class="radio_label">{{ trans('user/form.button.remember-' . $i) }}</div>
										</div>
										@endfor
									</span>
								</div>

@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'signin'])

							</div>
							<div class="buttons">
								<button type="submit" class="confirm">{!! trans('user/form.button.signin') !!}</button>
							</div>

							<div class="div_reset_password">
								<a href="{!! route('password_reset') !!}">{!! trans('user/form.button.forgot') !!}</a>
							</div>
						</form>
					</div>
