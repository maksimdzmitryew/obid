<div class="js-cookie-consent cookie-consent" data-nosnippet="true" role="dialog" aria-live="polite" aria-label="cookieconsent" aria-describedby="cookieconsent:desc">
    <!--googleoff: all-->
    <div id="cookieconsent:desc" class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message', ['title' => $settings->title, 'url' => config('app.url') ]) !!}
    </div>
    <div class="consent-choices">
        <button role="button" class="js-cookie-consent-later cookie-consent__later">
            {!! trans('cookieConsent::texts.later') !!}
        </button>
        <button role="button" class="js-cookie-consent-agree cookie-consent__agree">
            {{ trans('cookieConsent::texts.agree') }}
        </button>
    </div>
    <!--googleon: all-->
</div>
