@extends('layouts.admin')

@section('title-icon')<i class="icon-newspaper mr-2"></i>@endsection

@section('title'){!! $press->id ? trans('app/presses.form.title.edit') : trans('app/presses.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.presses') !!}" class="breadcrumb-item">{!! trans('app/presses.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $press->id ? trans('app/presses.form.title.edit') : trans('app/presses.form.title.create') !!}</span>
            </div>
            <a href="{!! $press->id ? route('admin.presses.form', $press->id) : route('admin.presses.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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
    {{--<script src="{{ asset('/admin/js/plugins/uploaders/dmUploader.js') }}"></script>--}}
    <script src="{{ asset('/admin/js/plugins/ui/sortable.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
@endsection

@section('script')
    <script>

        function showTab(type){
            var tab_id = '';
            if (type === Object(type)) {
              tab_id = type.find(":selected").attr('data-id')
            } else {
              tab_id = type;
            }
            // TODO
            // "crutch" for default DE locale
            //tab_id = tab_id.replace('-1', '');
//            $('#div_tab-pressrelease, #div_tab-photo, #div_tab-video')
            $('#div_tab-11, #div_tab-13, #div_tab-23')
              .addClass('d-none').find('input, select')
              .prop('disabled', true);

            $(`#div_tab-${tab_id}`).removeClass('d-none').find('input, select').prop('disabled', false);
        }


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

            $('#types').on('change', (e) => {
                let target = $(e.currentTarget);
                showTab(target);
            });

            showTab($('#types'));

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
                            window.location.href = '{!! route('admin.presses') !!}';
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
                <form class="form-validate-jquery" action="{!! $press->id ? route('api.presses.update', $press->id) : route('api.presses.store') !!}" method="post">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="nav-item">
                            <a href="#main" class="nav-link active" data-toggle="tab">Main</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane px-2 active" id="main">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/presses.form.legends.main') !!}</legend>
                            <div class="px-2">
                                <div class="form-group row field" data-name="published">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.published.label') !!}</label>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input name="published" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $press->published ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="published_at">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.published_at.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.published_at.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="hidden" name="published_at" id="published_at" value="{!! $press->getOriginal('published_at') ??  now()!!}">
                                        <input type="text" class="form-control datepicker" placeholder="{!! trans('app/presses.form.fields.published_at.label') !!}" autocomplete="off" data-date-from="{!! $press->getOriginal('published_at') ?? now() !!}" data-date-to="{!! $press->getOriginal('published_at') ?? now() !!}">
                                    </div>
                                </div>
<?php
/*
// TODO keep for backward compatibility just in case
                                @if($types)
                                    <div class="form-group row field" data-name="type">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.type.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.type.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="type" id="types" class="form-control multi-select" data-placeholder="{!! trans('app/presses.form.fields.type.label') !!}">
                                                @foreach($types as $type)
                                                    <option value="{!! $type !!}" {!! $press->type === $type ? 'selected="selected"' : '' !!}>{!! $type !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
*/
?>
                                @if($types)
                                    <div class="form-group row field" data-name="type_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.type.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.type.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="type_id" id="types" class="form-control multi-select" data-placeholder="{!! trans('app/presses.form.fields.type.label') !!}">
                                                @foreach($types as $type)
                                                    <option data-id="{!! $type->id !!}" value="{!! $type->id !!}" {!! $press->type && $press->type->id === $type->id ? 'selected="selected"' : '' !!}>{!! $type->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                {{--press release--}}

                                <div id="div_tab-11" class="d-none">

									@include('modules.file.admin_form', ['item' => $press, 'type' => 'doc'])

                                	@php
                                	/*
                                    <div class="form-group row field" data-name="file_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.doc.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.doc.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <div class="file-preview-thumbnails" id="previews">
                                                @if($press->id && $press->file->id)
                                                    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $press->file->id }}" data-id="{{ $press->file->id }}">
                                                        <div class="kv-file-content text-center">
                                                            <img src="/admin/images/doc.png" class="file-preview-image kv-preview-data" title="{{ $press->file->name }}" alt="{{ $press->file->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                                        </div>
                                                        <div class="file-thumbnail-footer">
                                                            <div class="file-footer-caption" title="{{ $press->file->name }}">
                                                                <div class="file-caption-info">{{ $press->file->name }}</div>
                                                                <div class="file-size-info"> <samp>({{ $press->file->size }} KB)</samp></div>
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
                                                                <input type="hidden" name="file_id" value="{{ $press->file->id }}">
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="uniform-uploader doc-uploader" data-preview="/admin/images/doc.png" data-ext="doc|docx|pdf"><input type="file" class="form-control-uniform"><span class="filename" style="user-select: none;">{!! trans('app/presses.form.fields.doc.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose Doc</span></div>
                                        </div>
                                    </div>
                                    */
                                    @endphp

                                </div>
                                {{--photo--}}
                                <div id="div_tab-13" class="d-none">

									@include('modules.file.admin_form', ['item' => $press, 'type' => 'arc'])
									@include('modules.image.admin_form', ['item' => $press])

                                	@php
                                	/*
                                    <div class="form-group row field" data-name="file_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.arch.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/festivals.form.fields.arch.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <div class="file-preview-thumbnails previews" id="previews">
                                                @if($press->archive->id)
                                                    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $press->archive->id }}" data-id="{{ $press->archive->id }}">
                                                        <div class="kv-file-content text-center">
                                                            <img src="/admin/images/arch.png" class="file-preview-image kv-preview-data" title="{{ $press->archive->name }}" alt="{{ $press->archive->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                                        </div>
                                                        <div class="file-thumbnail-footer">
                                                            <div class="file-footer-caption" title="{{ $press->archive->name }}">
                                                                <div class="file-caption-info">{{ $press->archive->name }}</div>
                                                                <div class="file-size-info"> <samp>({!! round($press->archive->size / 1024, 2) !!} MB)</samp></div>
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
                                                                <input type="hidden" name="file_id" value="{{ $press->archive->id }}">
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="uniform-uploader" id="archive-uploader" data-type="doc" data-preview="/admin/images/arch.png" data-ext="zip|rar|7z"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">{!! trans('app/presses.form.fields.arch.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose Archive</span></div>
                                        </div>
                                    </div>

                                    <div class="form-group row field">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.preview.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.preview.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <div class="file-preview-thumbnails previews" id="previews">
                                                @if($press->image->id)
                                                    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $press->image->id }}" data-id="{{ $press->image->id }}">
                                                        <div class="kv-file-content text-center">
                                                            <img src="{{ $press->image->url }}" class="file-preview-image kv-preview-data" title="{{ $press->image->name }}" alt="{{ $press->image->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                                        </div>
                                                        <div class="file-thumbnail-footer">
                                                            <div class="file-footer-caption" title="{{ $press->image->name }}">
                                                                <div class="file-caption-info">{{ $press->image->name }}</div>
                                                                <div class="file-size-info"> <samp>({{ $press->image->size }} KB)</samp></div>
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
                                                                <input type="hidden" name="image_id" value="{{ $press->image->id }}">
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="uniform-uploader image-uploader" data-type="image" data-preview="/admin/images/arch.png" data-ext="gif|jpg|jpeg|png"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">{!! trans('app/presses.form.fields.preview.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose Preview</span></div>
                                        </div>
                                    </div>
                                    */
                                    @endphp

                                    @if( ! empty($galleries))
                                        <div class="form-group row field" data-name="galleries">
                                            <div class="col-lg-3">
                                                <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.gallery.label') !!}</label>
                                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.gallery.rules') !!}"><i class="icon-info3"></i></span>
                                            </div>
                                            <div class="col-lg-9 field-body">
                                                <select class="multi-select" name="gallery_id" id="gallery-id" data-placeholder="{!! trans('app/news.form.fields.gallery.label') !!}">
                                                    <option value="">{!! trans('app/news.form.fields.gallery.label') !!}</option>
                                                    @foreach($galleries as $gallery)
                                                        <option value="{{ $gallery->id }}"  {!! $press->gallery && $press->gallery->id === $gallery->id ? 'selected="selected"' : '' !!}>{{ $gallery->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                {{--video--}}
                                <div id="div_tab-23" class="d-none">
                                    <div class="form-group row field" data-name="links[youtube]">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.links.youtube.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.links.youtube.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <input type="text" name="links[youtube]" class="form-control" placeholder="{!! trans('app/presses.form.fields.links.youtube.label') !!}" autocomplete="off" value="{!! $press->links ? $press->links->youtube : '' !!}">
                                        </div>
                                    </div>
                                    <div class="form-group row field" data-name="links[vimeo]">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.links.vimeo.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.links.vimeo.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <input type="text" name="links[vimeo]" class="form-control" placeholder="{!! trans('app/presses.form.fields.links.vimeo.label') !!}" autocomplete="off" value="{!! $press->links ? $press->links->vimeo : '' !!}">
                                        </div>
                                    </div>
                                    <div class="form-group row field">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.preview.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.preview.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <div class="file-preview-thumbnails previews" id="previews">
                                                @if($press->image->id)
                                                    <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $press->image->id }}" data-id="{{ $press->image->id }}">
                                                        <div class="kv-file-content text-center">
                                                            <img src="{{ $press->image->url }}" class="file-preview-image kv-preview-data" title="{{ $press->image->name }}" alt="{{ $press->image->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                                        </div>
                                                        <div class="file-thumbnail-footer">
                                                            <div class="file-footer-caption" title="{{ $press->image->name }}">
                                                                <div class="file-caption-info">{{ $press->image->name }}</div>
                                                                <div class="file-size-info"> <samp>({{ $press->image->size }} KB)</samp></div>
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
                                                                <input type="hidden" name="image_id" value="{{ $press->image->id }}">
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="uniform-uploader image-uploader" data-type="image" data-preview="/admin/images/arch.png" data-ext="gif|jpg|jpeg|png"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">{!! trans('app/presses.form.fields.preview.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose Video Preview</span></div>
                                        </div>
                                    </div>
                                </div>
                                @if($festivals)
                                    <div class="form-group row field" data-name="festival_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.festival_id.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.festival_id.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="festival_id" class="form-control multi-select" data-placeholder="{!! trans('app/presses.form.fields.festival_id.label') !!}">
                                                @foreach($festivals as $festival)
                                                    <option value="{!! $festival->id !!}" {!! $press->festival && $press->festival->id === $festival->id ? 'selected="selected"' : '' !!}>{!! $festival->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if($cities)
                                    <div class="form-group row field" data-name="city_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.city_id.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.city_id.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="city_id" class="form-control multi-select" data-placeholder="{!! trans('app/presses.form.fields.city_id.label') !!}">
                                                @foreach($cities as $city)
                                                    <option value="{!! $city->id !!}" {!! $press->city && $press->city->id === $city->id ? 'selected="selected"' : '' !!}>{!! $city->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if($categories)
                                    <div class="form-group row field" data-name="category_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.category.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.category.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="category_id" class="form-control multi-select" data-placeholder="{!! trans('app/presses.form.fields.category.label') !!}">
                                                @foreach($categories as $category)
                                                    <option value="{!! $category->id !!}" {!! $press->category && $press->category->id === $category->id ? 'selected="selected"' : '' !!}>{!! $category->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
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
                                            <div class="form-group row field" data-name="{!! $code !!}.title">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.title.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[title]" class="form-control" placeholder="{!! trans('app/presses.form.fields.title.label') !!}" autocomplete="off" value="{{ $press->id ? $press->translate($code)->title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.volume">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.volume.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.volume.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[volume]" class="form-control" placeholder="{!! trans('app/presses.form.fields.volume.label') !!}" autocomplete="off" value="{{ $press->id ? $press->translate($code)->volume : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/presses.form.fields.description.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/presses.form.fields.description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" rows="3" cols="3" name="{!! $code !!}[description]" placeholder="{!! trans('app/presses.form.fields.description.label') !!}">{{ $press->id ? $press->translate($code)->description : '' }}</textarea>
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
                    <input type="hidden" name="image_id" name="${field_name}" disabled="disabled">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    */@endphp
@endsection
