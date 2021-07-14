@if ((Auth::user() === NULL) && (config('app.env') != 'local'))
					<div class="field_row" data-name="g-recaptcha-response">
						<label for="recap_response_{!! $id ?? '' !!}">
						<span class="label"></span>
						</label>
						<input type="hidden" id="recap_response_{!! $id ?? '' !!}" placeholder="" name="g-recaptcha-response">
						@if (config('services.google.recaptcha.version') == 2)
						<div class="g-recaptcha" style="overflow: hidden;" data-sitekey="{{ config('services.google.recaptcha.key') }}"></div>
						@endif
					</div>
@endif