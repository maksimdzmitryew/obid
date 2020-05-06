@extends('layouts.admin')

@section('title-icon')<i class="icon-youtube mr-2"></i>@endsection

@section('title'){!! trans('app/media.list.title') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <span class="breadcrumb-item active">{!! trans('app/media.breadcrumbs.list') !!}</span>
            </div>
            <a href="{!! route('admin.media') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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

            let s_route_del = '{!! route("api.media.delete") !!}';
            let s_route_add = '{!! route("admin.media.form") !!}';

            @include('admin.common.filters.js')
            @include('admin.common.list_js')

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
                        data: 'id',
                        className: 'text-center'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'author'
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
                            return `<a href="{!! route('admin.media.form', [':id']) !!}" class="btn btn-sm btn-primary"><i class="icon-pencil"></i></a>`.replace(':id', row.id);
                        }
                    }
                ],
                ajax: {
                    url: '{!! route('api.media.index') !!}',
                    data: function(data){
                        data.filters = filters;
                    }
                }
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
                        <label>{!! trans('common/list.filters.title') !!}</label>
                        <input type="text" class="form-control input-sm" placeholder="{!! trans('common/list.filters.title') !!}">
                    </div>
                    @include('admin.festivals.filter')
                    @include('admin.common.filters.created_at')
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="published" data-filter-type="select" data-default-value="*">
                        <label>{!! trans('common/list.filters.published') !!}</label>
                        <div>
                            <select class="form-control" data-placeholder="Status">
                                <option value="*">{!! trans('app/common.all') !!}</option>
                                <option value="1">{!! trans('app/common.published.published') !!}</option>
                                <option value="0">{!! trans('app/common.published.unpublished') !!}</option>
                            </select>
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
                    <th width="1px">{!! trans('app/media.list.table.columns.id') !!}</th>
                    <th width="25%">{!! trans('app/media.list.table.columns.title') !!}</th>
                    <th width="25%">{!! trans('app/media.list.table.columns.author') !!}</th>
                    <th width="25%">{!! trans('app/media.list.table.columns.published') !!}</th>
                    <th width="25%">{!! trans('app/media.list.table.columns.published_at') !!}</th>
                    <th width="1px">{!! trans('app/media.list.table.columns.actions') !!}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection