$(document).ready(() => {
    // categories selector
    $(document).on('click', '#filter-category .tab', (e) => {
        let checkbox = $(e.currentTarget);
        toggleCheckbox(checkbox, ! checkbox.find('input').prop('disabled'));
    });

    // city selector
    $(document).on('change', '#filter-city #cities', (e) => {
        let target = $(e.currentTarget);
        target.closest('.filter-city').find('#city-id').prop('disabled', false).removeAttr('disabled').val(target.val());
    });

});

function toggleCheckbox(checkbox, disabled = false){
    let input = checkbox.find('input');
    input.prop('disabled', !! disabled);
    input.closest('.tab').find('.filter-label').toggleClass('selected', ! input.prop('disabled'));
};
