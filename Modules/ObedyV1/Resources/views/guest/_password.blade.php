								<div class="item" data-name="password{!! $specific ?? '' !!}">
									<span class="label">
										{!! trans('user/form.field.password' . ($specific ?? '') ) !!}
									</span>
									<span class="value">
										<input type="password" class="form-control" placeholder="{!! trans('user/form.field.password' . ($specific ?? '') ) !!}" name="password{!!  ($specific ?? '') !!}">
									</span>
								</div>
