$(document).ready(() => {

    let picker_single = $('.datepicker').daterangepicker({
        autoApply: true,
        singleDatePicker: true,
        timePicker: true,
        locale: {
            format: 'LLL'
        },
    }).on('apply.daterangepicker', (e, picker) => {
        picker.element.closest('.field').find('#published_at').prop('value', picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    let picker_range = $('.daterange-single').daterangepicker({
        autoApply: true,
        singleDatePicker: false,
        timePicker: true,
        locale: {
            format: 'LLL'
        },
    }).on('apply.daterangepicker', (e, picker) => {
        picker.element.closest('.field').find('#holdings-date-from').val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
        picker.element.closest('.field').find('#holdings-date-to').val(picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    picker_single.each((i, item) => {
        $(item).data('daterangepicker').setStartDate(moment($(item).data('date-from')).format('LLL'));
        $(item).data('daterangepicker').setEndDate(moment($(item).data('date-to')).format('LLL'));
    });

    picker_range.each((i, item) => {
        $(item).data('daterangepicker').setStartDate(moment($(item).data('date-from')).format('LLL'));
        $(item).data('daterangepicker').setEndDate(moment($(item).data('date-to')).format('LLL'));
    });
});