@include($theme . '::' . $_env->s_utype . '._form_input', ['s_id' => 'email', 'item' => $user ?? NULL, ])
{{--
								<div class="item" data-name="email">
									<span class="label">
										{!! trans('crud.field.email.label') !!}
									</span>
									<span class="value">
										<input type="email" class="form-control" placeholder="{!! trans('crud.hint.input') !!} {!! trans('crud.field.email.typein') !!}" name="email" value="{{
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