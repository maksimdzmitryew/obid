jQuery(document).ready(function($) {

	$('.cookie-consent__agree').on('click', function (e) {
		// cacheless reload
		document.location.reload(true);
	});

	$('.cookie-consent__later').on('click', function (e) {
		$('div.js-cookie-consent').remove();
		cookie_consent = 'later';
		localStorage.setItem("cookie_consent", cookie_consent);
	});

	var cookie_consent = localStorage.getItem("cookie_consent");

	if (typeof cookie_consent == 'string' && cookie_consent == 'later')
		$('.cookie-consent__later').trigger('click');

});
