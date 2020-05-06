/*
$(document).ready(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.tooltip-helper').tooltip({
        //trigger: $(this).data('trigger')
    });

    let selects = $(".select2");

    selects.each(function(i, item){
        let select = $(item);

        select.select2({
            minimumResultsForSearch: Infinity,
            placeholder: select.data('placeholder'),
            width: '100%'
        });
    });

    $('.multi-select').multiselect();

    Noty.overrideDefaults({
        layout: 'topRight',
    });

    window.notify = function(message, type = 'success', timeout){

        let class_name = ' alert alert-success bg-success alert-styled-left p-0'

        if(type === 'success'){
            class_name = ' alert alert-success bg-success alert-styled-left p-0';
        }else if(type === 'info'){
            class_name = ' alert alert-info bg-info alert-styled-left p-0';
        }else if(type === 'primary'){
            class_name = ' alert alert-primary bg-info alert-styled-primary p-0';
        }else if(type === 'warning'){
            class_name = ' alert alert-warning bg-warning alert-styled-left p-0';
        }else if(type === 'danger'){
            class_name = ' alert alert-danger bg-danger alert-styled-left p-0';
        }

        let noty = new Noty({
            theme: class_name,
            text: message,
            type: type,
            timeout: timeout || 3000
        });

        noty.show();

        return noty;
    }

    $('.switcher').bootstrapSwitch();
});
*/
