@extends('layouts.admin')

@php
    $s_tmp              = request()->route()->getAction()['as'];
    $a_tmp              = explode('.', $s_tmp);
    $s_category         = mb_strtolower($a_tmp[1]);

    $s_cat_sgl_low      = mb_strtolower(trans('app/' . $s_category . '.names.sgl'));
    $s_cat_sgl_up       = mb_strtoupper($s_cat_sgl_low);
    $s_cat_sgl_u1       = ucfirst($s_cat_sgl_low);

    $s_cat_plr_low      = mb_strtolower(trans('app/' . $s_category . '.names.plr'));
    $s_cat_plr_up       = mb_strtoupper($s_cat_plr_low);
    $s_cat_plr_u1       = ucfirst($s_cat_plr_low);

    $s_list_route       = route('admin.' . $s_category);
    $s_list_name        = $s_cat_plr_u1 . ' ' . trans('common/form.breadcrumbs.list');
@endphp

@section('title-icon')<i class="{!! trans('app/' . $s_category . '.names.ico') !!} mr-2"></i>@endsection

@section('title'){!! trans('menu.pages') !!} {!! trans('common/list.title') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <span class="breadcrumb-item active">{!! trans('menu.pages') !!} {!! trans('common/list.title') !!}</span>
            </div>
            <a href="{!! route('admin.pages') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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

            let s_route_del = '{!! route("api.pages.delete") !!}';
            let s_route_add = '{!! route("admin.pages.form") !!}';

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
                        data: 'name'
                    },
                    {
                        data: 'created_at',
                        render: function(data){
                            return moment(data).format('LLL');
                        }
                    },
                    {
                        data: 'updated_at',
                        render: function(data){
                            return moment(data).format('LLL');
                        }
                    },
                    {
                        sortable: false,
                        data: function(row){
                            return `<a href="{!! route('admin.pages.form', [':id']) !!}" class="btn btn-sm btn-primary"><i class="icon-pencil"></i></a>`.replace(':id', row.id);
                        }
                    }
                ],
                ajax: {
                    url: '{!! route('api.pages.index') !!}',
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
                    <div class="filter col-md-12 col-lg-6 col-xl-4 py-2" data-name="name" data-filter-type="text" data-default-value="">
                        <label>{!! trans('common/list.filters.name') !!}</label>
                        <input type="text" class="form-control input-sm" placeholder="{!! trans('common/list.filters.name') !!}">
                    </div>

                    @include('admin.common.filters.created_at')
                    @include('admin.common.filters.updated_at')

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
                    <th width="1px">{!! trans('app/pages.list.table.columns.id') !!}</th>
                    <th width="10%">{!! trans('app/pages.list.table.columns.name') !!}</th>
                    <th width="20%">{!! trans('app/pages.list.table.columns.created_at') !!}</th>
                    <th width="20%">{!! trans('app/pages.list.table.columns.updated_at') !!}</th>
                    <th width="1px">{!! trans('app/pages.list.table.columns.actions') !!}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection