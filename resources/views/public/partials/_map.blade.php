@php
$s_category = 'place';
#include(base_path().'/resources/views/guest/crud.php');

$s_tmp				= request()->route()->getAction()['as'];
$a_tmp				= explode('.', $s_tmp);
#$s_category			= mb_strtolower($a_tmp[1]);

$s_form_route		= mb_strtolower($a_tmp[1]).'.'.mb_strtolower($a_tmp[2]);
$s_utype			= $a_tmp[0];

$s_create_route		= route($s_utype.'.'.$s_form_route);
$s_cancel_route		= route($s_utype . '.personal.places');
$s_list_route		= route($s_utype . '.personal.places');
$s_opinion_route	= route($s_utype . '.opinion.form', [':type', ':id']);

$s_btn_primary		= '';
$s_route_primary	= '';
$s_btn_secondary	= trans('common/form.actions.evaluate');
$s_route_secondary	= $s_opinion_route;
$s_btn_extra		= '';
$s_route_extra		= '';

if (Request::getHost() == 'pr.max')
	$b_dev					= TRUE;
else
	$b_dev					= FALSE;

$f_map_center_lat			= 50.45466;
$f_map_center_lng			= 30.5238;
$i_map_zoom					= 11;
if ($b_dev)
{
	$f_map_center_lat			= 50.458295;
	$f_map_center_lng			= 30.599699;
	$i_map_zoom					= 13;
}

@endphp
@section('script')
	<script type="text/javascript">
	let google_map_key				= '{!! config('services.google.map.key') !!}'
		,s_route_list				= '{!! route('api.'.$s_category.'.index') !!}'
		,s_servererror_info			= '{!! trans('user/session.text.server_err_info') !!}'
		,s_theme					= '{!! $theme !!}'

		,s_text_extra				= '{!! $s_btn_extra !!}'
		,s_route_extra				= '{!! $s_route_extra !!}'
		,s_text_primary				= '{!! $s_btn_primary !!}'
		,s_route_primary			= '{!! $s_route_primary !!}'
		,s_text_secondary			= '{!! $s_btn_secondary !!}'
		,s_route_secondary			= '{!! $s_route_secondary !!}'
		,s_close_route				= '{!! $s_cancel_route !!}'

		;
	</script>
@append
@section('js')
	<script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key={!! config('services.google.map.key') !!}"></script>
	<script src="/js/map.js?v={!! $version->js !!}"></script>
@append


{{-- https://loading.io/spinner/earth/-earth-globe-map-rotate --}}
<div class="map_preloader_wrap">
	<div class="map_preloader_spinner">
		<img src="/images/spinner_earth.svg" width="120" height="120" />
	</div>
</div>

<div id="main_map" data-zoom="{!! $i_map_zoom !!}" data-lat="{!! $f_map_center_lat !!}" data-lng="{!! $f_map_center_lng !!}"></div>

{{--
<div class="map_info_block">
	<div id="map_search" style="display:none;" >
		<input type="text" placeholder="Поиск" name="s" />
		<button type="button" class="gotosearch"></button>
		<button type="button" class="findme" id="findme_btn"></button>
	</div>
	<div id="mib_content" style="display:none;" >
		<div class="filters">
			<ul>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_1" />
					<label for="sdsdf_1">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_shipping.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_shipping_white.png"> <span>Shopping</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_2" checked />
					<label for="sdsdf_2">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_food.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_food_white.png"> <span>Food & Drinks</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_3" />
					<label for="sdsdf_3">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_health.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_health_white.png"> <span>Health</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_4" />
					<label for="sdsdf_4">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_transport.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_transport_white.png"> <span>Transport</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_5" />
					<label for="sdsdf_5">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_leisure.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_leisure_white.png"> <span>Leisure</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_6" />
					<label for="sdsdf_6">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_hotels.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_hotels_white.png"> <span>Hotels</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_7" />
					<label for="sdsdf_7">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_tourism.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_tourism_white.png"> <span>Tourism</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_8" />
					<label for="sdsdf_8">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_education.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_education_white.png"> <span>Education</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_9" />
					<label for="sdsdf_9">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_autorities.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_autorities_white.png"> <span>Authorities</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_10" />
					<label for="sdsdf_10">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_money.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_money_white.png"> <span>Money</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_11" />
					<label for="sdsdf_11">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_sport.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_sport_white.png"> <span>Sport</span>
					</label>
				</li>
				<li>
					<input type="radio" name="filters" value="sdsdf" id="sdsdf_12" />
					<label for="sdsdf_12">
						<img class="img_blue" src="/{!! $theme !!}/img/markers/marker_toilets.png" /><img class="img_white" src="/{!! $theme !!}/img/markers/marker_toilets_white.png"> <span>Toilets</span>
					</label>
				</li>
			</ul>
		</div>


		<div class="subfilters">
			<div class="scroll_wrap">
				<ul>
					<li>
						<div class="item">
							<input type="radio" name="subfilters_row_1" value="sbfr_1_v_1" id="sbfr_1_v_1"	checked />
							<label for="sbfr_1_v_1">
								<span class="marker green"><img src="/{!! $theme !!}/img/markers/marker_invalid.png" /></span> <span class="text"><b>Доступно</b> для кресел-каталок</span>
							</label>
						</div>
						<div class="item">
							<input type="radio" name="subfilters_row_1" value="sbfr_1_v_2" id="sbfr_1_v_2" />
							<label for="sbfr_1_v_2">
								<span class="marker orange"><img src="/{!! $theme !!}/img/markers/marker_invalid.png" /></span> <span class="text"><b>Частично доступно</b> для кресел-каталок</span>
							</label>
						</div>
						<div class="item">
							<input type="radio" name="subfilters_row_1" value="sbfr_1_v_3" id="sbfr_1_v_3" />
							<label for="sbfr_1_v_3">
								<span class="marker red"><img src="/{!! $theme !!}/img/markers/marker_invalid.png" /></span> <span class="text"><b>Не доступно</b> для кресел-каталок</span>
							</label>
						</div>
					</li>
					<li>
						<div class="item">
							<input type="radio" name="subfilters_row_2" value="sbfr_2_v_1" id="sbfr_2_v_1" checked />
							<label for="sbfr_2_v_1">
								<span class="marker green"><img src="/{!! $theme !!}/img/markers/marker_babycar.png" /></span> <span class="text"><b>Доступно</b> для колясок</span>
							</label>
						</div>
						<div class="item">
							<input type="radio" name="subfilters_row_2" value="sbfr_2_v_2" id="sbfr_2_v_2" />
							<label for="sbfr_2_v_2">
								<span class="marker orange"><img src="/{!! $theme !!}/img/markers/marker_babycar.png" /></span> <span class="text"><b>Частично доступно</b> для колясок</span>
							</label>
						</div>
						<div class="item">
							<input type="radio" name="subfilters_row_2" value="sbfr_2_v_3" id="sbfr_2_v_3" />
							<label for="sbfr_2_v_3">
								<span class="marker red"><img src="/{!! $theme !!}/img/markers/marker_babycar.png" /></span> <span class="text"><b>Не доступно</b> для колясок</span>
							</label>
						</div>
					</li>
					<li>
						<div class="item">
							<input type="radio" name="subfilters_row_3" value="sbfr_3_v_1" id="sbfr_3_v_1" checked />
							<label for="sbfr_3_v_1">
								<span class="marker green"><img src="/{!! $theme !!}/img/markers/marker_transport_white.png" /></span> <span class="text"><b>Доступно</b> для парковок</span>
							</label>
						</div>
						<div class="item">
							<input type="radio" name="subfilters_row_3" value="sbfr_3_v_2" id="sbfr_3_v_2" />
							<label for="sbfr_3_v_2">
								<span class="marker orange"><img src="/{!! $theme !!}/img/markers/marker_transport_white.png" /></span> <span class="text"><b>Частично доступно</b> для парковок</span>
							</label>
						</div>
						<div class="item">
							<input type="radio" name="subfilters_row_3" value="sbfr_3_v_3" id="sbfr_3_v_3" />
							<label for="sbfr_3_v_3">
								<span class="marker red"><img src="/{!! $theme !!}/img/markers/marker_transport_white.png" /></span> <span class="text"><b>Не доступно</b> для парковок</span>
							</label>
						</div>
					</li>
				</ul>
			</div>
		</div>

	</div>
</div>
--}}
