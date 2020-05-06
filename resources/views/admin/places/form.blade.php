@extends('layouts.admin')

@section('title-icon')<i class="icon-pin-alt mr-2"></i>@endsection

@section('title'){!! $place->id ? trans('app/places.form.title.edit') : trans('app/places.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.places') !!}" class="breadcrumb-item">{!! trans('app/places.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $place->id ? trans('app/places.form.title.edit') : trans('app/places.form.title.create') !!}</span>
            </div>
            <a href="{!! $place->id ? route('admin.places.form', $place->id) : route('admin.places.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/selects/select2.min.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            let select = $('.select2');

            select.select2({
                minimumResultsForSearch: Infinity,
                placeholder: select.data('placeholder'),
            });

            $('form').on('submit', function(e){
                e.preventDefault();

                let data = {},
                    form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize()
                }).done((data, status, xhr) => {

                    swal({
                        title: data.message,
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'View list',
                        confirmButtonClass: 'btn btn-primary',
                        cancelButtonText: 'Continue...',
                        cancelButtonClass: 'btn btn-light',
                    }).then((confirm) => {
                        if(confirm.value){
                            window.location.href = '{!! route('admin.places') !!}';
                        }else{
                            form.find('fieldset').attr('disabled', false);
                        }
                    });

                    form.find('fieldset').attr('disabled', true);
                }).fail((xhr) => {
                    let data = xhr.responseJSON;

                    notify(data.message, 'danger', 3000);
                }).always((xhr, type, status) => {

                    let response = xhr.responseJSON || status.responseJSON,
                        errors = response.errors || [];

                    form.find('.field').each((i, el) => {
                        let field = $(el),
                            container = field.find(`.field-body`),
                            elem = $('<label class="message">');

                        container.find('label.message').remove();

                        if(errors[field.data('name')]){
                            errors[field.data('name')].forEach((msg) => {
                                elem.clone().addClass('validation-invalid-label').html(msg).appendTo(container);
                            });
                        }else{
                            //elem.clone().addClass('validation-valid-label').html('Success').appendTo(container);
                        }

                    });
                })
            });
        });
    </script>
@endsection

@section('content')
    <div class="card form">
        <div class="card-body p-0">
            <div class="card-body">
                <form class="form-validate-jquery" action="{!! $place->id ? route('api.places.update', $place->id) : route('api.places.store') !!}" method="post">
                    <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/artists.form.legends.main') !!}</legend>
                    <div class="px-2">
                        @if($cities)
                            <div class="form-group row field" data-name="city_id">
                                <div class="col-lg-3">
                                    <label class="d-block float-left py-2 m-0">{!! trans('app/places.form.fields.city_id.label') !!}</label>
                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/places.form.fields.city_id.rules') !!}"><i class="icon-info3"></i></span>
                                </div>
                                <div class="col-lg-9 field-body">
                                    <select name="city_id" class="form-control multi-select" data-placeholder="{!! trans('app/places.form.fields.city_id.label') !!}">
                                        @foreach($cities as $city)
                                            <option value="{!! $city->id !!}" {!! $place->city && $place->city->id === $city->id ? 'selected="selected"' : '' !!}>{!! $city->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        @foreach($localizations as $code => $localization)
                            <li class="nav-item">
                                <a href="#main-{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!}" data-toggle="tab">
                                    <img src="{!! asset('admin/images/lang/' . $code . '.png') !!}" width="30rem" class="mr-1">
                                    {!! $localization !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($localizations as $code => $localization)
                            <div class="tab-pane px-2 {!! $app->getLocale() === $code ? 'active' : ''!!}" id="main-{!! $code !!}">
                                <fieldset class="mb-3">
                                    <div class="form-group row field" data-name="{!! $code !!}.name">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/places.form.fields.name.label') !!} <span class="text-danger">*</span></label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/places.form.fields.name.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <input type="text" name="{!! $code !!}[name]" class="form-control" placeholder="{!! trans('app/places.form.fields.name.label') !!}" autocomplete="off" value="{{ $place->id ? $place->translate($code)->name : '' }}">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-styled ml-2">{!! trans('app/places.form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection