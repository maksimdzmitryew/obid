$(document).ready(function ()
{

	let b_session_status = null,
		b_session_swal_open = false
		;

	var checkSession = function ()
	{
		$.ajax({
			'type': 'get',
			'data': {},
			'url': s_route_session,
			success: (data, status, xhr) => {
				let response = xhr.responseJSON;

				if (xhr.readyState == 4 && xhr.status == 200)
					try {
						// Do JSON handling here
						a_session = JSON.parse(xhr.responseText);

						if (!a_session.acl)
						swal({
							icon: "error",
							title: s_session_acl_head,
							text: s_session_acl_info,
							buttons: {
								primary: {
									text: s_btn_ok,
									className: "btn-primary",
								},
							},
						}).then((reaction) => {

							switch (reaction) {
								case 'primary':
								default:
									checkSession();
							}

						});
/*
						swal({
							title: s_session_acl_head,
							type: 'error',
							text: s_session_acl_info,
							allowOutsideClick: false,
							confirmButtonText: s_btn_ok,
							confirmButtonClass: 'btn btn-primary',
						}).then(function(){
							checkSession();
						});
*/
						// this could happen, but mostly by mistake
						// because 'auth' middleware should catch this
						// so we trigger showing 'info' which in turn
						// also conducts session re-checking
						if (!a_session.active)
							JSON.parse('{/{');

						b_session_swal_open = (!a_session.acl || !a_session.active);
						if (b_session_swal_open && a_session.acl && a_session.active)
							swal.close();

					} catch(e) {
						//JSON parse error, this is not json (or JSON isn't in the browser)
						swal({
							icon: "info",
							title: s_servererror_head,
							text: s_servererror_info,
							button: s_btn_ok,
						}).then(function(){
							checkSession();
						});
/*
						swal({
							title: s_servererror_head,
							text: s_servererror_info,
							type: 'info',
							confirmButtonText: s_btn_ok,
							confirmButtonClass: 'btn btn-primary',
						}).then(function(){
							checkSession();
						});
*/
					}
				else
					swal({
						icon: "error",
						title: s_servererror_head,
						text: response.message + ' ' + s_servererror_final,
						button: s_btn_ok,
					}).then(function(){
						checkSession();
					});
/*
					swal({
						title: s_servererror_head,
						text: response.message + ' ' + s_servererror_final,
						type: 'error',
						confirmButtonText: s_btn_ok,
						confirmButtonClass: 'btn btn-primary',
					}).then(function(){
						checkSession();
					});
*/
			},
			'error': (xhr) => {
				if (xhr.readyState == 4 && xhr.status == 401)
				{

					swal({
						icon: "warning",
						title: s_session_expired_head,
						text: s_session_expired_info,
						buttons: {
							ignore: {
								text: s_session_close,
								className: "btn-light",
							},
							primary: {
								text: s_session_tab_opennew,
								className: "btn-primary",
							},
						},
					}).then((reaction) => {

						switch (reaction) {
							case 'primary':
								o_window_ref = window.open(s_route_auth, '_blank');
								notify(s_session_tab_opened, 'info', 3000);
							case 'ignore':
							default:
								checkSession();
						}

					});
/*
					swal({
						title: s_session_expired_head,
						type: 'warning',
						text: s_session_expired_info,
						showCancelButton: true,
						allowOutsideClick: false,
						confirmButtonText: s_session_tab_opennew,
						confirmButtonClass: 'btn btn-primary',
						cancelButtonText: s_session_close,
						cancelButtonClass: 'btn btn-light',
					}).then((confirm) => {
						if(confirm.value)
						{
							o_window_ref = window.open(s_route_auth, '_blank');
							notify(s_session_tab_opened, 'info', 3000);
						}
						else
							checkSession();
					});
*/
				}
				else
				{
					let response = xhr.responseJSON;
					swal({
						icon: "error",
						title: s_servererror_head,
						text: response.message + ' ' + s_servererror_final,
						button: s_btn_ok,
					}).then(function(){
						checkSession();
					});
/*
					swal({
						title: s_servererror_head,
						text: response.message + ' ' + s_servererror_final,
						type: 'error',
						confirmButtonText: s_btn_ok,
						confirmButtonClass: 'btn btn-primary',
					}).then(function(){
						checkSession();
					});
*/
				}
			}
		});

	}
	a_check_focus.push(checkSession);
});
