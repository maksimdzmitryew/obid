function Pagination(total = 0, current = 1, per_page = 10, range = 2){

    let pages = [],
        total_pages = Math.ceil(total / per_page),
        first = false,
        last = false,
        prev = false,
        next = false;

    for(let i = current - range; i <= current + range; i++){

        if(i < 1)
            continue;

        if(i > total_pages)
            break;

        pages.push({
            page: i
        });
    }

    if(current > 1)
        prev = current - 1;

    if(current < total_pages)
        next = current + 1;

    if(total_pages > 0){
        first = 1;
        last = total_pages;
    }

    return {
        current: current,
        first: first,
        last: last,
        next: next,
        prev: prev,
        pages: pages
    };
}