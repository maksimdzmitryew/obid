$('.btn-reset-filters').on('click', (e) => {

	let target = $(e.currentTarget);

    $('#filter-category .tab').each((i, checkbox) => {
        toggleCheckbox($(checkbox), true);
    });

    $('.filter-city #city-id').prop('disabled', true).attr('disabled', 'disabled').val($('.filter-city #cities option').first().prop('selected', 'selected'));
    $('.filter-city #cities').trigger('refresh');

    // single calendar on page
    //picker.data('datepicker').clear();
    // multiple calendars, e.g. "press" page with tabs
	$('input.date-range').each(
		function( index ) {
			$( this ) . data('datepicker').clear()
		}
	);

    // dates highlight when opening page
    setHightlightDates();

    setFilterDates(target, [date_start, date_end]);

    //$('#holdings-from').val( moment(new Date( date_start )).format('YYYY-MM-DD HH:mm:ss') ).prop('disabled', false);
    //$('#holdings-to').val( moment(new Date( date_end )).format('YYYY-MM-DD HH:mm:ss') ).prop('disabled', false);

    ////$('#holdings-from').val( moment(new Date( picker.data('date-from') )).format('YYYY-MM-DD HH:mm:ss') ).prop('disabled', false);
    ////$('#holdings-to').val( moment(new Date( picker.data('date-to') )).format('YYYY-MM-DD HH:mm:ss') ).prop('disabled', false);

    resetPagination(target);

    let res = getFilterForm(target);
    res.form.submit();
});

$('.filters-form').on('submit', (e) => {
    e.preventDefault();

	let target = $(e.currentTarget);

    // form submit button was directly clicked
    // to load new filters from 1st page
    if (typeof e.isTrigger == 'undefined')
    {
        resetPagination(target);
    }
    let res = getFilterForm(target);

    $.ajax({
        url: res.form.attr('action'),
        type: 'get',
        data: res.form.serialize(),
        success: (data) => viewEntries(res, data)
    });
});