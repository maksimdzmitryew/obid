$(document).on('click', '.pagination .page-item a', (e) => {
    let elem = $(e.currentTarget);

    e.preventDefault();

    $('#filters-form').find('#offset').val((elem.data('page') - 1) * elem.data('limit'));
    $('#filters-form').submit();
});

$(document).on('click', '.pagination .page-item.prev-page-item', (e) => {
    let elem = $(e.currentTarget);

    if(elem.hasClass('disabled')) return;

    $('#filters-form').find('#offset').val((elem.data('current') - 2) * elem.data('limit'));
    $('#filters-form').submit();
});

$(document).on('click', '.pagination .page-item.next-page-item', (e) => {
    let elem = $(e.currentTarget);

    if(elem.hasClass('disabled')) return;

    $('#filters-form').find('#offset').val((elem.data('current')) * elem.data('limit'));
    $('#filters-form').submit();
});

viewPagination = function (total, start, limit){
    setPaginationData(total, start, limit);
    nav_holder.empty();

    let arrow_left = $('#arrow-left').tmpl({
            records_total: total,
            limit: limit,
            current: current
        }),
        arrow_right = $('#arrow-right').tmpl({
            records_total: total,
            limit: limit,
            current: current
        });

    nav_container.empty();

    if(pages < 2) return;

    nav_container.append(arrow_left.toggleClass('disabled', current < 2));

    for(let page = (current - 2) < 1 ? 1 : (current - 2); page <= pages && (current + 2) >= page; page++){

        nav_container.append($(page === current ? '#active-page' : '#page').tmpl({
            records_total: total,
            start: start,
            limit: limit,
            page: page,
            current: current
        }));

    }

    nav_holder.append( 
        nav_container.append(
            arrow_right.toggleClass('disabled', current >= pages)
        ) 
    );
//    nav_container.append(
//        arrow_right.toggleClass('disabled', current >= pages)
//    ).appendTo(nav_holder);
}

$(document).ready(() => {
    viewPagination(
        records_total, 
        $('#filters-form').find('#offset').val(), 
        $('#filters-form').find('#amount').val()
    );
});