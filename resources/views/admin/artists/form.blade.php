@extends('layouts.admin')

@section('title-icon')<i class="icon-mic2 mr-2"></i>@endsection

@section('title'){!! $artist->id ? trans('app/artists.form.title.edit') : trans('app/artists.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.artists') !!}" class="breadcrumb-item">{!! trans('app/artists.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $artist->id ? trans('app/artists.form.title.edit') : trans('app/artists.form.title.create') !!}</span>
            </div>
            <a href="{!! $artist->id ? route('admin.artists.form', $artist->id) : route('admin.artists.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/tags/tagsinput.min.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/uploaders/dmUploader.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/ui/sortable.js') !!}"></script>
    <script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            var el = document.getElementById('previews'),
                tpl = $('#preview-tpl').html();

            var sortable = new Sortable(el, {
                animation: 300,
                delay: 0
            });
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

                deleteImage(image);
            });

            function viewPhoto(data, id){
                $('#previews').html($.tmpl(tpl, data));
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


            function formatRepo (repo) {
                if (repo.loading) return repo.text;

                var markup =
                    '<div class="select2-result-repository clearfix">' +
                    '<div class="select2-result-repository__meta">' +
                    '<div class="select2-result-repository__title">' + repo.name + '</div>' +
                    '</div>' +
                    '</div>';

                return markup;
            }

            // Format selection
            function formatRepoSelection (repo) {
                return repo.name || repo.text;
            }

            function settings(params){
                return {
                    ajax: {
                        url: params.url,
                        dataType: 'json',
                        delay: 250,
                        data: function (settings) {
                            let filters = {};

                            filters[params.filter] = settings.term

                            return {
                                filters: filters
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data.data,
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) { return markup; },
                    minimumInputLength: 0,
                    templateResult: formatRepo,
                    templateSelection: formatRepoSelection
                }
            }

            $(document).on('click', '.delete-festival', (e) => {
                $(e.currentTarget).closest('.fest').remove();
            });

            $('#festivals .festival').select2(settings({
                url: '{!! route('api.festivals.index') !!}',
                filter: 'name'
            }));

            $('#festivals .new-order').select2();
            $('#festivals .new-profession').select2();

            $(document).on('click', '#add-festival', (e) => {
                let festival = $.tmpl($('#festival-tpl').html(), {
                    id: Math.random().toString(36).substring(2),
                }).appendTo('#festivals');

                festival.find('.festivals').select2(settings({
                    url: '{!! route('api.festivals.index') !!}',
                    filter: 'name'
                }));

                festival.find('.new-order').select2();
                festival.find('.new-profession').select2();

                $('#festivals .sw').bootstrapSwitch();
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
                            window.location.href = '{!! route('admin.artists') !!}';
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
                <form class="form-validate-jquery" action="{!! $artist->id ? route('api.artists.update', $artist->id) : route('api.artists.store') !!}" method="post">
                    <div class="px-2">
                        <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/artists.form.legends.main') !!}</legend>
                        <div class="form-group row field" data-name="festivals">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.festivals.label') !!}</label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.festivals.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <button type="button" id="add-festival" class="btn btn-primary tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/artists.form.fields.festival.label') !!}" data-trigger="hover"><i class="icon-plus3"></i></button>
                                <div id="festivals">
                                    @if($festivals->count())
                                        @foreach($festivals as $festival)
                                            <div class="fest p-3 mt-2" id="festival" style="border: 1px solid silver">
                                                <div class="buttons text-right">
                                                    <button type="button" class="btn btn-danger delete-festival tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.delete_holding') !!}" data-trigger="hover"><i class="icon-trash"></i></button>
                                                </div>
                                                <div class="form-group row field search-box-container" data-name="festivals.{!! $festival->id !!}.id">
                                                    <div class="col-lg-3">
                                                        <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.festival.label') !!}</label>
                                                    </div>
                                                    <div class="col-lg-9 field-body">
                                                        <select name="festivals[{!! $festival->id !!}][id]" class="festival" data-placeholder="{!! trans('app/artists.form.fields.festival.label') !!}">
                                                            <option value="{!! $festival->id !!}" selected="selected">{!! $festival->name !!}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row field" data-name="festivals.{!! $festival->id !!}.team_member">
                                                    <div class="col-lg-3">
                                                        <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.team_member.label') !!}</label>
                                                    </div>
                                                    <div class="col-lg-9 field-body form-check-switch form-check-switch-left">
                                                        <input name="festivals[{!! $festival->id !!}][team_member]" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $festival->team_member ? 'checked=checked' : '' !!}>
                                                    </div>
                                                </div>
                                                <div class="form-group row field" data-name="festivals.{!! $festival->id !!}.board_member">
                                                    <div class="col-lg-3">
                                                        <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.board_member.label') !!}</label>
                                                    </div>
                                                    <div class="col-lg-9field-body form-check-switch form-check-switch-left">
                                                        <input name="festivals[{!! $festival->id !!}][board_member]" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $festival->board_member ? 'checked=checked' : '' !!}>
                                                    </div>
                                                </div>

                                                @include('admin.artists.tpl_profession')
                                                @include('admin.artists.tpl_festival')

                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{--<div class="form-group row field" data-name="festivals[]">--}}
                            {{--<div class="col-lg-3">--}}
                                {{--<label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.festivals.label') !!} <span class="text-danger">*</span></label>--}}
                                {{--<span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.festivals.rules') !!}"><i class="icon-info3"></i></span>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-9 field-body">--}}
                                {{--<select name="festivals[]" class="form-control" id="festivals" data-placeholder="{!! trans('app/artists.form.fields.festivals.label') !!}" multiple="multiple">--}}
                                    {{--@foreach($artist_festivals as $festival)--}}
                                        {{--<option value="{!! $festival->id !!}" selected="selected">{!! $festival->name !!}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}

						@include('modules.image.admin_form', ['item' => $artist])

						@php
						/*

                        <div class="form-group row field" data-name="image_id">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.preview.label') !!}</label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.preview.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <div class="file-preview-thumbnails previews" id="previews">
                                    @if($artist->image->id)
                                        <div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb" id="preview-{{ $artist->image->id }}" data-id="{{ $artist->image->id }}">
                                            <div class="kv-file-content text-center">
                                                <img src="{{ $artist->image->url }}" class="file-preview-image kv-preview-data" title="{{ $artist->image->name }}" alt="{{ $artist->image->name }}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
                                            </div>
                                            <div class="file-thumbnail-footer">
                                                <div class="file-footer-caption" title="{{ $artist->image->name }}">
                                                    <div class="file-caption-info">{{ $artist->image->name }}</div>
                                                    <div class="file-size-info"> <samp>({{ $artist->image->size }} KB)</samp></div>
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
                                                    <input type="hidden" name="image_id" value="{{ $artist->image->id }}">
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="uniform-uploader" id="image-uploader"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">{!! trans('app/artists.form.fields.preview.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">Choose File</span></div>
                            </div>
                        </div>
						*/
						@endphp

                        <div class="form-group row field" data-name="url">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.url.label') !!}</label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.url.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <input type="text" name="url" class="form-control" placeholder="{!! trans('app/artists.form.fields.url.label') !!}" autocomplete="off" value="{!! $artist->url !!}">
                            </div>
                        </div>
                        <div class="form-group row field" data-name="email">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.email.label') !!}</label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.email.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <input type="text" name="email" class="form-control" placeholder="{!! trans('app/artists.form.fields.email.label') !!}" autocomplete="off" value="{!! $artist->email !!}">
                            </div>
                        </div>
                        <div class="form-group row field" data-name="facebook">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.facebook.label') !!}</label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.facebook.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <input type="text" name="facebook" class="form-control" placeholder="{!! trans('app/artists.form.fields.facebook.label') !!}" autocomplete="off" value="{!! $artist->facebook !!}">
                            </div>
                        </div>
                        {{-- waddon --}}
                        @if($vocations)
                            <div class="form-group row field" data-name="vocation_ids">
                                <div class="col-lg-3">
                                    <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.vocation_ids.label') !!}</label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.vocation_ids.rules') !!}"><i class="icon-info3"></i></span>
                                </div>
                                <div class="col-lg-9 field-body">
                                    <select name="vocation_ids[]" class="form-control multi-select" data-placeholder="{!! trans('app/artists.form.fields.vocation_ids.label') !!}" multiple>
                                        @foreach($vocations as $vocation)
                                            <option value="{!! $vocation->id !!}" {!! in_array($vocation->id, $artist->vocations->pluck('id')->toArray()) ? 'selected="selected"' : '' !!}>{!! $vocation->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        {{-- --}}
                    </div>
                    <hr/>
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        @foreach($localizations as $code => $localization)
                            <li class="nav-item">
                                <a href="#{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!}" data-toggle="tab">
                                    <img src="{!! asset('admin/images/lang/' . $code . '.png') !!}" width="30rem" class="mr-1">
                                    {!! $localization !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($localizations as $code => $localization)
                            <div class="tab-pane px-2 {!! $app->getLocale() === $code ? 'active' : ''!!}" id="{!! $code !!}">
                                <fieldset class="mb-3">
                                    <div class="form-group row field" data-name="{!! $code !!}.name">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.name.label') !!} <span class="text-danger">*</span></label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.name.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <input type="text" name="{!! $code !!}[name]" class="form-control" placeholder="{!! trans('app/artists.form.fields.name.label') !!}" autocomplete="off" value="{{ $artist->id ? $artist->translate($code)->name : '' }}">
                                        </div>
                                    </div>
@php
/*
                                    <div class="form-group row field" data-name="{!! $code !!}.profession">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0" style="color:red;"><strong>[ DEPRECATED profession ]</strong><br /> this value is no longer in use, it is kept for backward compatibility, and will be removed after all professions for all artists have been manually transferred per each festival for each artist</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="this value is no longer in use, it is kept for backward compatibility, and will be removed after all professions for all artists have been manually transferred per each festival for each artist"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <input type="text" name="{!! $code !!}[profession]" class="form-control" placeholder="{!! trans('app/artists.form.fields.profession.label') !!}" autocomplete="off" value="{{ $artist->id ? $artist->translate($code)->profession : '' }}">
                                        </div>
                                    </div>
*/
@endphp

                                    <div class="form-group row field" data-name="{!! $code !!}.about_festival">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.description.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/artists.form.fields.description.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <textarea class="form-control ckeditor" rows="3" cols="3" name="{!! $code !!}[description]" placeholder="{!! trans('app/artists.form.fields.description.label') !!}">{{ $artist->id ? $artist->translate($code)->description : '' }}</textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-styled ml-2">{!! trans('app/artists.form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('modules.image.admin_tpl_preview')
    @php /*
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
                    <input type="hidden" name="image_id" disabled="disabled">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    */@endphp

    <div id="festival-tpl" class="d-none">
        <div class="fest p-3 mt-2" id="festival" style="border: 1px solid silver">
            <div class="buttons text-right">
                <button type="button" class="btn btn-danger delete-festival tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.delete_holding') !!}" data-trigger="hover"><i class="icon-trash"></i></button>
            </div>
            <div class="form-group row field search-box-container" data-name="festivals.${id}.id">
                <div class="col-lg-3">
                    <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.festival.label') !!}</label>
                </div>
                <div class="col-lg-9 field-body">
                    <select name="festivals[${id}][id]" class="festivals" data-placeholder="{!! trans('app/artists.form.fields.festival.label') !!}">
                        <option>{!! trans('app/artists.form.fields.festival.label') !!}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row field" data-name="festivals.${id}.team_member">
                <div class="col-lg-3">
                    <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.team_member.label') !!}</label>
                </div>
                <div class="col-lg-9 field-body form-check-switch form-check-switch-left">
                    <input name="festivals[${id}][team_member]" value="1" type="checkbox" class="sw" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $artist->team_member ? 'checked=checked' : '' !!}>
                </div>
            </div>
            <div class="form-group row field" data-name="festivals.${id}.board_member">
                <div class="col-lg-3">
                    <label class="d-block float-left py-2 m-0">{!! trans('app/artists.form.fields.board_member.label') !!}</label>
                </div>
                <div class="col-lg-9 field-body form-check-switch form-check-switch-left">
                    <input name="festivals[${id}][board_member]" value="1" type="checkbox" class="sw" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $artist->board_member ? 'checked=checked' : '' !!}>
                </div>
            </div>
            @include('admin.artists.tpl_profession', ['festival' => null])
            @include('admin.artists.tpl_festival', ['festival' => null])
        </div>
    </div>

@endsection