jQuery(document).ready(function($) {

	$('.cookie-consent__agree').on('click', function (e) {
		// cacheless reload
		document.location.reload(true);
	});

	$('.cookie-consent__later').on('click', function (e) {
		$('div.js-cookie-consent').remove();
		localStorage.setItem("cookie_consent", COOKIE_DISAGREE);
	});

	var cookie_consent = localStorage.getItem("cookie_consent");

	if (typeof cookie_consent == 'string' && cookie_consent == COOKIE_DISAGREE && !FORCE_CONSENT)
		$('.cookie-consent__later').trigger('click');

});
