					<div id="tab-signup" class="tab{{ request()->segment(1) == 'signup' ? ' opened' : '' }}">
						<div class="user_details">
							{{-- <div class="img" style="width: 10px;"></div> --}}
							<div class="name">{!! trans('general.my-area', ['app_name' => trans('app.name')]) !!} <span>{{ trans('user/form.text.hint_up') }}</span></div>
							<div class="divider"></div>
						</div>
						<form action="{!! route('signup_user') !!}" method="POST" class="form-page" id="signup-form">
							@csrf

							<div class="user_fields">

@include($theme . '::' . $_env->s_utype . '._email')

@include($theme . '::' . $_env->s_utype . '._password_twice')
@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'signup'])

							</div>
							<div class="buttons">
								<button type="submit" class="confirm">{!! trans('user/form.button.signup') !!}</button>
							</div>
						</form>
					</div>
