@include($theme . '::' . $_env->s_utype . '._form_input', ['s_id' => 'email', 'item' => $user ?? NULL, ])
{{--
								<div class="item" data-name="email">
									<span class="label">
										{!! trans('user/form.field.email') !!}
									</span>
									<span class="value">
										<input type="email" class="form-control" placeholder="{!! trans('user/form.field.email') !!}" name="email" value="{{
										(
											isset($email)
											? $email
											:	(
													old('email')
													? old('email')
													: isset($user) ? $user->email : ''
												)
										)
										}}">
									</span>
								</div>
--}}