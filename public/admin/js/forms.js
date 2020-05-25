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

	let a_params = {};
	function setSwalParams(data){
		a_params = {
			reverseButtons:		true,
			showCloseButton:	true,
			icon:				'warning',
			title:				data.title,
			text:				data.message,
		};

		if (s_text_secondary != '')
		{
			a_params.cancelButtonText	= s_text_secondary;
			a_params.showCancelButton	= true;
			s_route_secondary = s_route_secondary.replace(':type', 'place').replace(':id', data.id);
		}

		if (s_text_extra != '')
		{
			if (typeof data.url !== 'undefined')
				s_route_extra = data.url;
			a_params.footer = '<a href="' + s_route_extra + '">' + s_text_extra + '</a>';
		}
		if (s_text_primary != '')
		{
			a_params.confirmButtonText = s_text_primary;
			s_route_primary = s_route_primary.replace(':type', 'place').replace(':id', data.id);
		}

		a_params.onClose = () => {
			if (s_route_primary != '' && s_route_secondary == '')
				window.location.href = s_route_primary;
			else
				resetForm(form);
		};

	}

	// TODO: refactoring
	// loook at _profile.blade.php
	$('form.item-form').on('submit', function(e){
		e.preventDefault();

		let data = {},
			form = $(this);

		$.ajax({
			url: form.attr('action'),
			type: form.attr('method'),
			data: form.serialize()
		}).done((data, status, xhr) => {

			setSwalParams(data);
			a_params.icon = 'info';
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
			let data = xhr.responseJSON;

			if (typeof data.title !== 'string')
				notify(data.message, 'danger', 3000);
			else
			{
				setSwalParams(data);
				a_params.icon = 'warning';

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
		}).always((xhr, type, status) => {

			let response = xhr.responseJSON || status.responseJSON,
				errors = response.errors || [];

			form.find('.field').each((i, el) => {
				let field = $(el),
					container = field.find(`.field-body`),
					elem = $('<label class="message">');

				container.find('label.message').remove();

				if(errors[field.data('name')]){
					errors[field.data('name')].forEach((msg) => {
						elem.clone().addClass('validation-invalid-label').html(msg).appendTo(container);
					});
				}else{
					//elem.clone().addClass('validation-valid-label').html('Success').appendTo(container);
				}

			});
		})
	});

});