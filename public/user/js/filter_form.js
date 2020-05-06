function getFilterForm(e)
{
	var filters 		= new Object();
    filters.button 		= $(e);

	if (filters.button.closest('.tab-pane').length > 0)
	{
		filters.form 	= filters.button.closest('.tab-pane').find('.filters-form')
	}
	else
	{
	    filters.form 	= filters.button.closest('.filters-form');
	}
	
    filters.offset 		= filters.form.find('#offset');
    filters.current 	= filters.form.find('#current');
    filters.amount 		= filters.form.find('#amount');
    filters.date_start 	= filters.form.find('#date-from');
    filters.date_end 	= filters.form.find('#date-to');
    return filters;
}

viewEntries = function (data){
	console.log('Please, define viewEntries method specific to the template')
}