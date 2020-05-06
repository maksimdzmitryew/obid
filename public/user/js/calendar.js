let input = $('input.date-range'),
    b_hightlight = false,
    picker = input.datepicker({
        dateFormat: 'yyyy-mm-dd',
        startDate: new Date(date_start),
        minDate: new Date(date_start),
        maxDate: new Date(date_end),
        prevHtml: '<svg width="27" height="19" viewBox="0 0 27 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
        '<path d="M0.654556 8.77965L8.33761 0.881904C8.80637 0.400042 9.56661 0.400042 10.0354 0.881904C10.5042 1.36386 10.5042 2.14515 10.0354 2.62711L4.40168 8.41823H24.9206C25.5836 8.41823 26.1211 8.97077 26.1211 9.65225C26.1211 10.3336 25.5836 10.8863 24.9206 10.8863H4.40168L10.0352 16.6774C10.504 17.1594 10.504 17.9406 10.0352 18.4226C9.80085 18.6634 9.49352 18.784 9.1863 18.784C8.87907 18.784 8.57185 18.6634 8.33742 18.4226L0.654556 10.5249C0.185698 10.0429 0.185698 9.26161 0.654556 8.77965Z" fill="#0E293C"/>\n' +
        '</svg>',
        nextHtml: '<svg width="26" height="19" viewBox="0 0 26 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
        '<path d="M25.4665 10.525L17.7835 18.4228C17.3147 18.9046 16.5545 18.9046 16.0857 18.4228C15.6169 17.9408 15.6169 17.1595 16.0857 16.6776L21.7194 10.8865L1.20048 10.8865C0.537526 10.8865 0 10.3339 0 9.65244C0 8.97106 0.537526 8.41841 1.20048 8.41841L21.7194 8.41841L16.0859 2.62729C15.6171 2.14533 15.6171 1.36405 16.0859 0.882086C16.3202 0.641304 16.6276 0.520666 16.9348 0.520666C17.242 0.520666 17.5492 0.641304 17.7837 0.882086L25.4665 8.77983C25.9354 9.26179 25.9354 10.0431 25.4665 10.525Z" fill="#0E293C"/>\n' +
        '</svg>',
        navTitles: 
        {
            days: 'MM <i>yyyy</i>',
            months: 'yyyy',
            years: 'yyyy1 - yyyy2'
        },
        inline: true,
        language: s_app_locale_code,
        range: true,
        onSelect: function(formattedDate, date, inst){
            setFilterDates(inst.el, date);
        }
    });

picker
    .data('date-from', date_start)
    .data('date-to', date_end)
;

function setHightlightDates()
{
    if(b_hightlight && date_start && date_end){
        picker.data('datepicker').selectDate([
            new Date(date_start),
            new Date(date_end)
        ]);
    }
}

setHightlightDates();

