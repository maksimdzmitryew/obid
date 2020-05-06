@extends('layouts.admin')

@section('title-icon')<i class="icon-newspaper mr-2"></i>@endsection

@section('title'){!! trans('app/presses.list.title') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <span class="breadcrumb-item active">{!! trans('app/presses.breadcrumbs.list') !!}</span>
            </div>
            <a href="{!! route('admin.presses') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/list/list.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/sliders/ion_rangeslider.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/tables/datatables/extensions/select.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            moment.locale('{!! $app->getLocale() !!}');

            $('#page-length').on('change', function(){
                dt.page.len($(this).val()).draw(false);
            });

            let filters = {};

            let dt = $('.table').DataTable({
                dom: 'tip',
                autoWidth: false,
                processing: true,
                serverSide: true,
                searching: false,
                pageLength: 20,
                select: {
                    style: 'os',
                    selector: 'td:not(:last-child)'
                },
                columns: [
                    {
                        data: 'title'
                    },
                    {
                        data: 'festival',
                        render: function(data){
                            return data;
                        }
                    },
                    {
                        data: 'city',
                        render: function(data){
                            return data;
                        }
                    },
                    {
                        data: 'type',
                        render: function(data){
                            return data;
                        }
                    },
                    {
                        data: 'category',
                        render: function(data){
                            return data;
                        }
                    },
                    {
                        data: 'published',
                        render: function (data, type, row) {
                            let status = Number(data) ? '{!! trans('app/common.states.yes') !!}' : '{!! trans('app/common.states.no') !!}',
                                className = Number(data) ? 'success' : 'secondary';

                            return `<span class="badge badge-${className}">${status}</span>`;
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'published_at',
                        render: function(data){
                            return moment(data).format('LLL');
                        }
                    },
                    {
                        sortable: false,
                        data: function(row){
                            return `<a href="{!! route('admin.presses.form', [':id']) !!}" class="btn btn-sm btn-primary"><i class="icon-pencil"></i></a>`.replace(':id', row.id);
                        }
                    }
                ],
                ajax: {
                    url: '{!! route('api.presses.index') !!}',
                    data: function(data){
                        data.filters = filters;
                    }
                }
            });

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

                        if(filter.find('select').data('multiselect').$select.prop('multiple')){
                            filters[filter.data('name')] = value;
                        }else{
                            filters[filter.data('name')] = value[0];
                        }
                    }
                });

                dt.draw(true);

                if(message)
                    notify('{!! trans('common/messages.apply_filters') !!}', 'info', 2000);
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

                        let multiselect = filter.find('select').data('multiselect'),
                            values = String(filter.data('default-value')).split('|');

                        multiselect.$select.find('option').each((i, elem) => {
                            let option = $(elem);

                            option.prop('selected', values.indexOf(option.prop('value')) !== -1);
                        });

                        multiselect.refresh();

                        filter.attr('data-value', values.join('|'))
                    }
                });

                if(message)
                    notify('{!! trans('app/common.messages.reset_filters') !!}', 'info', 2000);
            }

            $('#btn-reset').on('click', function(){
                resetFilters();
                applyFilters(false);
            });

            function deleteEntries(){
                let rows = dt.rows('.selected').indexes(),
                    ids = Array.prototype.map.call(dt.rows(rows).data(), el => el.id);

                $.ajax({
                    type: 'post',
                    url: '{!! route('api.presses.delete') !!}',
                    data: {
                        'ids': ids
                    },
                    success: function (data, status, xhr){

                        if(xhr.status === 200){
                            notify('{!! trans('app/common.messages.delete_entries_success') !!}', 'success', 2000);
                            dt.draw(false);
                        }else{
                            notify('{!! trans('app/common.messages.delete_entries_error') !!}', 'danger', 2000);
                        }

                        applyFilters(false);
                    },
                    error: function (data){}
                })
            }

            $('#btn-delete').on('click', function(){
                swal({
                    title: '{!! trans('app/common.messages.confirm_delete_title') !!}',
                    text: '{!! trans('app/common.messages.confirm_delete_description') !!}',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{!! trans('app/common.messages.confirm_delete_confirm_button_text') !!}',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonText: '{!! trans('app/common.messages.confirm_delete_cancel_button_text') !!}',
                    cancelButtonClass: 'btn btn-light',
                }).then((confirm) => {
                    if(confirm.value){
                        deleteEntries();
                    }
                });
            });

            $('#btn-add').on('click', (e) => {
                window.location.href = '{!! route("admin.presses.form") !!}';
            });

        });
    </script>
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <div class="container-fluid">
                <div class="row filters px-4 pt-3">
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="title" data-filter-type="text" data-default-value="">
                        <label>{!! trans('app/presses.list.filters.title') !!}</label>
                        <input type="text" class="form-control input-sm" placeholder="{!! trans('app/presses.list.filters.title') !!}">
                    </div>
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="cities" data-filter-type="select" data-default-value="">
                        <label>{!! trans('app/presses.list.filters.city') !!}</label>
                        <div>
                            <select name="cities" class="form-control multi-select" data-placeholder="{!! trans('app/presses.list.filters.city') !!}" multiple>
                                @foreach($cities as $city)
                                    <option value="{!! $city->id !!}">{!! $city->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="types" data-filter-type="select" data-default-value="">
                        <label>{!! trans('app/presses.list.filters.type') !!}</label>
                        <div>
                            <select name="types" class="form-control multi-select" data-placeholder="{!! trans('app/presses.list.filters.type') !!}" multiple>
                                @foreach($types as $type)
                                    <option value="{!! $type->id !!}">{!! $type->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="categories" data-filter-type="select" data-default-value="">
                        <label>{!! trans('app/presses.list.filters.category') !!}</label>
                        <div>
                            <select name="categories" class="form-control multi-select" data-placeholder="{!! trans('app/presses.list.filters.category') !!}" multiple>
                                @foreach($categories as $category)
                                    <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="festivals" data-filter-type="select" data-default-value="">
                        <label>{!! trans('app/presses.list.filters.festival') !!}</label>
                        <div>
                            <select name="festivals" class="form-control multi-select" data-placeholder="{!! trans('app/presses.list.filters.festival') !!}" multiple>
                                @foreach($festivals as $festival)
                                    <option value="{!! $festival->id !!}">{!! $festival->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="published" data-filter-type="select" data-default-value="*">
                        <label>{!! trans('app/media.list.filters.published') !!}</label>
                        <div>
                            <select class="form-control" data-placeholder="Status">
                                <option value="*">{!! trans('app/common.all') !!}</option>
                                <option value="1">{!! trans('app/common.published.published') !!}</option>
                                <option value="0">{!! trans('app/common.published.unpublished') !!}</option>
                            </select>
                        </div>
                    </div>
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="created_at" data-filter-type="date-range" data-default-value="{!! $dates['min_created_at'] . '|' . $dates['max_created_at'] !!}">
                        <label>{!! trans('app/presses.list.filters.created_at') !!}</label>
                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input class="form-control input-sm date-range" placeholder="{!! trans('app/presses.list.filters.created_at') !!}">
                            <div class="form-control-feedback form-control-feedback-lg"><i class="icon-calendar2"></i></div>
                        </div>
                    </div>
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="updated_at" data-filter-type="date-range" data-default-value="{!! $dates['min_updated_at'] . '|' . $dates['max_updated_at'] !!}">
                        <label>{!! trans('app/presses.list.filters.updated_at') !!}</label>
                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input class="form-control input-sm date-range" placeholder="{!! trans('app/presses.list.filters.updated_at') !!}">
                            <div class="form-control-feedback form-control-feedback-lg"><i class="icon-calendar2"></i></div>
                        </div>
                    </div>
                </div>
                <div class="row my-3 px-3">
                    <div class="col-md-12 col-lg-4 col-xl-3 mb-2 lg-mb-0 text-left">
                        <select class="form-control multi-select" id="page-length" data-placeholder="Entries per page">
                            <option>20 {!! trans('app/common.entries_per_page') !!}</option>
                            <option>40 {!! trans('app/common.entries_per_page') !!}</option>
                            <option>60 {!! trans('app/common.entries_per_page') !!}</option>
                            <option>80 {!! trans('app/common.entries_per_page') !!}</option>
                            <option>100 {!! trans('app/common.entries_per_page') !!}</option>
                        </select>
                    </div>
                    <div class="buttons col-md-12 col-lg-8 col-xl-9 text-right">
                        <button type="button" class="btn btn-sm btn-success tooltip-helper" id="btn-add" data-toggle="tooltip" data-placement="top" title="add new" data-trigger="hover"><i class="icon-plus3"></i><span class="text"></span></button>
                        <button type="button" class="btn btn-sm btn-info tooltip-helper" id="btn-reset" data-toggle="tooltip" data-placement="top" title="reset filters" data-trigger="hover"><i class="icon-reset"></i><span class="text"></span></button>
                        <button type="button" class="btn btn-sm btn-primary tooltip-helper" id="btn-filter" data-toggle="tooltip" data-placement="top" title="apply filters" data-trigger="hover"><i class="icon-filter3"></i><span class="text"></span></button>
                        <button type="button" class="btn btn-sm btn-danger tooltip-helper" id="btn-delete" data-toggle="tooltip" data-placement="top" title="delete selected" data-trigger="hover"><i class="icon-trash"></i><span class="text"></span></button>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-styled">
                <thead>
                <tr>
                    <th width="20%">{!! trans('app/presses.list.table.columns.title') !!}</th>
                    <th width="15%">{!! trans('app/presses.list.table.columns.festival') !!}</th>
                    <th width="7%">{!! trans('app/presses.list.table.columns.city') !!}</th>
                    <th width="7%">{!! trans('app/presses.list.table.columns.type') !!}</th>
                    <th width="7%">{!! trans('app/presses.list.table.columns.category') !!}</th>
                    <th width="7%">{!! trans('app/media.list.table.columns.published') !!}</th>
                    <th width="7%">{!! trans('app/media.list.table.columns.published_at') !!}</th>
                    <th width="4%">{!! trans('app/presses.list.table.columns.actions') !!}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
