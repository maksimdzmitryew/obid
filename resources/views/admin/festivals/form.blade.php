@extends('layouts.admin')

@section('title-icon')<i class="icon-music mr-2"></i>@endsection

@section('title'){!! $festival->id ? trans('app/festivals.form.title.edit') : trans('app/festivals.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.festivals') !!}" class="breadcrumb-item">{!! trans('app/festivals.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $festival->id ? trans('app/festivals.form.title.edit') : trans('app/festivals.form.title.create') !!}</span>
            </div>
            <a href="{!! $festival->id ? route('admin.festivals.form', $festival->id) : route('admin.festivals.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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
    {{--<script src="{!! asset('/admin/js/plugins/uploaders/dmUploader.js') !!}"></script>--}}
    <script src="{!! asset('/admin/js/plugins/ui/sortable.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/pickers/picker_color.js') !!}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
//            var el = document.querySelector('.previews');
//
//            new Sortable(el, {
//                animation: 300,
//                delay: 0
//            });
/*
            $('#image-uploader').dmUploader({
                url:          '{!! route('api.upload.image') !!}',
                multiple:      false,
                fieldName:     'image',
                dataType:     'json',
                extraData:    {},
                allowedTypes: 'image/*',
                onNewFile: function(id, file){
                    let reader = new FileReader();

                    reader.onload = function(e) {
                        viewPhoto({
                            'id': id,
                            'name': file.name,
                            'size': (file.size / 1024 / 1024).toFixed(2),
                            'src': e.target.result,
                            'field_name': 'image_id',
                        }, id);
                    }

                    reader.readAsDataURL(file);
                },
                onUploadProgress: function(id, percent){
                    $('#preview-' + id).find('.file-thumb-progress').removeClass('kv-hidden').find('.progress .progress-bar').css('width', percent + '%');
                },
                onUploadSuccess: function(id, data){
                    $('#preview-' + id).attr('data-id', data.image.id).data('id', data.image.id);
                    $('#preview-' + id).find('.file-thumb-progress').addClass('kv-hidden');
                    $('#preview-' + id).find('img').attr('src', data.image.url);
                    $('#preview-' + id).find('.data input').val(data.image.id).removeAttr('disabled');
                },
                onUploadError: function(id, message){
                    notify(message, 'danger', 2000);
                },
            });

            $(document).on('click', '.kv-file-remove', (e) => {
                let image = $(e.target).closest('.file-preview-frame');

                deleteImage(image);
            });

            function viewPhoto(data, id){
                $('#previews').html($.tmpl($('#preview-tpl').html(), data));
                $('#preview-' + id).find('.data input').val(id).removeAttr('disabled');
            }

            function deleteImage(image){
                image.remove();
            }




            $('.uniform-uploader').dmUploader({
                url:          '{!! route('api.upload.file') !!}',
                multiple:      false,
                fieldName:     'file',
                dataType:     'json',
                extraData:    {},
                //allowedTypes: 'image/*',
                extFilter: ['pdf'],
                onNewFile: function(id, file){

                    let reader = new FileReader(),
                        container = $(this).closest('.field-body').find('#previews'),
                        lang = $(this).closest('.field-body').data('lang');

                    reader.onload = function(e) {
                        viewFile({
                            'id': id,
                            'name': file.name,
                            'size': (file.size / 1024 / 1024).toFixed(2),
                            'field_name': lang + '[file_id]',
                            'src': '/admin/images/doc.png'
                        }, id, container);
                    }

                    reader.readAsDataURL(file);
                },
                onUploadProgress: function(id, percent){
                    $('#preview-' + id).find('.file-thumb-progress').removeClass('kv-hidden').find('.progress .progress-bar').css('width', percent + '%');
                },
                onUploadSuccess: function(id, data){
                    $('#preview-' + id).attr('data-id', data.file.id).data('id', data.file.id);
                    $('#preview-' + id).find('.file-thumb-progress').addClass('kv-hidden');
                    //$('#preview-' + id).find('img').attr('src', data.file.url);
                    $('#preview-' + id).find('.data input').val(data.file.id).removeAttr('disabled');
                },
                onUploadError: function(id, message){
                    notify(message, 'danger', 2000);
                },
            });

            $(document).on('click', '.kv-file-remove', (e) => {
                let file = $(e.target).closest('.file-preview-frame');

                deleteFile(file);
            });

            function viewFile(data, id, container){
                container.html($.tmpl($('#preview-tpl').html(), data));
                $('#preview-' + id).find('.data input').val(id).removeAttr('disabled');
            }

            function deleteFile(file){
                file.remove();
            }

*/





            let select = $('.select2');

            select.select2({
                minimumResultsForSearch: Infinity,
                placeholder: select.data('placeholder'),
            });

            $('form').on('submit', function(e){
                e.preventDefault();

                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                let data = {},
                    form = $(this);

//                console.log(form.serializeArray());

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
                            window.location.href = '{!! route('admin.festivals') !!}';
                        }else{
                            form.find('fieldset').attr('disabled', false);
                        }
                    });

                    form.find('fieldset').attr('disabled', true);
                }).fail((xhr) => {
                    let data = xhr.responseJSON;

                    notify(data.message, 'danger', 3000);
                }).always((xhr, type, status) => {

                    let response = xhr.responseJSON || status.responseText,
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
                });
            });
            $('.form-check-input-switch').bootstrapSwitch();
        });
    </script>
@endsection

@section('content')
    {{--{!! dd($festival->image->id) !!}--}}
    <div class="card form">
        <div class="card-body p-0">
            <div class="card-body">
                <form class="form-validate-jquery" action="{!! $festival->id ? route('api.festivals.update', $festival->id) : route('api.festivals.store') !!}" method="post">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="nav-item">
                            <a href="#main" class="nav-link active" data-toggle="tab">Main</a>
                        </li>
                        <li class="nav-item">
                            <a href="#seo" class="nav-link" data-toggle="tab">SEO</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane px-2 active" id="main">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/festivals.form.legends.main') !!}</legend>
                            <div class="px-2">
                                {{--<div class="form-group row field" data-name="image_id">--}}
                                    {{--<div class="col-lg-3">--}}
                                        {{--<label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.preview.label') !!}</label>--}}
                                        {{--<span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.preview.rules') !!}"><i class="icon-info3"></i></span>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-9 field-body">--}}
                                        {{--<div class="file-preview-thumbnails previews" id="previews">--}}
                                            {{--@if($festival->image->id)--}}
                                                {{--<div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $festival->image->id }}" data-id="{{ $festival->image->id }}">--}}
                                                    {{--<div class="kv-file-content text-center">--}}
                                                        {{--<img src="{{ $festival->image->url }}" class="file-preview-image kv-preview-data" title="{{ $festival->image->name }}" alt="{{ $festival->image->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">--}}
                                                    {{--</div>--}}
                                                    {{--<div class="file-thumbnail-footer">--}}
                                                        {{--<div class="file-footer-caption" title="{{ $festival->image->name }}">--}}
                                                            {{--<div class="file-caption-info">{{ $festival->image->name }}</div>--}}
                                                            {{--<div class="file-size-info"> <samp>({{ $festival->image->size }} KB)</samp></div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="file-thumb-progress kv-hidden">--}}
                                                            {{--<div class="progress">--}}
                                                                {{--<div class="progress-bar bg-success progress-bar-success progress-bar-striped active" style="width:0%;">Initializing... </div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="file-upload-indicator">--}}
                                                            {{--<i class="icon-check text-success d-none"></i>--}}
                                                            {{--<i class="icon-cross2 text-danger d-none"></i>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="file-actions">--}}
                                                            {{--<div class="file-footer-buttons">--}}
                                                                {{--<button type="button" class="kv-file-remove" title="Remove file"><i class="icon-bin"></i></button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="data d-none">--}}
                                                            {{--<input type="hidden" name="image_id" value="{{ $festival->image->id }}">--}}
                                                        {{--</div>--}}
                                                        {{--<div class="clearfix"></div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                        {{--<div class="uniform-uploader" id="image-uploader"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">Select preview</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose File</span></div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--{!! dd($festival->image->toArray()) !!}--}}
                                @if($sliders)
                                    <div class="form-group row field" data-name="slider_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.slider_id.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.slider_id.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="slider_id" class="form-control multi-select" data-placeholder="{!! trans('app/festivals.form.fields.slider_id.label') !!}">
                                                <option value="">{!! trans('app/festivals.form.fields.slider_id.label') !!}</option>
                                                @foreach($sliders as $slider)
                                                    <option value="{!! $slider->id !!}" {!! $festival->slider && $festival->slider->id === $slider->id ? 'selected="selected"' : '' !!}>{!! $slider->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row field" data-name="year">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.year.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.year.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="year" class="form-control" placeholder="{!! trans('app/festivals.form.fields.year.label') !!}" autocomplete="off" value="{!! $festival->year !!}">
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="active">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.active.label') !!}</label>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input name="active" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $festival->active ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="published">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.published.label') !!}</label>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input name="published" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $festival->published ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="color">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.color.label') !!}</label>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input name="color" type="text" class="form-control colorpicker-show-input" value="{{$festival->color}}" data-preferred-format="hex" data-fouc>
                                    </div>
                                </div>

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
                                        <fieldset class="mb-3">
                                            <div class="form-group row field" data-name="{!! $code !!}.name">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.name.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.name.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[name]" class="form-control" placeholder="{!! trans('app/festivals.form.fields.name.label') !!}" autocomplete="off" value="{{ $festival->id ? $festival->translate($code)->name : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.slug">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.slug.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.slug.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[slug]" class="form-control" placeholder="{!! trans('app/festivals.form.fields.slug.label') !!}" autocomplete="off" value="{{ $festival->id ? $festival->translate($code)->slug : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.about_festival">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.about_festival.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.about_festival.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control ckeditor" rows="3" cols="3" name="{!! $code !!}[about_festival]" placeholder="{!! trans('app/festivals.form.fields.about_festival.label') !!}">{{ $festival->id ? $festival->translate($code)->about_festival : '' }}</textarea>
                                                </div>
                                            </div>

                                        	@include('modules.file.admin_form', ['item' => $festival, 'type' => 'doc'])

                                            <div class="form-group row field" data-name="{!! $code !!}.program_description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.program_description.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.program_description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" rows="3" cols="3" name="{!! $code !!}[program_description]" placeholder="{!! trans('app/festivals.form.fields.program_description.label') !!}">{{ $festival->id ? $festival->translate($code)->program_description : '' }}</textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane px-2" id="seo">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/festivals.form.legends.seo') !!}</legend>
                            <ul class="nav nav-tabs nav-tabs-highlight">
                                @foreach($localizations as $code => $localization)
                                    <li class="nav-item">
                                        <a href="#seo-{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!}" data-toggle="tab">
                                            <img src="{!! asset('admin/images/lang/' . $code . '.png') !!}" width="30rem" class="mr-1">
                                            {!! $localization !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($localizations as $code => $localization)
                                    <div class="tab-pane px-2 {!! $app->getLocale() === $code ? 'active' : ''!!}" id="seo-{!! $code !!}">
                                        <fieldset class="mb-3">
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_title">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.meta_title.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.meta_title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_title]" class="form-control" placeholder="{!! trans('app/festivals.form.fields.meta_title.label') !!}" autocomplete="off" value="{{ $festival->id ? $festival->translate($code)->meta_title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_keywords">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.meta_keywords.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.meta_keywords.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_keywords]" class="form-control" placeholder="{!! trans('app/festivals.form.fields.meta_keywords.label') !!}" autocomplete="off" value="{{ $festival->id ? $festival->translate($code)->meta_keywords : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.name.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.meta_description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" rows="3" cols="3" name="{!! $code !!}[meta_description]" placeholder="{!! trans('app/festivals.form.fields.meta_description.label') !!}">{{ $festival->id ? $festival->translate($code)->meta_description : '' }}</textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-styled ml-2">{!! trans('common/form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php /*
    @include('modules.image.admin_tpl_preview')
    <div id="preview-tpl=======BAK=======" class="d-none">
        <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-${id}" data-id="${id}">
            <div class="kv-file-content text-center">
                <img src="${src}" class="file-preview-image kv-preview-data" title="${name}" alt="${name}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
            </div>
            <div class="file-thumbnail-footer">
                <div class="file-footer-caption" title="${name}">
                    <div class="file-caption-info">${name}</div>
                    <div class="file-size-info"> <samp>(${size} MB)</samp></div>
                </div>
                <div class="file-thumb-progress kv-hidden">
                    <div class="progress">
                        <div class="progress-bar bg-success progress-bar-success progress-bar-striped active" style="width:0%;">Initializing... </div>
                    </div>
                </div>
                <div class="file-upload-indicator">
                    <i class="icon-check text-success d-none"></i>
                    <i class="icon-cross2 text-danger d-none"></i>
                </div>
                <div class="file-actions">
                    <div class="file-footer-buttons">
                        <button type="button" class="kv-file-remove" title="Remove file"><i class="icon-bin"></i></button>
                    </div>
                </div>
                <div class="data d-none">
                    <input type="hidden" name="${field_name}">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    */@endphp

@endsection