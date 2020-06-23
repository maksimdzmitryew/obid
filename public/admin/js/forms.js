$(document).ready(() => {

	moment().locale('{!! $app->getLocale() !!}');

    // https://css-tricks.com/snippets/javascript/javascript-keycodes/
	// Ctrl+s, Cmd+s pressed
	$(document).keydown(function(e) {
		if ((e.key == 's' || e.key == 'S' ) && (e.ctrlKey || e.metaKey))
		{
			e.preventDefault();
			$('form.item-form').submit();
			return false;
		}
		return true;
	});

	$('form.item-form').on('submit', fnForm);

});

let b_error 		= false,
	s_url_ok		= '',
	s_url_dissmiss	= '',
	s_url_close		= '';
fnForm = function(e){
		e.preventDefault();

		let data = {},
//			form = $(this);
			form = $(e.currentTarget);

		$.ajax({
			url:	form.attr('action'),
			type:	form.attr('method'),
			data:	form.serialize()
		}).done((data, status, xhr) => {
			b_error		= false;
			if (xhr.readyState == 4 && xhr.status == 200)
			{
				try {
					// Do JSON handling here
					tmp = JSON.parse(xhr.responseText);
					setSwalParams(tmp, form, b_error);
				} catch(e) {
					//JSON parse error, this is not json (or JSON isn't in the browser)
					// login back() reload with cookies set
					location.reload(true);
				}
			}
			else
			{
//						location.reload(true);
				setSwalParams(data, form, b_error);
			}
			runSwal(b_error);
		}).fail((xhr) => {
			b_error	= true;

			// validator returns "422 (Unprocessable Entity)"
			if (xhr.readyState == 4 && xhr.status == 422)
			{
				try {
					// Do JSON handling here
					tmp = JSON.parse(xhr.responseText);
					// no valid errors data for submitted form
					if (typeof tmp.errors != 'object')
					{
						notify(xhr.status + ': ' + tmp.message, 'danger', 3000);
					}
				} catch(e) {
					//JSON parse error, this is not json (or JSON isn't in the browser)
					notify(xhr.status + ': ' + tmp.message, 'danger', 3000);
				}
			}
			else
			// return http errors other that "422 (Unprocessable Entity)"
			{
				let data = xhr.responseJSON;

				if (typeof data.title !== 'string')
				{
					notify(data.message, 'danger', 3000);
				}
				else
				{
					setSwalParams(data, form, b_error);
					runSwal(b_error);
				}
			}
		}).always((xhr, type, status) => {

			let response	= xhr.responseJSON || status.responseJSON,
				errors		= [];
			if (typeof (response) !== 'undefined')
			{
				errors = response.errors;
			}
			form.find('.item').each((i, el) => {
				msg_text = $('<span class="err_text">');
				let o_field = $(el),
					field_value = o_field.find('.value'),
					field_name = o_field.data('name'),
					field_label = o_field.find('.label'),
					prev_errors = o_field.find('.err_text');
				prev_errors.remove();
				field_label.removeClass('validation-invalid-label');

				if(errors[o_field.data('name')])
				{
					errors[field_name].forEach((msg) => {
						field_label.addClass('validation-invalid-label');
						msg_text.clone().addClass('validation-invalid-text').html(msg).appendTo(field_value);
					});
				}
				else
				{
					field_label.addClass('validation-valid-label');
				}

			});
		})
	}

let a_params 	= {};
function setSwalParams(data, form, b_error){
	a_params = {
		reverseButtons:		true,
		showCloseButton:	true,
	};

	s_url_ok		= '',
	s_url_dissmiss	= '',
	s_url_close		= '',
	s_btn_ok		= '';

	if (typeof data.message !== 'undefined')
	{
		a_params.text			= data.message;
	}

	if (typeof data.title !== 'undefined')
	{
		a_params.title		= data.title;
	}
	else
	{
		if (typeof s_res_submit !== 'undefined' && s_res_submit != '')
		{
			a_params.title = s_res_submit;
		}
	}

	if (typeof s_text_primary === 'undefined')
	{
		s_text_primary = '';
	}
	if (typeof s_text_secondary === 'undefined')
	{
		s_text_secondary = '';
	}
	if (typeof s_text_extra === 'undefined')
	{
		s_text_extra = '';
	}

	if (typeof data.icon !== 'undefined')
	{
		a_params.icon		= data.icon;
	}
	else
	{
		if (b_error)
			a_params.icon	= 'warning';
		else
			a_params.icon	= 'info';
	}

	if (typeof data.url === 'undefined' && typeof s_route_primary !== 'undefined')
	{
		data.url		= s_route_primary;
	}
	else
	{
		data.url		= '';
	}

	if (typeof data.btn !== 'undefined')
	{
		s_btn_ok		= data.btn;
	}
	else if (s_text_primary != '')
	{
		s_btn_ok		= s_text_primary;
	}
	else
	{
		s_btn_ok		= '';
	}

	if (s_text_secondary != '')
	{
		a_params.cancelButtonText	= s_text_secondary;
		a_params.showCancelButton	= true;
		s_url_dissmiss = s_route_secondary.replace(':type', 'place').replace(':id', data.id);
	}
	else
	{
		s_url_dissmiss = '';
	}

	if (s_text_extra != '')
	{
		if (typeof data.url !== 'undefined')
			s_route_extra = data.url;
		a_params.footer = '<a href="' + s_route_extra + '">' + s_text_extra + '</a>';
	}
	else
	{
		s_route_extra = '';
	}

	if (s_btn_ok != '')
	{
		a_params.confirmButtonText = s_btn_ok;
		s_url_ok = data.url.replace(':type', 'place').replace(':id', data.id);
	}
	else
	{
		data.url = '';
	}

	a_params.onClose = () => {
		if (s_url_ok != '' && s_url_dissmiss == '')
			window.location.href = s_url_ok;
		else if (!b_error)
			resetForm(form);
	};
}

function runSwal(b_keep_form)
{
	// check that setSwalParams() was called
	if ("title" in a_params)
	{
		Swal.fire(
			a_params
		).then((result) => {
			if (result.value) {
				if (s_url_ok != '')
					window.location.href = s_url_ok;
				else if (!b_keep_form)
					resetForm(form);
			} else if (result.dismiss === Swal.DismissReason.cancel) {
				if (s_url_dissmiss != '')
					window.location.href = s_url_dissmiss;
				else if (!b_keep_form)
					resetForm(form);
			}
		})
		;
	}
}

function resetForm(form)
{
	if (s_action_form == 'create')
	{
		// clean all fields once the form's been saved
		form.find('input[type=text]').val('');
		form.find('.switcher').bootstrapSwitch('state', false);
		form.find(".select2-dropdown").val(null).trigger('change');
	}
	form.find('fieldset').attr('disabled', false);
}