@extends('layouts.admin')

@section('title-icon')<i class="icon-cog3 mr-2"></i>@endsection

@section('title'){!! trans('app/settings.form.title.edit') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <span class="breadcrumb-item active">{!! trans('app/settings.form.title.edit') !!}</span>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/uploaders/dmUploader.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/ui/sortable.js') !!}"></script>
    <script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){


            $('form').on('submit', function(e){
                e.preventDefault();

                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                let data = {},
                    form = $(this);

                console.log(form.serializeArray());

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
                            window.location.href = '{!! route('admin.settings') !!}';
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
                <form class="form-validate-jquery" action="{!! route('api.settings.update') !!}" method="post">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="nav-item">
                            <a href="#main" class="nav-link active" data-toggle="tab">Main</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane px-2 active" id="main">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/settings.form.legends.main') !!}</legend>
                            <div class="px-2">
                                @foreach($settings as $name => $value)
                                @if (!$settings[$name]->is_translatable)
                                <div class="form-group row field" data-name="settings.{!! $name !!}">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/settings.form.fields.'.$name.'.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/settings.form.fields.'.$name.'.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="settings[{!! $name !!}]" class="form-control" placeholder="{!! trans('app/settings.form.fields.'.$name.'.label') !!}" autocomplete="off" value="{!! $settings[$name]->value !!}">
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                <?php /*
                                <div class="form-group row field" data-name="settings.phone">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.phone.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.phone.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="settings[phone]" class="form-control" placeholder="{!! trans('app/books.form.fields.phone.label') !!}" autocomplete="off" value="{!! $settings['phone']->value !!}">
                                    </div>
                                </div>

                                <div class="form-group row field" data-name="settings.facebook">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.facebook.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.facebook.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="settings[facebook]" class="form-control" placeholder="{!! trans('app/books.form.fields.facebook.label') !!}" autocomplete="off" value="{!! $settings['facebook']->value !!}">
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="settings.instagram">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.instagram.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.facebook.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="settings[instagram]" class="form-control" placeholder="{!! trans('app/books.form.fields.instagram.label') !!}" autocomplete="off" value="{!! $settings['instagram']->value !!}">
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="settings.youtube">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.youtube.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.youtube.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="settings[youtube]" class="form-control" placeholder="{!! trans('app/books.form.fields.youtube.label') !!}" autocomplete="off" value="{!! $settings['youtube']->value !!}">
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="settings.email">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.email.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.email.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="settings[email]" class="form-control" placeholder="{!! trans('app/books.form.fields.email.label') !!}" autocomplete="off" value="{!! $settings['email']->value !!}">
                                    </div>
                                </div>
                                */?>

                            </div>
                            <hr/>
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

                                @foreach($settings as $name => $value)
                                        @if ($settings[$name]->is_translatable)
                                        <fieldset class="mb-3">
                                        <div class="form-group row field" data-name="settings.{!! $name !!}.{!! $code !!}">
                                            <div class="col-lg-3">
                                                <label class="d-block float-left py-2 m-0">{!! trans('app/settings.form.fields.'.$name.'.label') !!}</label>
                                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/settings.form.fields.'.$name.'.rules') !!}"><i class="icon-info3"></i></span>
                                            </div>
                                            <div class="col-lg-9 field-body">
                                                <input type="text" name="settings[{!! $name !!}][{!! $code !!}]" class="form-control" placeholder="{!! trans('app/settings.form.fields.'.$name.'.label') !!}" autocomplete="off" value="{!! $settings[$name]->translate($code)->translated_value !!}">
                                            </div>
                                        </div>
                                        </fieldset>
                                        @endif
                                    @endforeach

                                <?php /*
                                            <div class="form-group row field" data-name="settings.address.{!! $code !!}">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.address.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.address.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="settings[address][{!! $code !!}]" class="form-control" placeholder="{!! trans('app/books.form.fields.address.label') !!}" autocomplete="off" value="{{ $settings['address']->translate($code)->translated_value }}">
                                                </div>
                                            </div>
                                    */?>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-styled ml-2">{!! trans('app/settings.form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection