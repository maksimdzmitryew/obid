function initFilters(){
    $('.filters .filter').each((i, elem) => {

        let filter = $(elem),
            values = String(filter.data('default-value')).split('|');

        if(filter.data('filter-type') === 'text'){

            let input = filter.find('[type=text]');

            input.on('keyup', function(e){
                let target = $(e.currentTarget);

                target.closest('.filter').attr('data-value', target.val().trim());

            }).val(values[0]);

        } else if(filter.data('filter-type') === 'range'){

            let range = String(filter.data('range')).split('|');

            filter.find('input.range').ionRangeSlider({
                min: range[0],
                max: range[1],
                from: values[0],
                to: values[1],
                type: 'double'
            }).on('change', function(){

                let input = $(this);

                input.closest('.filter').attr('data-value', input.data('from') + '|' + input.data('to'));

            });

        }else if(filter.data('filter-type') === 'date-range'){

            let input = filter.find('input.date-range');

            input.daterangepicker({
                autoUpdateInput: true,
                autoApply: true,
                timePicker: true,
                timePickerSeconds: true,
                timePicker24Hour: true,
                locale: {
                    format: 'LL'
                },
                alwaysShowCalendars: true,
                showCustomRangeLabel: true,
                ranges: {
                    //'all':['1970-01-01', new Date()],
                    'year':[moment().startOf('year'), moment().endOf('year')],
                    'month':[moment().startOf('month'), moment().endOf('month')],
                    'week':[moment().startOf('week'), moment().endOf('week')],
                    'day':[moment().startOf('day'), moment().endOf('day')],
                },
            }).on('apply.daterangepicker', (e, picker) => {
                picker.element.closest('.filter').attr('data-value', picker.startDate.format('YYYY-MM-DD HH:mm:ss') + '|' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
            });
        }else if(filter.data('filter-type') === 'select'){
/*
            filter.find('select').multiselect('destroy').multiselect({
                onChange: function(){

                    let values = [];

                    this.$select.find('option:selected').each((i, elem) => {
                        values.push(elem.value);
                    });

                    this.$select.closest('.filter').attr('data-value', values.join('|'))

                },
                onInitialized: function(select){

                    let values = String(filter.data('default-value')).split('|');

                    select.find('option').each((i, elem) => {
                        let option = $(elem);

                        option.prop('selected', values.indexOf(option.prop('value')) !== -1);
                    });

                    this.refresh();

                }
            });
*/
        }
    });
}
initFilters();
resetFilters(false);

function applyFilters(message = true){
    filters = {};

    $('.filter').each(function(i, elem){

        let filter = $(elem),
            value = String(filter.attr('data-value')).split('|');

        if(filter.data('filter-type') === 'text' && value){

            filters[filter.data('name')] = value[0];

        }else if(filter.data('filter-type') === 'range'){

            filters[filter.data('name')] = {
                'from': value[0],
                'to': value[1]
            };

        }else if(filter.data('filter-type') === 'date-range'){

            filters[filter.data('name')] = {
                'from': value[0],
                'to': value[1]
            };

        }else if(filter.data('filter-type') === 'select'){

            if( ! value[0]) return;

            // for a pre-filled dropdown
            if (typeof filter.find('select').data('multiselect') != 'undefined')
            {
                if(filter.find('select').data('multiselect').$select.prop('multiple')){
                    filters[filter.data('name')] = value;
                }else{
                    filters[filter.data('name')] = value[0];
                }
            }
            // for a live dropdown that gets data via ajax
            else
            {
                s_filter_name = filter.data('name');
                // reset previous selection of parent item
                filters[s_filter_name] = 0;

                if (s_filter_name == 'page_id')
                {
                    // a non-default option is selected
                    if (filter.find('select').val() != null)
                    {
                        filters[s_filter_name] = filter.find('select').val();

                        var a_new_option = {
                            qty: 500,
                            text: '{!! trans('user/crud.filter.perpage') !!}'
                        };

                        // show more results so all pages are visible

                        if ($('#page-length').find("option[value='" + a_new_option.qty + "']").length) {
                            $('#page-length').val(a_new_option.qty);
                        } else {
                            // add new option per page = 500
                            // select the option
                            var newOption = new Option(a_new_option.qty + ' ' + a_new_option.text, a_new_option.qty, true, true);
                            // Append it to the select
                            $('#page-length').append(newOption);
                        }
                        // sort by order column
                        dt.order([[4, "asc",]]);
                    }
                    else
                    // restore selection and sorting
                    {
                        // TODO remember last selected
                        // 1) per page
                        // 2) sort order and column(s)
                        $('#page-length').val(i_perpage);
                        dt.order(a_order);
                    }
                }

            }
        }
    });

    dt.draw(true);

    if(message)
    {
        notify('{!! trans('common/messages.apply_filters') !!}', 'info', 2000);
    }
}

$('#btn-filter').on('click', function(){
    applyFilters();
});

function resetFilters(message = true){

    $('.filters .filter').each(function(i, item){
        let filter = $(item);

        if(filter.data('filter-type') === 'text'){

            filter.attr('data-value', filter.data('default-value'));

            filter.find('[type=text]').val(filter.data('default-value'));

        }else if(filter.data('filter-type') === 'range'){

            let range = filter.find('input.range').data("ionRangeSlider");

            range.reset();

            filter.attr('data-value', filter.data('default-value'));

        }else if(filter.data('filter-type') === 'date-range'){

            let drp = filter.find('input.date-range').data('daterangepicker'),
                value = String(filter.data('default-value')).split('|');

            drp.setStartDate(moment(value[0], 'YYYY-MM-DD HH:mm:ss'));
            drp.setEndDate(moment(value[1], 'YYYY-MM-DD HH:mm:ss'));

            filter.attr('data-value', drp.startDate.format('YYYY-MM-DD HH:mm:ss') + '|' + drp.endDate.format('YYYY-MM-DD HH:mm:ss'));

        }else if(filter.data('filter-type') === 'select'){
/*
            let multiselect = filter.find('select').data('multiselect'),
                values = String(filter.data('default-value')).split('|');

            multiselect.$select.find('option').each((i, elem) => {
                let option = $(elem);

                option.prop('selected', values.indexOf(option.prop('value')) !== -1);
            });

            multiselect.refresh();

            filter.attr('data-value', values.join('|'))
*/
        }
    });

    if(message)
        notify('{!! trans('app/common.messages.reset_filters') !!}', 'info', 2000);
}

$('#btn-reset').on('click', function(){
    resetFilters();
    applyFilters(false);
});
