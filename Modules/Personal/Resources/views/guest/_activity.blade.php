					<div id="tab-activity" class="tab{{ request()->segment(2) == 'activity' ? ' opened' : '' }}">

						<div class="buttons">
							<button type="submit" class="confirm">
								<a href="{!! route('guest.demand.week') !!}">
								{!! trans('personal::guest.button.add_new_demand') !!}
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
							<p class="p_date">
								{{ \Carbon\Carbon::parse($s_date)->format('D j M') }}:
								{{ $a_data['total'] }}₴
								{{ $activity[$s_date]['heavy'] }}гр.
								№{{ implode(',', $activity[$s_date]['position']) }}
							</p>
							<div class="
								plate_items_wrapper
								plate_items_wrapper_{{ $s_date }}
								{{ ( \Carbon\Carbon::now()->format('Y-m-d') != $s_date ? 'hidden' : '') }}
								"
							>
							@for ($i = 0; $i < count($a_data['plate_id']); $i++)
								<p class="smaller" data-date="{{ $s_date }}">
									{{ $a_data['position'][$i] }})
									{{ $a_data['price'][$i] }}₴
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
