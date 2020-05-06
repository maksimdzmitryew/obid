function resetPagination(el)
{
	let res = getFilterForm(el);
    res.offset.val(0);
    res.current.val(1);
}
