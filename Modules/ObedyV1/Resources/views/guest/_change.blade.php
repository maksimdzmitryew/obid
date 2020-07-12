					<div id="tab-change" class="tab{{ request()->segment(1) == 'change' ? ' opened' : '' }}">
						<div class="user_details">
							<div class="img" style="width: 10px;"></div>
							<div class="name">{!! trans('general.my-area') !!} <span>{{ trans('user/form.text.hint_change') }}</span></div>
							<div class="divider"></div>
						</div>
						<form action="{!! route('password_change') !!}" method="POST" class="form-page" id="password-change-form">
							@csrf

							<div class="user_fields">
								<div class="item" data-name="token">
									<span class="label">
										{!! trans('user/form.field.token') !!}
									</span>
									<span class="value">
										<input type="text" class="form-control" placeholder="{{ trans('user/form.text.token_hint') }}" name="token" value="{!! $token ?? '' !!}">
									</span>
								</div>

@include($theme . '::' . $_env->s_utype . '._password_twice', ['specific' => '_new'])
@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'change'])

							</div>
							<div class="buttons">
								<button type="submit" class="confirm">{!! trans('user/form.button.change') !!}</button>
							</div>

						</form>
					</div>
