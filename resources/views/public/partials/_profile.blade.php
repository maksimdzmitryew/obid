@section('js')
<!-- http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm -->
@if (Cookie::get( config('cookie-consent.cookie_name') ) !== null)
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.key') }}&hl={!! $app->getLocale() !!}"></script>
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
		function reCAPTCHA_execute () {
			timepassed = Math.round((Date.now() - i_reCAPTCHA_update_time) / 1000) * 1000;
			if (timepassed < i_reCAPTCHA_refresh_time || !b_focus_status) return true;

			grecaptcha.execute(reCAPTCHA_site_key, {action: 'login'}).then(function(token) {
				if (s_reCAPTCHA != token)
				{
					$('[name="g-recaptcha-response"]').val(token);
					i_reCAPTCHA_update_time		= Date.now();
				}
			}, function (reason) {
			});
		}

		if (
			typeof grecaptcha !== 'undefined' // check settings
			&& typeof reCAPTCHA_site_key !== 'undefined' // check settings
			&& !auth // disable for authenticated user
			&& b_recaptcha // whether is enabled
		) {
			if (i_reCAPTCHA_version == 3)
			{
				grecaptcha.ready(reCAPTCHA_execute);
			}

			if (b_refresh_tokens)
			{
				a_check_focus.push(reCAPTCHA_execute);
				setInterval(reCAPTCHA_execute, 1000 * 60); // 1 min
			}
		}

		// fnForm can be found in
		// forms.js
		$('{!! $s_id !!}').on('submit', fnForm);
	});
</script>
@append