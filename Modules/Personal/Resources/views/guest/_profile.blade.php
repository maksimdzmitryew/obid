					<div id="tab-profile" class="tab{{ request()->segment(2) == 'profile' ? ' opened' : '' }}">

						<div class="user_details">
							<div class="img" style="background-image: url('/{!! $theme !!}/img/author.png')"></div>
							<div class="name">
								{{ $user->first_name }}
								{{ $user->last_name }}
								<span>{{ $user->email }}</span>
							</div>
							<div class="other">
								{{--<div class="rate">12 баллов</div>--}}
								{{--<div class="reviews">13 отзывов</div>--}}
							</div>
							<div class="divider"></div>
						</div>

						<form action="{!! route('guest.personal.profile') !!}" method="POST" class="form-page" id="profile-form">
							@csrf

							<div class="user_fields">

@include($theme . '::' . $_env->s_utype . '._form_input', ['s_id' => 'first_name', 'item' => $user, ])
@include($theme . '::' . $_env->s_utype . '._form_input', ['s_id' => 'last_name', 'item' => $user, ])

{{--
								<div class="item">
									<span class="label">
										{!! trans('crud.field.name_first.label') !!}
									</span>
									<span class="value">
										<input type="text" class="form-control" placeholder="{!! trans('crud.hint.input') !!} {!! trans('crud.field.name_first.typein') !!}" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}">
									</span>
								</div>

								<div class="item">
									<span class="label">
										{!! trans('crud.field.name_last.label') !!}
									</span>
									<span class="value">
										<input type="text" class="form-control" placeholder="{!! trans('crud.hint.input') !!} {!! trans('crud.field.name_last.typein') !!}" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}">
									</span>
								</div>
--}}

@include($theme . '::' . $_env->s_utype . '._email')
@include($theme . '::' . $_env->s_utype . '._password_triple')

@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'profile'])

							</div>
							<div class="buttons">
								<button type="submit" class="confirm">{!! trans('personal::guest.button.change') !!}</button>
							</div>

						</form>
					</div>
