					<div id="tab-activity" class="tab{{ request()->segment(2) == 'activity' ? ' opened' : '' }}">

						<div class="buttons">
							<button type="submit" class="confirm">
								<a href="{!! route('guest.demand.form') !!}">
								{!! trans('personal::guest.button.add_new_demand') !!}
								</a>
							</button>
						</div>

					</div>
