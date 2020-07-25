let
	auth				=  Boolean({!! Auth::check() ?? null !!})
	,s_json_err			= '{!! trans('common/messages.json_parse_error') !!}'
	,s_locale			= '{!! $app->getLocale() !!}'
	,s_route_auth		= '{!! route('guest.personal.profile') !!}'
	,s_route_csfr		= '{!! route('get-csrf') !!}'
	,b_recaptcha		= Boolean({!! ((Auth::user() === NULL) && (config('app.env') != 'local')) !!})
;
/*
//if (typeof s_text_primary == 'undefined')
{
let
	s_text_primary		= '{!! (isset($s_btn_primary) ? $s_btn_primary : trans('user/messages.button.ok')) !!}'
	;
	alert(s_text_primary);
}
*/