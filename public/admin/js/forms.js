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

fnForm = function(e){
		e.preventDefault();

		let data = {},
//			form = $(this);
			form = $(e.currentTarget);

		$.ajax({
			url: form.attr('action'),
			type: form.attr('method'),
			data: form.serialize()
		}).done((data, status, xhr) => {




					if (xhr.readyState == 4 && xhr.status == 200)
						try {
							// Do JSON handling here
							tmp = JSON.parse(xhr.responseText);

							if (typeof tmp.url === 'undefined')
								s_route_primary = '';//window.location.href;//location.reload(true);
							else
								//window.location = data.url;
								s_route_primary = data.url;

							if (typeof tmp.btn_primary !== 'undefined')
							{
								s_text_primary = tmp.btn_primary;
								s_text_secondary = '';
								s_text_extra = '';
								data.icon = 'info';
								setSwalParams(data, form);
							}

/*
							swal({
								icon: "success",
								title: '{!! trans('user/messages.text.success') !!}',
								text: data.message,
								button: '{!! trans('user/messages.button.ok') !!}',
							}).then(function(){
								if (typeof data.url === 'undefined')
									location.reload(true);
								else
									window.location = data.url;
							});
*/
						} catch(e) {
							//JSON parse error, this is not json (or JSON isn't in the browser)
//alert('catch e');
//console.log(xhr, xhr.readyState, xhr.status);
							// login back() reload with cookies set
							location.reload(true);
						}
//					else
//					{
//alert('else');
//						location.reload(true);
//					}






			data.icon = 'info';
			setSwalParams(data, form);
			if (typeof s_res_submit !== 'undefined' && s_res_submit != '')
				a_params.title = s_res_submit;

			Swal.fire(
				a_params
			).then((result) => {
				if (result.value) {
					if (s_route_primary != '')
						window.location.href = s_route_primary;
					else
						resetForm(form);
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					if (s_route_secondary != '')
						window.location.href = s_route_secondary;
					else
						resetForm(form);
				}
			})
			;

/*

//swal("Gotcha!", "Pikachu was caught!", "success");

			var a_buttons = {};

			if (s_text_secondary != '')
			{
				a_buttons['secondary'] = {
					text: s_text_secondary,
					className: "btn-light",
				};
			}

			if (s_text_extra != '')
				a_buttons['extra'] = {
					text: s_text_extra,
					className: "btn-light",
				};

			if (s_text_primary != '')
			{
				a_buttons['primary'] = {
					text: s_text_primary,
					className: "btn-primary",
				};
				s_route_primary = s_route_primary.replace(':type', 'place').replace(':id', data.id);
			}

			swal({
				icon: "success",
				title: s_res_submit,
				text: data.message,
				buttons: a_buttons,
			}).then((reaction) => {

				switch (reaction) {

					case 'extra':
						if (s_route_extra != '')
							window.location.href = s_route_extra;
						else
							resetForm(form);
					break;
					case 'secondary':
						if (typeof data.url === 'undefined')
							window.location.href = s_route_secondary;
						else
							window.location = data.url;
					break;
					case 'primary':
						if (s_route_primary != '')
							window.location.href = s_route_primary;
						else
							resetForm(form);
					break;

					default:
						if (s_close_route != '')
							window.location.href = s_route_list;
						else
							resetForm(form);
				}

			});
*/
/*
			swal({
				icon: "success",
				title: s_res_submit,
				text: data.message,
				buttons: {
					list: {
						text: s_text_list,
						className: "btn-light",
					},
					primary: {
						text: s_text_continue,
						className: "btn-primary",
					},
				},
			}).then((reaction) => {

				switch (reaction) {

					case 'list':
						if (typeof data.url === 'undefined')
							window.location.href = s_route_list;
						else
							window.location = data.url;
					  break;
					case 'primary':
						resetForm(form);
					  break;

					default:
						if (s_close_route != '')
							window.location.href = s_route_list;
						else
							resetForm(form);
//						window.location.href = s_route_list;
				}

			});
*/
/*
			swal({
				title: s_res_submit,
				type: 'success',
				showCancelButton: true,
				confirmButtonText: s_text_list,
				confirmButtonClass: 'btn btn-primary',
				cancelButtonText: s_text_continue,
				cancelButtonClass: 'btn btn-light',
			}).then((confirm) => {
				if(confirm.value){
					window.location.href = s_route_list;
				}else{
					form.find('fieldset').attr('disabled', false);
				}
			});
*/
			resetForm(form);

		}).fail((xhr) => {
			// validator retuens "422 (Unprocessable Entity)"
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
			// return http error other that "422 (Unprocessable Entity)"
			{
				let data = xhr.responseJSON;

				if (typeof data.title !== 'string')
				{
					notify(data.message, 'danger', 3000);
				}
				else
				{
					data.icon = 'warning';
					setSwalParams(data, form);

					Swal.fire(
						a_params
					).then((result) => {
						if (result.value) {
							if (s_route_primary != '')
								window.location.href = s_route_primary;
							else
								resetForm(form);
						} else if (result.dismiss === Swal.DismissReason.cancel) {
							if (s_route_secondary != '')
								window.location.href = s_route_secondary;
							else
								resetForm(form);
						}
					})
					;
				}
			}
		}).always((xhr, type, status) => {

			let response = xhr.responseJSON || status.responseJSON,
				errors = response.errors || [];
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
function setSwalParams(data, form){
	a_params = {
		reverseButtons:		true,
		showCloseButton:	true,
		icon:				'warning',
		title:				data.title,
		text:				data.message,
	};

	if (typeof data.icon !== 'undefined')
	{
		a_params.icon		= data.icon;
	};

	if (s_text_secondary != '')
	{
		a_params.cancelButtonText	= s_text_secondary;
		a_params.showCancelButton	= true;
		s_route_secondary = s_route_secondary.replace(':type', 'place').replace(':id', data.id);
	}
	else
	{
		s_route_secondary = '';
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

	if (s_text_primary != '')
	{
		a_params.confirmButtonText = s_text_primary;
		s_route_primary = s_route_primary.replace(':type', 'place').replace(':id', data.id);
	}
	else
	{
		s_route_primary = '';
	}

	a_params.onClose = () => {
		if (s_route_primary != '' && s_route_secondary == '')
			window.location.href = s_route_primary;
		else
			resetForm(form);
	};

}
