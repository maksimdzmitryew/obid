// set values for datepicker
function setFilterDates(el, date)
{
	let res = getFilterForm(el);
    if(date[0]) res.date_start.val('').prop('disabled', true);
    if(date[1]) res.date_end.val('').prop('disabled', true);

    if(date[0])
        //res.date_start.val(date[0]).prop('disabled', false);
        res.date_start.val(moment(date[0]).format('YYYY-MM-DD HH:mm:ss')).prop('disabled', false);

    if(date[1])
        //res.date_end.val(date[1]).prop('disabled', false);
        res.date_end.val(moment(date[1]).format('YYYY-MM-DD HH:mm:ss')).prop('disabled', false);
}
