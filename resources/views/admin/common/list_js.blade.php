let filters				= {}
	;

moment.locale(s_locale);

$('#page-length').on('change', function(){
    dt.page.len($(this).val()).draw();
});

$('#btn-delete').on('click', function(){

			a_params = {
				reverseButtons:		true,
				showCloseButton:	true,
				icon:				'warning',
				title:				'{!! trans('common/messages.confirm_delete_title') !!}',
				text:				'{!! trans('common/messages.confirm_delete_description') !!}',
				confirmButtonText:	'{!! trans('common/messages.confirm_delete_cancel_button_text') !!}',
				cancelButtonText:	'{!! trans('common/messages.confirm_delete_confirm_button_text') !!}',
				showCancelButton:	true,
			};

			Swal.fire(
				a_params
			).then((result) => {
				if (result.value) {
					notify('{!! trans('common/messages.delete_entries_cancelled') !!}', 'info', 2000);
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					deleteEntries();
				}
			})
			;

/*
//swal("Gotcha!", "Pikachu was caught!", "success");
			swal({
				icon: "warning",
				title: '{!! trans('common/messages.confirm_delete_title') !!}',
				text: '{!! trans('common/messages.confirm_delete_description') !!}',
				buttons: {
					delete: {
						text: '{!! trans('common/messages.confirm_delete_confirm_button_text') !!}',
						className: "btn-light",
					},
					primary: {
						text: '{!! trans('common/messages.confirm_delete_cancel_button_text') !!}',
						className: "btn-primary",
					},
				},
			}).then((reaction) => {

				switch (reaction) {

					case 'delete':
						deleteEntries();
					  break;
					case 'primary':
					default:
				}

			});
*/
/*
    swal({
        title: '{!! trans('common/messages.confirm_delete_title') !!}',
        text: '{!! trans('common/messages.confirm_delete_description') !!}',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: '{!! trans('common/messages.confirm_delete_confirm_button_text') !!}',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonText: '{!! trans('common/messages.confirm_delete_cancel_button_text') !!}',
        cancelButtonClass: 'btn btn-light',
    }).then((confirm) => {
        if(confirm.value){
            deleteEntries();
        }
    });
*/
});

$('#btn-add').on('click', (e) => {
    window.location.href = s_route_add;
});

function deleteEntries(){
    let rows = dt.rows('.selected').indexes(),
        ids = Array.prototype.map.call(dt.rows(rows).data(), el => el.id);

    $.ajax({
        type: 'post',
        url: s_route_del,
        data: {
            'ids': ids
        },
        success: function (data, status, xhr){

            if(xhr.status === 200){
                notify('{!! trans('common/messages.delete_entries_success') !!}', 'success', 2000);
                dt.draw(false);
            }else{
                notify('{!! trans('common/messages.delete_entries_error') !!}', 'danger', 2000);
            }

            applyFilters(false);
        },
        error: function (data){}
    })
}