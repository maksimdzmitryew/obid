@extends('layouts.admin')

@section('title-icon')<i class="fa fa-handshake-o mr-2"></i>@endsection

@section('title'){!! $partner->id ? trans('app/partners.form.title.edit') : trans('app/partners.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.partners') !!}" class="breadcrumb-item">{!! trans('app/partners.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $partner->id ? trans('app/partners.form.title.edit') : trans('app/partners.form.title.create') !!}</span>
            </div>
            <a href="{!! $partner->id ? route('admin.partners.form', $partner->id) : route('admin.partners.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            var el = document.getElementById('previews'),
                tpl = $('#preview-tpl').html();

/*
            $('.uniform-uploader').dmUploader({
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
                            'src': e.target.result
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

                deletePhoto(image);
            });

            function viewPhoto(data, id){
                //console.log(data, id);
                $('#previews').html($.tmpl(tpl, data));
                $('#preview-' + id).find('.data input').val(data.id);
            }

            function deletePhoto(image){
                image.remove();
            }
*/

            new Sortable(el, {
                animation: 300,
                delay: 0
            });

            let select = $('.select2');

            select.select2({
                minimumResultsForSearch: Infinity,
                placeholder: select.data('placeholder'),
            });

            $('form').on('submit', function(e){
                e.preventDefault();

                let data = {},
                    form = $(this);

                //console.log(form.serializeArray());

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
                            window.location.href = '{!! route('admin.partners') !!}';
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
                <form class="form-validate-jquery" action="{!! $partner->id ? route('api.partners.update', $partner->id) : route('api.partners.store') !!}" method="post">
                    <div class="px-2">
                        <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/partners.form.legends.main') !!}</legend>

                        <div class="form-group row field" data-name="title">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.title.label') !!} <span class="text-danger">*</span></label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.title.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <input type="text" name="title" class="form-control" placeholder="{!! trans('common/form.fields.title.label') !!}" autocomplete="off" value="{!! $partner->title !!}">
                            </div>
                        </div>

						@include('modules.image.admin_form', ['item' => $partner])

@php
/*

                        <div class="form-group row field" data-name="image_id">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/partners.form.fields.preview.label') !!} <span class="text-danger">*</span></label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/partners.form.fields.preview.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <div class="file-preview-thumbnails previews" id="previews">
                                    @if($partner->image->id)
                                        <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $partner->image->id }}" data-id="{{ $partner->image->id }}">
                                            <div class="kv-file-content text-center">
                                                <img src="{{ $partner->image->url }}" class="file-preview-image kv-preview-data" title="{{ $partner->image->name }}" alt="{{ $partner->image->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                            </div>
                                            <div class="file-thumbnail-footer">
                                                <div class="file-footer-caption" title="{{ $partner->image->name }}">
                                                    <div class="file-caption-info">{{ $partner->image->name }}</div>
                                                    <div class="file-size-info"> <samp>({{ $partner->image->size }} KB)</samp></div>
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
                                                    <input type="hidden" name="image_id" value="{{ $partner->image->id }}">
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="uniform-uploader" id="image-uploader"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">{!! trans('app/partners.form.fields.preview.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose File</span></div>
                            </div>
                        </div>
*/
@endphp

                        <div class="form-group row field" data-name="url">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/partners.form.fields.url.label') !!} <span class="text-danger">*</span></label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/partners.form.fields.url.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <input type="text" name="url" class="form-control" placeholder="{!! trans('app/partners.form.fields.url.label') !!}" autocomplete="off" value="{!! $partner->url !!}">
                            </div>
                        </div>
                        <div class="form-group row field" data-name="promoting">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/partners.form.fields.promoting.label') !!}</label>
                            </div>
                            <div class="field-body form-check-switch form-check-switch-left">
                                <input name="promoting" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $partner->promoting ? 'checked=checked' : '' !!}>
                            </div>
                        </div>
                        @if($categories)
                            <div class="form-group row field" data-name="category_id">
                                <div class="col-lg-3">
                                    <label class="d-block float-left py-2 m-0">{!! trans('app/partners.form.fields.category_id.label') !!}</label>
                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/partners.form.fields.category_id.rules') !!}"><i class="icon-info3"></i></span>
                                </div>
                                <div class="col-lg-9 field-body">
                                    <select name="category_id" class="form-control multi-select" data-placeholder="{!! trans('app/partners.form.fields.category_id.label') !!}">
                                        @foreach($categories as $category)
                                            <option value="{!! $category->id !!}" {!! $partner->category && $partner->category->id === $category->id ? 'selected="selected"' : '' !!}>{!! $category->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if($festivals)
                            <div class="form-group row field" data-name="festivals[]">
                                <div class="col-lg-3">
                                    <label class="d-block float-left py-2 m-0">{!! trans('app/partners.form.fields.festival_id.label') !!}</label>
                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/partners.form.fields.festival_id.rules') !!}"><i class="icon-info3"></i></span>
                                </div>
                                <div class="col-lg-9 field-body">
                                    <select name="festivals[]" class="form-control multi-select" data-placeholder="{!! trans('app/partners.form.fields.festival_id.label') !!}" multiple="multiple">
                                        {{--<option value="">{!! trans('app/partners.form.fields.festival_id.label') !!}</option>--}}
                                        @foreach($festivals as $festival)
                                            <option value="{!! $festival->id !!}" {!! $partner->festivals->pluck('id')->contains($festival->id) ? 'selected="selected"' : '' !!}>{!! $festival->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-styled ml-2">{!! trans('app/partners.form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php /*
    @include('modules.image.admin_tpl_preview')
    <div id="preview-tpl=======BAK=======" class="d-none">
        <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-${id}" data-id="${id}">
            <div class="kv-file-content">
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
                    <input type="hidden" name="image_id">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    */@endphp
@endsection