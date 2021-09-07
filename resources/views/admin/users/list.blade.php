@extends('layouts.admin')

@section('title-icon')<i class="icon-users2 mr-2"></i>@endsection

@section('title'){!! trans('app/user.list.title') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <span class="breadcrumb-item active">{!! trans('app/user.breadcrumbs.list') !!}</span>
            </div>
            <a href="{!! route('admin.user.index') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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

@php
$s_category = 'user';
@endphp

@section('script')
    <script>
        $(document).ready(function(){

            moment.locale('{!! $app->getLocale() !!}');

            $('#page-length').on('change', function(){
                dt.page.len($(this).val()).draw(false);
            });

            let filters = {};

            let dt = $('.table').DataTable({
                'language': {
                    "aria"                      : {
                        "sortAscending" : '{!! trans('common/datatable.sortAscending') !!}',
                        "sortDescending": '{!! trans('common/datatable.sortDescending') !!}',
                        },
                    "decimal"                   : '{!! trans('common/datatable.decimal') !!}',
                    "emptyTable"            : '{!! trans('common/datatable.emptyTable') !!}',
                    'info'                      : '{!! trans('common/datatable.info') !!}',
                    'infoEmpty'             : '{!! trans('common/datatable.infoEmpty') !!}',
                    'infoFiltered'      : '{!! trans('common/datatable.infoFiltered') !!}',
                    "infoPostFix"           : '{!! trans('common/datatable.infoPostFix') !!}',
                    'lengthMenu'            : '{!! trans('common/datatable.lengthMenu') !!}',
                    "loadingRecords"    : '{!! trans('common/datatable.loadingRecords') !!}',
                    "paginate"              : {
                        "first"                 : '{!! trans('common/datatable.first') !!}',
                        "last"                  : '{!! trans('common/datatable.last') !!}',
                        "next"                  : '{!! trans('common/datatable.next') !!}',
                        "previous"          : '{!! trans('common/datatable.previous') !!}',
                        },
                    "processing"            : '{!! trans('common/datatable.processing') !!}',
                    "search"                    : '{!! trans('common/datatable.search') !!}',
                    "thousands"             : '{!! trans('common/datatable.thousands') !!}',
                    'zeroRecords'           : '{!! trans('common/datatable.zeroRecords') !!}',

                },
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
                order: [[ 2, "asc" ]],
                columns: [
                	@include('user._list_actions')
					@include('user._list_checkbox', ['s_name' => 'published', ])
                    {
                        data: 'first_name',
                        render: function(data, type, row){
                            return row.first_name + ' ' + row.last_name;
                        }
                    },
                    {
                        data: 'roles',
                        render: function(data){
                            return data.map(el => el.name).join(', ');
                        }
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'id',
                        className: 'text-center'
                    },
                ],
                ajax: {
                    url: '{!! route('api.user.index') !!}',
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

                                this.$select.closest('.filter').attr('data-value', values.join('|'));

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

            s_route_del = '{!! route('api.user.destroy') !!}';
            function deleteEntries(){
                let rows = dt.rows('.selected').indexes(),
                    ids = Array.prototype.map.call(dt.rows(rows).data(), el => el.id);

                $.ajax({
                    type: 'post',
                    url: s_route_del,
                    data: {
                        'ids': ids
                    },
                    success: function (data, status, xhr){

                        if(xhr.status === 200){
                            notify('{!! trans('common/messages.delete_entries_success') !!}', 'success', 2000);
                            dt.draw(false);
                        }else{
                            notify('{!! trans('common/messages.delete_entries_error') !!}', 'danger', 2000);
                        }

                        applyFilters(false);
                    },
                    error: function (data){}
                })
            }
/*
            function deleteEntries(){
                let rows = dt.rows('.selected').indexes(),
                    ids = Array.prototype.map.call(dt.rows(rows).data(), el => el.id);

                $.ajax({
                    type: 'post',
                    url: '{!! route('api.user.destroy') !!}',
                    data: {
                        'ids': ids
                    },
                    success: function (data, status, xhr){

                        if(xhr.status === 200){
                            notify(data.message, 'success', 2000);
                            dt.draw(false);
                        }else{
                            notify('{!! trans('app/common.messages.delete_entries_error') !!}' + data.message, 'danger', 2000);
                        }

                        applyFilters(false);
                    },
                    error: function (data){}
                })
            }
*/
            $('#btn-delete').on('click', function(){

                a_params = {
                    reverseButtons:     true,
                    showCloseButton:    true,
                    icon:               'warning',
                    title:              '{!! trans('common/messages.confirm_delete_title') !!}',
                    text:               '{!! trans('common/messages.confirm_delete_description') !!}',
                    confirmButtonText:  '{!! trans('common/messages.confirm_delete_cancel_button_text') !!}',
                    cancelButtonText:   '{!! trans('common/messages.confirm_delete_confirm_button_text') !!}',
                    showCancelButton:   true,
                };

                Swal.fire(
                    a_params
                ).then((result) => {
                    if (result.value) {
                        notify('{!! trans('common/messages.delete_entries_cancelled') !!}', 'info', 2000);
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        deleteEntries();
                    }
                })
                ;
            });

/*
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
*/
            $('#btn-add').on('click', (e) => {
                window.location.href = '{!! route('admin.user.form') !!}';
            });

        });
    </script>
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <div class="container-fluid">
                <div class="row filters px-4 pt-3">

					@include('user._filter_text', ['name' => 'first_name'])
					@include('user._filter_text', ['name' => 'last_name'])
					@include('user._filter_text', ['name' => 'email'])
					@include('admin.common.filters.created_at')
					@include('admin.common.filters.updated_at')

                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="roles" data-filter-type="select" data-default-value="">
                        <label>{!! trans('user/crud.filter.label') !!} {!! trans('user/crud.field.role.filterby') !!}</label>
                        <div>
                            <select name="roles" class="form-control multi-select" data-placeholder="{!! trans('user/crud.hint.select') !!} {!! trans('user/crud.field.role.typein') !!}" multiple>
                                @foreach($roles as $role)
                                    <option value="{!! $role->id !!}">{!! $role->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row my-3 px-3">
					@include('user._filter_perpage')
					@include('user._filter_buttons')
                </div>
            </div>
            <table class="table table-bordered table-striped table-styled">
                <thead>
                    <tr>
                        <th width="1px">{!! trans('user/crud.table.actions') !!}</th>
						<th width="5%">{!! trans('user/crud.field.active.label') !!}</th>
                        <th width="50%">{!! trans('user/crud.field.first_name.label') !!} & {!! trans('user/crud.field.last_name.label') !!}</th>
                        <th width="10%">{!! trans('user/crud.field.role.label') !!}</th>
                        <th width="30%">{!! trans('user/crud.field.email.label') !!}</th>
                        <th width="1px">{!! trans('user/crud.field.id.label') !!}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
