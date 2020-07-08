					<div id="tab-activity" class="tab{{ request()->segment(2) == 'activity' ? ' opened' : '' }}">

						<div class="buttons">
							<button type="submit" class="confirm">
								<a href="{!! route('guest.demand.form') !!}">
								{!! trans('personal::guest.button.add_new_demand') !!}
								</a>
							</button>
						</div>

		@foreach ($activity AS $s_date => $a_data)
			<p>{{ \Carbon\Carbon::parse($s_date)->format('D j M') }}: {{ $a_data['total'] }}₴</p>
			@for ($i = 0; $i < count($a_data['id']); $i++)
			<p class="smaller">
				{{ $a_data['position'][$i] }})
				{{ $a_data['price'][$i] }}₴
				{{ $a_data['plate'][$i] }}
			</p>
			@endfor
		@endforeach

					</div>
