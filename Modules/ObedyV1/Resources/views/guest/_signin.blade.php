					<div id="tab-signin" class="tab{{ request()->segment(1) == 'signin' ? ' opened' : '' }}">
						<div class="user_details">
							{{-- <div class="img" style="width: 10px;"></div> --}}
							<div class="name">{!! trans('general.my-area', ['app_name' => trans('app.name')]) !!} <span>{{ trans('user/form.text.hint_in') }}</span></div>
							<div class="divider"></div>
						</div>
						<form action="{!! route('signin_page') !!}" method="POST" class="form-page" id="signin-form">
							@csrf

							<div class="user_fields">

@include($theme . '::' . $_env->s_utype . '._email')
@include($theme . '::' . $_env->s_utype . '._password')










{{--
--}}
								<div class="field_row" data-name="safety_options">
									<label for="safety_options">
										<span class="label">
											{!! trans('user/form.field.safety_options') !!}
										</span>
									</label>

<section class="radio_wrap">

{{--
									<div class="value">
--}}
										@for ($i = 0; $i < 3; $i++)


<div class="radio_wrap">
  <input type="radio" name="login_safety" value="{!! $i !!}" {!! $i == $safety ? 'checked="checked"' : '' !!} id="login_safety_{{ $i }}" >
  <label for="login_safety_{{ $i }}">
    <h2>{{ trans('user/form.button.remember-' . $i) }}</h2>
    <p>{{ trans('user/form.text.remember-' . $i) }}</p>
  </label>
</div>
{{--
										<div class="radio_wrap">

<input type="radio" name="login_safety" value="{!! $i !!}"  {!! $i == $safety ? 'checked="checked"' : '' !!} id="login_safety_{!! $i !!}">
<label for="login_safety_{!! $i !!}">{{ trans('user/form.button.remember-' . $i) }}</label>
<input type="radio" class="radio" name="x" value="y" id="y" />
    <label for="y">Thing 1</label>
											<span class="radio_button">
												<input type="radio" name="login_safety" value=" {!! $i !!}"  {!! $i == $safety ? 'checked="checked"' : '' !!}>
											</span>
											<span class="radio_label">{{ trans('user/form.button.remember-' . $i) }}</span>
										</div>
--}}
										@endfor
{{--
									</div>
--}}



</section>
<p>&nbsp;</p>

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
