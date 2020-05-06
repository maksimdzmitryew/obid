$(document).on('click', '.pagination .loadmoreitems-btn', (e) => {
    let elem = $(e.currentTarget);

    if(elem.hasClass('disabled')) return;
    b_load_more = true;

    $('#filters-form').find('#offset').val((elem.data('current')) * elem.data('limit'));
    $('#filters-form').submit();
});

viewLoadMore = function (total, start, limit){
    setPaginationData(total, start, limit);

    // hide "load more" button
    nav_holder.html('');

    if (pages < 2) return;

    loadmoreitems_btn = $('#loadmoreitems').tmpl({
            records_total: total,
            limit: limit,
            current: current
        });

    if (current < pages) {
        // show "load more" button
        nav_holder.append( 
            nav_container.append(
                loadmoreitems_btn.toggleClass('disabled', true)
            ) 
        );
    }
}

$(document).ready(() => {
    viewLoadMore(
    	records_total, 
    	$('#filters-form').find('#offset').val(), 
    	$('#filters-form').find('#amount').val()
    );
});