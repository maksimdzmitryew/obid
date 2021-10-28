let
        auth                =  Boolean({!! Auth::check() ?? null !!})
        ,s_json_err         = '{!! trans('common/messages.json_parse_error') !!}'
        ,s_locale           = '{!! $app->getLocale() !!}'
        ,s_route_auth       = '{!! route('guest.personal.profile') !!}'
        ,s_route_csfr       = '{!! route('get-csrf') !!}'
        ,b_recaptcha        = Boolean({!! ((Auth::user() === NULL) && (config('app.env') != 'local')) !!})
;

const   COOKIE_VALUE = {{ config('session.consent_value') }};
const   COOKIE_DOMAIN = '{{ $s_domain_tld }}';
const   FORCE_CONSENT = {{ (in_array(request()->segment(1), ['signin', 'signup',]) ? 1 : 0) }};
const   COOKIE_DISAGREE = "{{ config('session.consent_disagree') }}";

if (typeof s_text_primary == 'undefined')
{
    s_text_primary      = '{!! (isset($s_btn_primary) ? $s_btn_primary : trans('user/messages.button.ok')) !!}';
}
