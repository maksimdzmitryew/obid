$(document).ready(() => {

    $(document).on('click', '.bookmark',  (e) => {
        let target = $(e.currentTarget);

        if(auth){
            $.ajax({
                type: 'post',
                url: target.hasClass('added') 
                        ? route_unfavorite.replace(':event', target.data('event-id')) 
                        : route_favorite.replace(':event', target.data('event-id'))
                    ,
                success: (data) => {
                    target.toggleClass('added');

                    swal({
                        title: 'Success',
                        text: data.message,
                        type: 'success',
                        confirmButtonText: 'Ok',
                        confirmButtonClass: 'btn btn-primary',
                    });
                }
            });
        }
        else
        {
            window.location.href = route_login;
        }

        //window.location.href = $(target).hasClass('added') ? route_unfavorite.replace(':event', target.data('event-id')) : route_favorite.replace(':event', target.data('event-id'));
    });

});
