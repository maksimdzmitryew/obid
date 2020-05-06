@extends('layouts.admin')

@section('title-icon')<i class="icon-images2 mr-2"></i>@endsection

@section('title'){!! $gallery->id ? trans('app/galleries.form.title.edit') : trans('app/galleries.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.galleries') !!}" class="breadcrumb-item">{!! trans('app/galleries.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $gallery->id ? trans('app/galleries.form.title.edit') : trans('app/galleries.form.title.create') !!}</span>
            </div>
            <a href="{!! $gallery->id ? route('admin.galleries.form', $gallery->id) : route('admin.galleries.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/forms/selects/select2.min.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/uploaders/dmUploader.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/ui/sortable.js') !!}"></script>
    <script src="{{ asset('/admin/js/forms.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            {{--{!! dd($gallery->images->toArray()) !!}--}}

            {{--var el = document.getElementById('previews'),--}}
                {{--images = JSON.parse('{!! $gallery->images->toJson() !!}');--}}

            new Sortable(document.getElementById('previews'), {
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
                            window.location.href = '{!! route('admin.galleries') !!}';
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
                <form class="form-validate-jquery" action="{!! $gallery->id ? route('api.galleries.update', $gallery->id) : route('api.galleries.store') !!}" method="post">
                    <div class="px-2">
                        <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/galleries.form.legends.main') !!}</legend>

                        @include('modules.image.admin_form', ['item' => $gallery, 'b_single' => 'FALSE'])
@php
/*

                        <div class="form-group row field" data-name="image_ids">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/galleries.form.fields.images.label') !!} <span class="text-danger">*</span></label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/galleries.form.fields.images.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <div class="file-preview-thumbnails" id="previews">

                                    @if($gallery->images->count())
                                        {{--{!! dd($gallery->images->toArray()) !!}--}}
                                        @foreach($gallery->images as $image)




                                            <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{!! $image->id !!}" data-id="{!! $image->id !!}">
                                                <div class="kv-file-content">
                                                    <img src="{!! $image->small_image_url !!}" class="file-preview-image kv-preview-data" title="{!! $image->name !!}" alt="{!! $image->name !!}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                                </div>
                                                <div class="file-thumbnail-footer">
                                                    <div class="file-footer-caption" title="{!! $image->name !!}">
                                                        <div class="file-caption-info">{!! $image->name !!}</div>
                                                        <div class="file-size-info"> <samp>({!! round($image->size / 1024, 2) !!} MB)</samp></div>
                                                    </div>
                                                    <div class="file-thumb-progress kv-hidden">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success progress-bar-success progress-bar-striped active" style="width:0%;">{!! trans('admin/file.initializing') !!}</div>
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
                                                        <input type="hidden" name="image_ids[]" value="{!! $image->id !!}">
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>

                                        @endforeach
                                    @endif
                                </div>
                                <div class="uniform-uploader"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">{!! trans('app/galleries.form.fields.images.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose File</span></div>
                            </div>
                        </div>
*/
@endphp






                        <div class="form-group row field" data-name="name">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.name.label') !!} <span class="text-danger">*</span></label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.name.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <input type="text" name="name" class="form-control" placeholder="{!! trans('app/galleries.form.fields.name.label') !!}" autocomplete="off" value="{{ $gallery->id ? $gallery->name : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-styled ml-2">{!! trans('app/news.form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div id="preview-tpl" class="d-none">
        <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-${id}" data-id="${id}">
            <div class="kv-file-content">
                <img src="${src}" class="file-preview-image kv-preview-data" title="Jane.jpg" alt="Jane.jpg" style="width:auto;height:auto;max-width:100%;max-height:100%;">
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
                    <input type="hidden" name="image_ids[]" disabled="disabled">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


@endsection