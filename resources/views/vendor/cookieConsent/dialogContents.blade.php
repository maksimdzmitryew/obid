<div class="js-cookie-consent cookie-consent">

    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message', ['title' => $settings->title, 'url' => config('app.url') ]) !!}
    </span>

    <button class="js-cookie-consent-agree cookie-consent__agree left">
        {{ trans('cookieConsent::texts.agree') }}
    </button>

    <span class="js-cookie-consent-later cookie-consent__later left">
        {!! trans('cookieConsent::texts.later') !!}
    </span>

</div>
