@section('js')
<!-- http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm -->
@if (Cookie::get( config('cookie-consent.cookie_name') ) !== null)
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.key') }}"></script>
@endif
<script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
<script src="{!! asset('/admin/js/forms.js?v=' . $version->js) !!}"></script>
@append

@section('script')
<script type="text/javascript">
	@if (config('app.env') != 'local')
	let reCAPTCHA_site_key = '{{ config('services.google.recaptcha.key') }}';
	@endif
	$(document).ready(() => {

//swal("Gotcha!", "Pikachu was caught!", "success");

		setInterval(refreshToken, 1000 * 60); // 1 min

		function reCAPTCHA_execute () {
			timepassed = Math.round((Date.now() - i_reCAPTCHA_update_time) / 1000) * 1000;
			if ( timepassed < i_reCAPTCHA_refresh_time || !b_focus_status) return true;

			grecaptcha.execute(reCAPTCHA_site_key, {action: 'login'}).then(function(token) {
//console.log('reCAPTCHA updated=' + (s_reCAPTCHA != token), Math.round(timepassed / 1000) + 's ' + Math.round(timepassed / 1000 / 60) + 'm');
				if (s_reCAPTCHA != token)
				{
					$('[name="g-recaptcha-response"]').val(token);
					i_reCAPTCHA_update_time		= Date.now();
				}
			}, function (reason) {
			});
		}

		if (typeof grecaptcha !== 'undefined' && typeof reCAPTCHA_site_key !== 'undefined') {
			@if ((Auth::user() === NULL))
			grecaptcha.ready(reCAPTCHA_execute);
			a_check_focus.push(reCAPTCHA_execute);
			setInterval(reCAPTCHA_execute, 1000 * 60); // 1 min
			@endif
		}

		// fn_form can be found in
		// forms.js
		$('{!! $s_id !!}').on('submit', fnForm);
/*
		// TODO: refactoring
		// look at forms.js
		$('{!! $s_id !!}').on('submit', (e) => {
			e.preventDefault();

			let form = $(e.currentTarget);

			$.ajax({
				'type': 'post',
				'url': form.attr('action'),
				'data': form.serialize(),
				success: (data, status, xhr) => {
					if (xhr.readyState == 4 && xhr.status == 200)
						try {
							// Do JSON handling here
							tmp = JSON.parse(xhr.responseText);

							if (typeof tmp.url === 'undefined')
								s_route_primary = '';//window.location.href;//location.reload(true);
							else
								//window.location = data.url;
								s_route_primary = data.url;


		s_text_primary = '{!! trans('user/messages.button.ok') !!}';
		s_text_secondary = '';
		s_text_extra = '';

			setSwalParams(data);

			a_params.icon = 'info';


			Swal.fire(
				a_params
			).then((result) => {
				if (result.value) {
					if (s_route_primary != '')
						window.location.href = s_route_primary;
					else
						resetForm(form);
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					if (s_route_secondary != '')
						window.location.href = s_route_secondary;
					else
						resetForm(form);
				}
			})
			;
/ * * /
							swal({
								icon: "success",
								title: '{!! trans('user/messages.text.success') !!}',
								text: data.message,
								button: '{!! trans('user/messages.button.ok') !!}',
							}).then(function(){
								if (typeof data.url === 'undefined')
									location.reload(true);
								else
									window.location = data.url;
							});
/ * * /
						} catch(e) {
							//JSON parse error, this is not json (or JSON isn't in the browser)
alert('catch e');
//							location.reload(true);
						}
					else
					{
alert('else');
//						location.reload(true);
					}
				},
				'error': (xhr) => {
					let response = xhr.responseJSON;
					form.find('.error').remove();
					$.each(response.errors, (field, message) => {
						form.find(`[data-field="${field}"] .field-body`).append($('<div class="error pt-2">').html(message+' '));
					});
					@if ((Auth::user() === NULL))
					reCAPTCHA_execute();
					@endif
				}
			});
		});
*/


	});
</script>
@append