@extends('layouts.admin')

@section('title-icon')<i class="icon-books mr-2"></i>@endsection

@section('title'){!! $book->id ? trans('app/books.form.title.edit') : trans('app/books.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.books') !!}" class="breadcrumb-item">{!! trans('app/books.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $book->id ? trans('app/books.form.title.edit') : trans('app/books.form.title.create') !!}</span>
            </div>
            <a href="{!! $book->id ? route('admin.books.form', $book->id) : route('admin.books.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/css/common/waddon.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>

    <script src="{!! asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/forms/selects/select2.min.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>

    <script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>

    <script src="{!! asset('/admin/js/plugins/uploaders/dmUploader.js') !!}"></script>
    <script src="{{ asset('/admin/js/forms.js') }}"></script>

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
                            window.location.href = '{!! route('admin.books') !!}';
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
                <form class="form-validate-jquery" action="{!! $book->id ? route('api.books.update', $book->id) : route('api.books.store') !!}" method="post">
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
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/books.form.legends.main') !!}</legend>
                            <div class="px-2">

                            @include('modules.image.admin_form', ['item' => $book])
                            @include('modules.image.admin_gallery', ['item' => $book])

@php
/*

                                <div class="form-group row field" data-name="image_id">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.image_id.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.image_id.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <div class="file-preview-thumbnails previews" id="previews">
                                            @if($book->image->id)
                                                <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $book->image->id }}" data-id="{{ $book->image->id }}">
                                                    <div class="kv-file-content text-center">
                                                        <img src="{{ $book->image->url }}" class="file-preview-image kv-preview-data" title="{{ $book->image->name }}" alt="{{ $book->image->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                                    </div>
                                                    <div class="file-thumbnail-footer">
                                                        <div class="file-footer-caption" title="{{ $book->image->name }}">
                                                            <div class="file-caption-info">{{ $book->image->name }}</div>
                                                            <div class="file-size-info"> <samp>({{ $book->image->size }} KB)</samp></div>
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
                                                            <input type="hidden" name="image_id" value="{{ $book->image->id }}">
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="uniform-uploader" id="image-uploader"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">Select preview</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose File</span></div>
                                    </div>
                                </div>
*/
@endphp

                                <div class="form-group row field" data-name="url">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.url.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.url.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="url" class="form-control" placeholder="{!! trans('common/form.fields.url.label') !!}" autocomplete="off" value="{!! $book->url !!}">
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="api_code">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.api_code.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.api_code.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="api_code" class="form-control" placeholder="{!! trans('common/form.fields.api_code.label') !!}" autocomplete="off" value="{!! $book->api_code !!}">
                                    </div>
                                </div>
                                @if($festivals)
                                    <div class="form-group row field" data-name="festival_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.festival_id.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.festival_id.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="festival_id" class="form-control multi-select" data-placeholder="{!! trans('common/form.fields.festival_id.label') !!}">
                                                @foreach($festivals as $festival)
                                                    <option value="{!! $festival->id !!}" {!! $book->festival && $book->festival->id === $festival->id ? 'selected="selected"' : '' !!}>{!! $festival->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if($authors)
                                    <div class="form-group row field" data-name="author_ids">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.author_ids.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.author_ids.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="author_ids[]" class="form-control multi-select" data-placeholder="{!! trans('common/form.fields.author_ids.label') !!}" multiple>
                                                @foreach($authors as $author)
                                                    <option value="{!! $author->id !!}" {!! in_array($author->id, $book->authors->pluck('id')->toArray()) ? 'selected="selected"' : '' !!}>{!! $author->name !!}</option>
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
                                            <div class="form-group row field" data-name="{!! $code !!}.name">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.name.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.name.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[name]" class="form-control" placeholder="{!! trans('common/form.fields.name.label') !!}" autocomplete="off" value="{{ $book->id ? $book->translate($code)->name : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.slug">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.slug.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.slug.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[slug]" class="form-control" placeholder="{!! trans('common/form.fields.slug.label') !!}" autocomplete="off" value="{{ $book->id ? $book->translate($code)->slug : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.volume">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.volume.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.volume.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[volume]" class="form-control" placeholder="{!! trans('app/books.form.fields.volume.label') !!}" autocomplete="off" value="{{ $book->id ? $book->translate($code)->volume : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.excerpt">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.excerpt.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.excerpt.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[excerpt]" class="form-control" placeholder="{!! trans('app/books.form.fields.excerpt.label') !!}" autocomplete="off" value="{{ $book->id ? $book->translate($code)->excerpt : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.description.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control ckeditor" rows="3" cols="3" name="{!! $code !!}[description]" placeholder="{!! trans('common/form.fields.description.label') !!}">{{ $book->id ? $book->translate($code)->description : '' }}</textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane px-2" id="seo">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/books.form.legends.seo') !!}</legend>
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
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.meta_title.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.meta_title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_title]" class="form-control" placeholder="{!! trans('app/books.form.fields.meta_title.label') !!}" autocomplete="off" value="{{ $book->id ? $book->translate($code)->meta_title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_keywords">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.meta_keywords.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.meta_keywords.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_keywords]" class="form-control" placeholder="{!! trans('app/books.form.fields.meta_keywords.label') !!}" autocomplete="off" value="{{ $book->id ? $book->translate($code)->meta_keywords : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/books.form.fields.name.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/books.form.fields.meta_description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" rows="3" cols="3" name="{!! $code !!}[meta_description]" placeholder="{!! trans('app/books.form.fields.meta_description.label') !!}">{{ $book->id ? $book->translate($code)->meta_keywords : '' }}</textarea>
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
@endsection