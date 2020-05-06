@extends('layouts.admin')

@section('title-icon')<i class="icon-books mr-2"></i>@endsection

@section('title'){!! $media->id ? trans('app/media.form.title.edit') : trans('app/media.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.media') !!}" class="breadcrumb-item">{!! trans('common/list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $media->id ? trans('app/media.form.title.edit') : trans('app/media.form.title.create') !!}</span>
            </div>
            <a href="{!! $media->id ? route('admin.media.form', $media->id) : route('admin.media.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/templates/jquery.tmpl.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/uploaders/dmUploader.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/ui/sortable.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            let picker = $('.datepicker').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'LLL'
                }
            }).on('apply.daterangepicker', (e, picker) => {
                picker.element.closest('.field').find('#published_at').prop('value', picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
            });

            picker.data('daterangepicker').setStartDate(moment(picker.data('date-from')).format('LLL'));
            picker.data('daterangepicker').setEndDate(moment(picker.data('date-to')).format('LLL'));



/*
            function options(ext){
                return {
                    url: '{!! route('api.upload.file') !!}',
                    multiple: false,
                    fieldName: 'file',
                    dataType: 'json',
                    extraData: {},
                    //allowedTypes: 'image/*',
                    extFilter: ext,
                    onNewFile: function(id, file){

                        let reader = new FileReader(),
                            container = $(this).closest('.field-body').find('#previews'),
                            preview = $(this).data('preview');

                        reader.onload = function(e) {
                            viewFile({
                                'id': id,
                                'name': file.name,
                                'size': (file.size / 1024 / 1024).toFixed(2),
                                'field_name': 'file_id',
                                'src': preview
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
                }
            }


            $('.file-uploader').dmUploader(options(['pdf', 'doc', 'docx']));

            $(document).on('click', '.kv-file-remove', (e) => {
                let image = $(e.target).closest('.file-preview-frame');

                deleteImage(image);
            });

            function viewFile(data, id, container){
                container.html($.tmpl($('#preview-tpl').html(), data));
                $('#preview-' + id).find('.data input').val(id).removeAttr('disabled');
            }

            function deleteImage(image){
                image.remove();
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
                            window.location.href = '{!! route('admin.media') !!}';
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
                <form class="form-validate-jquery" action="{!! $media->id ? route('api.media.update', $media->id) : route('api.media.store') !!}" method="post">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="nav-item">
                            <a href="#main" class="nav-link active" data-toggle="tab">Main</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane px-2 active" id="main">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('common/form.legends.main') !!}</legend>
                            <div class="px-2">
                                <div class="form-group row field" data-name="published">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.published.label') !!}</label>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input name="published" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $media->published ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="published_at">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.published_at.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.published_at.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="hidden" name="published_at" id="published_at" value="{!! $media->getOriginal('published_at') ?? now() !!}">
                                        <input type="text" class="form-control datepicker" placeholder="{!! trans('common/form.fields.published_at.label') !!}" autocomplete="off" data-date-from="{!! $media->getOriginal('published_at') ?? now() !!}" data-date-to="{!! $media->getOriginal('published_at') ?? now() !!}">
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="promoting">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/media.form.fields.promoting.label') !!}</label>
                                    </div>
                                    <div class="field-body form-check-switch form-check-switch-left">
                                        <input name="promoting" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $media->promoting ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>
                                @if($festivals)
                                    <div class="form-group row field" data-name="festival_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.festival_id.label') !!} <span class="text-danger">*</span></label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.festival_id.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="festival_id" class="form-control multi-select" data-placeholder="{!! trans('common/form.fields.festival_id.label') !!}">
                                                @foreach($festivals as $festival)
                                                    <option value="{!! $festival->id !!}" {!! $media->festival && $media->festival->id === $festival->id ? 'selected="selected"' : '' !!}>{!! $festival->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif


								@include('modules.file.admin_form', ['item' => $media, 'type' => 'doc'])

@php /*
                                <div class="form-group row field" data-name="file_id">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/media.form.fields.doc.label') !!} <span class="text-danger">*</span></label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/media.form.fields.doc.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>

                                    <div class="col-lg-9 field-body">
                                        <div class="file-preview-thumbnails" id="previews">
                                            @if($media->id && $media->file->id)
                                                <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $media->file->id }}" data-id="{{ $media->file->id }}">
                                                    <div class="kv-file-content text-center">
                                                        <img src="/admin/images/doc.png" class="file-preview-image kv-preview-data" title="{{ $media->file->name }}" alt="{{ $media->file->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                                    </div>
                                                    <div class="file-thumbnail-footer">
                                                        <div class="file-footer-caption" title="{{ $media->file->name }}">
                                                            <div class="file-caption-info">{{ $media->file->name }}</div>
                                                            <div class="file-size-info"> <samp>({{ $media->file->size }} KB)</samp></div>
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
                                                            <input type="hidden" name="file_id" value="{{ $media->file->id }}">
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="uniform-uploader file-uploader" data-preview="/admin/images/doc.png" data-ext="doc|docx|pdf"><input type="file" class="form-control-uniform"><span class="filename" style="user-select: none;">{!! trans('app/media.form.fields.doc.rules') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose File</span></div>
                                    </div>
                                </div>
*/ @endphp




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
                                            <div class="form-group row field" data-name="{!! $code !!}.author">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/media.form.fields.author.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/media.form.fields.author.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[author]" class="form-control" placeholder="{!! trans('app/media.form.fields.author.label') !!}" autocomplete="off" value="{{ $media->id ? $media->translate($code)->author : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.title">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.title.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[title]" class="form-control" placeholder="{!! trans('common/form.fields.title.label') !!}" autocomplete="off" value="{{ $media->id ? $media->translate($code)->title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.description.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" rows="3" cols="3" name="{!! $code !!}[description]" placeholder="{!! trans('common/form.fields.description.label') !!}">{{ $media->id ? $media->translate($code)->description : '' }}</textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-styled ml-2">{!! trans('common/form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php /*
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
