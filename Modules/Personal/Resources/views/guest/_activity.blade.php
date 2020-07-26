					<div id="tab-activity" class="tab{{ request()->segment(2) == 'activity' ? ' opened' : '' }}">

						<div class="buttons">
							<button type="submit" class="confirm">
								<a href="{!! route('guest.demand.week') !!}">
								@if($b_week)
								{!! trans('personal::guest.button.review_demand') !!}
								@else
								{!! trans('personal::guest.button.future_demand') !!}
								@endif
								</a>
							</button>
						</div>

					@foreach ($activity AS $s_date => $a_data)
						<div class="
								div_date_wrap
								{{ ( \Carbon\Carbon::now()->format('Y-m-d') == $s_date
										? 'today opened'
										: ( \Carbon\Carbon::now()->format('Y-m-d') < $s_date ? 'future' : 'past')
								) }}
								" data-date="{{ $s_date }}">

							<span class="calendar-item-icon">
								<span class="calendar-item-icon-day">{{ \Carbon\Carbon::parse($s_date)->translatedFormat('j') }}</span>
								<span class="calendar-item-icon-date">{{ \Carbon\Carbon::parse($s_date)->translatedFormat('D') }}</span>
							</span>

							<div class="user_details">

		<div class="div_date">
			<i class="far fa-user-circle"></i>
			<p>
				№{{ implode(',', $activity[$s_date]['position']) }}
			</p>
			<p class="smaller">
				{{ $a_data['total'] }}₴ {{ $activity[$s_date]['heavy'] }}гр.
			 </p>
		</div>



	@if (isset($totals[$s_date]) || isset($totals[$s_date]))
		<div class="div_date">
			<i class="far fa-users"></i>
			@if (isset($totals[$s_date]))
			<p>
				№{{ $totals[$s_date]['list'] }}
			</p>
			@endif
			@if (isset($totals[$s_date]))
			<p class="smaller">
				{{ $totals[$s_date]['total'] }}₴ {{ $totals[$s_date]['heavy'] }}гр.
			</p>
			@endif

		</div>
 	@endif


							</div>


							<div class="
								plate_items_wrapper
								plate_items_wrapper_{{ $s_date }}
								{{ ( \Carbon\Carbon::now()->format('Y-m-d') != $s_date ? 'hidden' : '') }}
								"
							>
							@for ($i = 0; $i < count($a_data['plate_id']); $i++)
								<p class="smaller" data-date="{{ $s_date }}">
									{{ $a_data['position'][$i] }})
									{{ $a_data['price'][$i] }}₴</i>
									{{ $a_data['meal_title'][$i] }}
								</p>
							@endfor
							</div>
						</div>
					@endforeach

					</div>

@section('script')
 	<script type="text/javascript">

	$(document).ready(() => {

		$('.div_date_wrap').click(function (e) {
			let
				target		= $(e.currentTarget),
				date		= target.data('date');

			$('.plate_items_wrapper').hide();
			$('.plate_items_wrapper_' + date).show();


			$('.div_date_wrap').removeClass('opened');
			if (target.hasClass('opened'))
			{
				target.removeClass('opened');
			}
			else
			{
				target.addClass('opened');
			}
			target.addClass('opened');

	    });

	});

 	</script>
@append
