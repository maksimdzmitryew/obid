$(document).ready(() => {

	// https://css-tricks.com/snippets/javascript/javascript-keycodes/
	// Ctrl+a, Cmd+A pressed
	$(document).keydown(function(e) {
		if ((e.key == 'a' || e.key == 'A' ) && (e.ctrlKey || e.metaKey))
		{
			e.preventDefault();
			$('#btn-add').trigger( "click" );
			return false;
		}
		return true;
	});
	// Ctrl+r, Cmd+R pressed
	$(document).keydown(function(e) {
		if ((e.key == 'b' || e.key == 'B' ) && (e.ctrlKey || e.metaKey))
		{
			e.preventDefault();
			$('#btn-reset').trigger( "click" );
			return false;
		}
		return true;
	});
	// Ctrl+s, Cmd+S pressed
	$(document).keydown(function(e) {
		if (
			(e.key == 'Enter' || e.keyCode == 13)
			||
			((e.key == 's' || e.key == 'S' ) && (e.ctrlKey || e.metaKey))
			)
		{
			e.preventDefault();
			$('#btn-filter').trigger( "click" );
			return false;
		}
		return true;
	});
	// Ctrl+d, Cmd+D pressed
	$(document).keydown(function(e) {
		if ((e.key == 'd' || e.key == 'D' ) && (e.ctrlKey || e.metaKey))
		{
			e.preventDefault();
			$('#btn-delete').trigger( "click" );
			return false;
		}
		return true;
	});
});