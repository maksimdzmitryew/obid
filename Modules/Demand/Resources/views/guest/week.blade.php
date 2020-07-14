@extends($theme . '::' . $_env->s_utype . '.master')

@php
include(base_path().'/resources/views/guest/crud.php');
@endphp



@section('title')
{!! mb_strtoupper($s_page_action . ' &#60; ' . trans(request()->segment(1) . '::crud.names.plr')) !!}
@endsection

@include('public.partials._profile', ['s_id' => '#adddemand-form'])

@section('script')
<script type="text/javascript">
@include('admin.common.data2js')
</script>
@append

@section('content')
	<form action="{!! ($b_week ? route('api.'.$s_category.'.update', $$s_category->id) : route('api.'.$s_category.'.store')) !!}" method="POST" class="form-page item-form" id="create-{!! $s_category !!}-form">
		@csrf

	<div class="sticky">
		<div class="buttons">
			<button type="submit" class="confirm">
			@if($b_week)
			{!! trans('personal::guest.button.modify_' . $s_category) !!}
			@else
			{!! trans('personal::guest.button.add_new_' . $s_category) !!}
			@endif
			</button>
		</div>
		<div class="div_table">
			<div class="div_row">
				<div class="div_cell" style="width:5%">
					<p>&nbsp;</p>
				</div>
				@for ($d=0; $d < count($a_dates); $d++)
				@php
					$s_date			= $a_dates[$d];
					$s_changeable	= ($s_date > \Carbon\Carbon::now()->format('Y-m-d') ? '' : '_old');
					$s_relative		= (
										$s_date == \Carbon\Carbon::now()->format('Y-m-d') ? 'today'
										: (
											$s_date > \Carbon\Carbon::now()->format('Y-m-d') ? 'future' : 'past'
											)
										);
				@endphp

				<div class="div_cell" style="width:19%">
					<div>
						<p class="{!! $s_relative !!}">{{ \Carbon\Carbon::parse($a_dates[$d])->translatedFormat('l j F') }}</p>
						<p class="p_totals">
							<span 
								class="demand_{{ $s_date }}_total"
								id="demand_{{ $s_date }}_total"
								style="font-weight: bold;"
								data-sum_price="{{ (isset($activity[$s_date])) ? $activity[$s_date]['total'] : 0 }}"
							>
								@if (isset($activity[$s_date]))
								{{ $activity[$s_date]['total'] }}₴
								@else
								0₴
								@endif
							</span>
							<span 
								id="demand_{{ $s_date }}_weight"
								class="smaller"
								data-sum_weight="{{ (isset($activity[$s_date])) ? $activity[$s_date]['heavy'] : 0 }}"
							>
								@if (isset($activity[$s_date]))
								{{ $activity[$s_date]['heavy'] }}гр.
								@else
								0гр.
								@endif
							</span>
							<span
								id="demand_{{ $s_date }}_nums"
								class="demand_{{ $s_date }}_nums" style="font-weight: normal;"
							>@if (isset($activity[$s_date]))№{{ implode(',', $activity[$s_date]['position']) }}@endif</span>
						</p>
						<div id="demand_{{ $s_date }}_list" class="smaller" data-date="{{ $s_date }}">

						@if (isset($activity[$s_date]))
						@php
							$a_data			= $activity[$s_date];
						@endphp
						@for ($i = 0; $i < count($a_data['plate_id']); $i++)
							<p class="div_meal_item{!! $s_changeable !!} selected" data-meal_id="{{ $a_data['meal_id'][$i] }}" data-plate_id="{{ $a_data['plate_id'][$i] }}" data-course_id="{{ $a_data['course_id'][$i] }}" data-position="{{ $a_data['position'][$i] }}" data-date="{{ $s_date }}" data-price="{{ $a_data['price'][$i] }}" data-weight="{{ $a_data['weight'][$i] }}" id="list_{{ $a_data['course_id'][$i] }}_{{ $s_date }}_{{ $a_data['meal_id'][$i] }}" title="{{ $a_data['meal_title'][$i] }}">{{ $a_data['price'][$i] }}₴ {{ mb_substr($a_data['meal_title'][$i],0,30) }}</p>
						@endfor
						@endif

						</div>
					</div>
				</div>

				@endfor
			</div>
		</div>

	</div>

											{{-- <div class="map_info_block">
												<div id="map_search" style="display:none;">
													<input type="text" demandholder="Поиск" name="s" />
													<button type="button" class="gotosearch"></button>
													<button type="button" class="findme" id="findme_btn"></button>
												</div>--}}
												{{-- <div id="mib_content" class="visible_anytime">
													<div class="new_demand_wrap">--}}

	@php
		$code				= NULL;
	@endphp


		<div class="div_table">
			<div class="div_title">
			</div>

			@foreach ($o_courses AS $o_course)
			@php $i_course_id = $o_course->id; @endphp
			
			<div class="div_heading">
				<div class="div_cell" style="width:5%">
					&nbsp;
				</div>
				<div class="div_cell" style="width:19%">
					{{ $o_course->title }}
				</div>

				@for ($d=0; $d < count($a_dates) - 1; $d++)
				<div class="div_cell" style="width:19%">
					&nbsp;
				</div>
				@endfor

			</div>

				@php $a_pos = array_keys($a_items[$i_course_id]); @endphp

				@for ($p = 0; $p < count($a_pos); $p++)
				@php $i_curr_pos = $a_pos[$p]; @endphp
				
			<div class="div_row">
				<div class="div_cell" style="width:5%">
					<p>{{ $i_curr_pos }}</p>
				</div>

					@for ($d=0; $d < count($a_dates); $d++)
					@php 
						$s_date			= $a_dates[$d]; 
						$i_meal_id		= $a_items[$i_course_id][$i_curr_pos][$s_date]->meal->id;
						$i_plate_id		= $a_items[$i_course_id][$i_curr_pos][$s_date]->id;
						$b_selected		= FALSE;
						$s_changeable	= ($s_date > \Carbon\Carbon::now()->format('Y-m-d') ? '' : '_old');

						if (isset($activity[$s_date]) && in_array($i_plate_id, $activity[$s_date]['plate_id']))
						{
							$b_selected	= TRUE;
						}
					@endphp

				<div 
					class="div_cell div_meal_item{!! $s_changeable !!} meal_id_{{ $i_meal_id }} {{ $b_selected ? 'selected' : '' }}"
					id="plate_{{ $i_course_id }}_{{ $s_date }}_{{ $i_meal_id }}"
					data-meal_id="{{ $i_meal_id }}"
					data-plate_id="{{ $i_plate_id }}"
					data-course_id="{{ $i_course_id }}"
					data-position="{{ $i_curr_pos }}"
					data-date="{{ $s_date }}"
					data-price="{{ $a_items[$i_course_id][$i_curr_pos][$s_date]->price }}"
					data-weight="{{ $a_items[$i_course_id][$i_curr_pos][$s_date]->weight }}"
					>
					<p class="meal_id_{{ $i_meal_id }}_title {{ $b_selected ? 'selected' : '' }}"
					>{{ $a_items[$i_course_id][$i_curr_pos][$s_date]->meal->title }}</p>
					<input 
						class="form-control"
						id="{{ $i_plate_id }}"
						name="plate_ids[]" 
						type="hidden"
						value="{{ $b_selected ? $i_plate_id : '' }}"
					>
				</div>

					@endfor

			</div>
				@endfor
			@endforeach
		</div>

										{{--
												@foreach ($o_items AS $k => $v)
												<div>
													{{ $v->date }}
													{{ $v->position }}
													{{ $v->meal->title }}
												</div>
												@endforeach
										--}}
												@include('user._fields_loop', ['a_fields' => $_env->a_field['data'],])
												@foreach($localizations as $code => $localization)
													@if (isset($_env->a_field['data']['trans']))
													@include('user._fields_loop', ['a_fields' => $_env->a_field['data']['trans'],])
													@endif
												@endforeach
												@php ($code = NULL) @endphp

											<div class="buttons">

										{{--
										@include('layouts._form_control', ['control' => 'image', 'name' => 'image_ids'])
										--}}

										{{--
												<div id="image-preview"></div>
												<div class="attach">
													<label for="image-upload" id="image-label">Прикрепить фото</label>
													<input type="file" name="image" id="image-upload" />
												</div>
										--}}

@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'create-' . $s_category])
{{--
				<button type="submit" class="confirm">
					{!! trans('personal::guest.button.add_new_' . $s_category) !!}
				</button>
--}}
			<div class="divider"></div>
		</div>

		<div style="display:none;">
		@include('layouts._form_control', ['control' => 'checkbox', 'name'=>'published'])
		</div>

	</form>


													{{-- </div> --}}

												{{-- </div> --}}
									{{--
											</div>

																<div class="user_fields">

																	<div class="item">
																		<span class="label">
																			{!! trans('user/form.field.email') !!}
																		</span>
																		<span class="value">
																			<input type="email" class="form-control"  demandholder="" name="email">
																		</span>
																	</div>

									@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'create-' . $s_category])

																</div>

																<div class="buttons">
																	<button type="submit" class="confirm">{!! trans('personal::guest.button.add_new_demand') !!}</button>
																</div>
															</form>
									--}}
@append

@section('css')
	@yield('css-checkbox')
	@yield('css-image')
	@yield('css-input')
	@yield('css-select')
@endsection

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQueryFormStyler/2.0.2/jquery.formstyler.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
@append

@section('js')
	@yield('js-checkbox')
	@yield('js-image')
	@yield('js-input')
	@yield('js-select')
	<script src="{!! asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') !!}"></script>
@append

@section('script')
	@yield('script-checkbox')
	@yield('script-image')
	@yield('script-input')
	@yield('script-select')

 	<script type="text/javascript">

	$(document).ready(() => {

//		$('form.item-form').on('submit', fnForm);

		$('.div_meal_item').click(function (e) {
			fnClick(e);
	    });
	});

	fnClick = function(e)
	{
		target		= $(e.currentTarget),
		container	= $('#demand_' + target.data('date') + '_list'),
		meal_id		= target.data('meal_id'),
		plate_id	= target.data('plate_id'),
		course_id	= target.data('course_id'),
		position	= target.data('position'),
		date		= target.data('date'),
		price		= target.data('price'),
		weight		= target.data('weight'),
		element_id	= '.meal_id_' + target.data('meal_id')
		;
		s_demand_id	= 'list_' + course_id+'_'+date+'_'+meal_id,
		s_plate_id	= 'plate_' + course_id+'_'+date+'_'+meal_id,
		s_total_id	= 'demand_'+date+'_total',
		s_total_num	= 'demand_'+date+'_nums',
		s_weight_id	= 'demand_'+date+'_weight',
		title_id	= element_id+'_title',
		sum_price	= $('#'+s_total_id).attr('data-sum_price'),
		sum_weight	= $('#'+s_weight_id).attr('data-sum_weight'),
		input_id	= '#' + plate_id
		;

		// initialise total for the day
		if (typeof $('#' + s_total_id).prop('total') === 'undefined')
		{
			$('#' + s_total_id).prop('total', sum_price);
		}
		if (typeof $('#' + s_weight_id).prop('weight') === 'undefined')
		{
			$('#' + s_weight_id).prop('weight', sum_weight);
		}

		if ($('#' + s_plate_id).hasClass('selected'))
		{
			//$('#' + s_plate_id).removeClass('selected');
			fnRemove();
		}
		else
		{
			fnSelect();
		}
	}

	fnSelect = function()
	{
		$('#' + s_plate_id).addClass('selected');

		a_sub_space = $(title_id).html().split(' ');

		s_title = $(title_id).html()
		if ($(title_id).html().length > 30)
		{
			s_title = '';
			a_sub_space.forEach((s_sub_space) => {
				if (s_sub_space.indexOf(',') > -1)
				{
					a_sub_comma = s_sub_space.split(',');
					a_sub_comma.forEach((s_sub_comma) => {
						if(s_sub_comma.length > 0 && s_title.length + s_sub_comma.length < 30)
						{
							s_title += s_sub_comma + ',';
						}
					});
				}
				else if(s_sub_space.length > 0 && s_title.length + s_sub_space.length < 30)
				{
					s_title += s_sub_space + ' ';
				}
			});
			s_title = s_title.slice(0, -1) + '&hellip;';
		}

		node = $('<p>', {
				'class': 'div_meal_item selected',
				'data-meal_id':		meal_id,
				'data-plate_id':	plate_id,
				'data-course_id':	course_id,
				'data-position':	position,
				'data-date':		date,
				'data-price':		price,
				'data-weight':		weight,
				'id':				s_demand_id,
				'title':			$(title_id).html()
			} )
			.html( (parseInt(price)) + '₴ ' + s_title )
			.appendTo( container );

		// total amount without newly selected item
		total = (parseFloat($('#' + s_total_id).prop('total')));
		//add position at provider’s list
		$('.' + s_total_num).text($('#' + s_total_num).text() + (total > 0 ? ',' : '№') + position);
		// add meal price to the total
		total = ( total + parseFloat(price));
		// update total visual
		$('.' + s_total_id).text(total+ '₴');
		// store total value
		$('#' + s_total_id).prop('total', total);

		sum_weight = (parseFloat($('#' + s_weight_id).prop('weight')));
		sum_weight = ( sum_weight + parseFloat(weight));
		$('#' + s_weight_id).text(sum_weight+ 'гр.');
		$('#' + s_weight_id).prop('weight', sum_weight);

		$(input_id).val(plate_id);
		$('#' + s_demand_id).click(function (e) {
			fnClick(e);
	    });
	}

	fnRemove = function()
	{
		$('#' + s_demand_id).remove();
		$('#' + s_plate_id).removeClass('selected');

		total = ( parseFloat($('#' + s_total_id).prop('total')) - parseFloat(price));
		$('.' + s_total_id).text(total+ '₴');
		$('#' + s_total_id).prop('total', total);

		$(input_id).val('');
		s_nums = $('#' + s_total_num).text() + ',';
		s_nums = s_nums.replace(position + ',', '').slice(0,-1);
		$('.' + s_total_num).text( s_nums );

		weight = ( parseFloat($('#' + s_weight_id).prop('weight')) - parseFloat(weight));
		$('#' + s_weight_id).text(weight+ 'гр.');
		$('#' + s_weight_id).prop('weight', weight);

	}

 	</script>
@append
