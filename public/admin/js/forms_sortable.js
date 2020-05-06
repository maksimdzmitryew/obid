$(document).ready(() => {

    $('.sortable').sortable({
        containment: 'parent',
        tolerance: 'pointer',
    }).disableSelection();

});