@if ((Auth::user() === NULL) && (config('app.env') != 'local'))
					<div class="field_row" data-name="g-recaptcha-response">
						<label for="recap_response_{!! $id ?? '' !!}">
						<span class="label"></span>
						</label>
						===<input type="text" id="recap_response_{!! $id ?? '' !!}" placeholder="" name="g-recaptcha-response">===
{{--
						<div class="g-recaptcha" style="overflow: hidden;" data-sitekey="{{ config('services.google.recaptcha.key') }}"></div>
--}}
					</div>

@endif