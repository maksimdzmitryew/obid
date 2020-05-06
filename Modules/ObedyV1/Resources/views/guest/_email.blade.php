								<div class="item">
									<span class="label">
										{!! trans('user/form.field.email') !!}
									</span>
									<span class="value">
										<input type="email" class="form-control" placeholder="" name="email" value="{{
										isset($email)
										? $email
										: (old('email')
											? old('email')
											: isset($user) ? $user->email : ''
											)
										}}">
									</span>
								</div>
