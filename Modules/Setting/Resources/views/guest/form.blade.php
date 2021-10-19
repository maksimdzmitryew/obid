@extends($theme . '::' . $_env->s_utype . '.master')

@php
include(base_path().'/resources/views/guest/crud.php');
@endphp



@section('title')
{!! mb_strtoupper($s_setting_action . ' &#60; ' . trans(request()->segment(1) . '::crud.names.plr')) !!}
@endsection

@include('public.partials._profile', ['s_id' => '#addsetting-form'])

@section('script')
<script type="text/javascript">
@include('admin.common.data2js')
</script>
@append

@section('content')

        <div id="main_map" style="display:none;" data-zoom="16">
            {{--<div class="marker" data-lat="50.405388" data-lng="30.3341461" data-icon="/{!! $theme !!}/img/map_markers/map_marker_bank.png"></div>
            <div class="marker" data-lat="50.4066782" data-lng="30.3410947" data-icon="/{!! $theme !!}/img/map_markers/map_marker_bank.png"></div>
            <div class="marker" data-lat="50.4063072" data-lng="30.3283194" data-icon="/{!! $theme !!}/img/map_markers/map_marker_wc.png"></div>
            <div class="marker" data-lat="50.4040143" data-lng="30.3339627" data-icon="/{!! $theme !!}/img/map_markers/map_marker_atm.png"></div>--}}
        </div>


        <div class="map_info_block">
            <div id="map_search" style="display:none;">
                <input type="text" settingholder="Поиск" name="s" />
                <button type="button" class="gotosearch"></button>
                <button type="button" class="findme" id="findme_btn"></button>
            </div>
            <div id="mib_content" class="visible_anytime">
                <div class="new_setting_wrap">

					@php
						$code				= NULL;
					@endphp

					<form action="{!! route('api.'.$s_category.'.store') !!}" method="POST" class="form-setting item-form" id="create-{!! $s_category !!}-form">
						@csrf

						@include('user._fields_loop', ['a_fields' => $_env->a_field['data'],])

						@foreach($localizations as $code => $localization)
							@include('user._fields_loop', ['a_fields' => $_env->a_field['data']['trans'],])
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

            </div>
        </div>
{{--

							<div class="user_fields">

								<div class="item">
									<span class="label">
										{!! trans('user/form.field.email') !!}
									</span>
									<span class="value">
										<input type="email" class="form-control"  settingholder="" name="email">
									</span>
								</div>

@include($theme . '::' . $_env->s_utype . '._recaptcha', ['id' => 'create-' . $s_category])

							</div>

							<div class="buttons">
								<button type="submit" class="confirm">{!! trans('personal::guest.button.add_new_setting') !!}</button>
							</div>
						</form>
--}}
@append

@section('css')
	@yield('css-checkbox')
    @yield('css-file')
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
    @yield('js-file')
	@yield('js-image')
	@yield('js-input')
	@yield('js-select')
	<script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
	<script src="{!! asset('/admin/js/forms.js?v=' . $version->js) !!}"></script>
@append

@section('script')
	@yield('script-checkbox')
    @yield('script-file')
    @yield('script-image')
	@yield('script-input')
	@yield('script-select')
@append