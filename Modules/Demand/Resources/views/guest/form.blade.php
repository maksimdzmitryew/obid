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

		<div class="map_info_block">
			<div id="map_search" style="display:none;">
				<input type="text" demandholder="Поиск" name="s" />
				<button type="button" class="gotosearch"></button>
				<button type="button" class="findme" id="findme_btn"></button>
			</div>
			{{-- <div id="mib_content" class="visible_anytime">--}}
				<div class="new_demand_wrap">

					@php
						$code				= NULL;
					@endphp

					<form action="{!! route('api.'.$s_category.'.store') !!}" method="POST" class="form-page item-form" id="create-{!! $s_category !!}-form">
						@csrf

						<div class="div_table">
							<div class="div_title">
								<p>{!! trans('personal::guest.button.add_new_demand') !!}</p>
							</div>

							@foreach ($o_courses AS $o_course)
							<div class="div_row" style="width:100%">
								<div style="width:100%">
									<p>{{ $o_course->title }}</p>
								</div>
							</div>

							<div class="div_heading">
								<div class="div_cell" style="width:15%">
									<p>&nbsp;</p>
								</div>

								@for ($d=0; $d < count($a_dates); $d++)
								<div class="div_cell" style="width:17%">
									<p>{{ \Carbon\Carbon::parse($a_dates[$d])->format('D j M') }}</p>
								</div>
								@endfor

							</div>

								@php $a_pos = array_keys($a_items[$o_course->id]); @endphp

								@for ($p = 0; $p < count($a_pos); $p++)
								@php $i_curr_pos = $a_pos[$p]; @endphp
							<div class="div_row">
								<div class="div_cell">
									<p>{{ $i_curr_pos }}</p>
								</div>

									@for ($d=0; $d < count($a_dates); $d++)
									@php $s_date = $a_dates[$d]; @endphp

								<div class="div_cell">
									<p class="div_meal_item">{{ $a_items[$o_course->id][$i_curr_pos][$s_date]->meal->title }} [id={{ $a_items[$o_course->id][$i_curr_pos][$s_date]->meal->id }}]</p>
								</div>

									@endfor

							</div>
								@endfor



							<div class="div_row">

								<div class="div_cell">
									<p>&nbsp;</p>
								</div>

								@for ($d=0; $d < count($a_dates); $d++)
								<div class="div_cell">
									<p>{{ \Carbon\Carbon::parse($a_dates[$d])->format('D j M') }}</p>
								</div>
								@endfor

							</div>
							@endforeach

						</div>



						<div style="clear: both;"></div>


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

						<div class="buttons">
							<button type="submit" class="confirm">
								{!! trans('personal::guest.button.add_new_' . $s_category) !!}
							</button>
						</div>

						<div class="divider"></div>
					</div>




						</form>


				</div>

			{{-- </div> --}}
		</div>
{{--

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

	$('form.item-form').on('submit', fnForm);

	$(document).on('click', '.div_meal_item', function (e) {
		fnSelect(e);
    });

});

fnSelect = function(e)
{
	alert('ok');
}

  </script>
@append
