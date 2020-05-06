@extends('layouts.admin')

@section('title-icon')<i class="icon-images2 mr-2"></i>@endsection

@section('title'){!! $slider->id ? trans('app/sliders.form.title.edit') : trans('app/sliders.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.sliders') !!}" class="breadcrumb-item">{!! trans('app/sliders.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $slider->id ? trans('app/sliders.form.title.edit') : trans('app/sliders.form.title.create') !!}</span>
            </div>
            <a href="{!! $slider->id ? route('admin.sliders.form', $slider->id) : route('admin.sliders.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
@endsection

@section('js')
    <script src="{!! asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/forms/selects/select2.min.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/uploaders/dmUploader.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/ui/sortable.js') !!}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            var el = document.getElementById('previews');

            var sortable = new Sortable(el, {
                animation: 300,
                delay: 0,
                scrollSensitivity: 100,
                onStart: function (evt) {
                    $('.slide-preview-frame .tabs, .slide-preview-frame .file-footer-caption, .slide-preview-frame .file-thumbnail-footer').css('display', 'none');
                },
                onEnd: function (evt) {
                    $('.slide-preview-frame .tabs, .slide-preview-frame .file-footer-caption, .slide-preview-frame .file-thumbnail-footer').show(400);
                    calculatePositions();
                },
            });

			let img_tpl = $('#preview-img-tpl')
								.html()
								// 1) we need to hide the template's src="${img}" by commenting it output
								// 2) otherwise there will be 404 not found error in browser logs:
								// when the page first load into a browser
								// e.g. GET /poland/$%7Bimage%7D HTTP/1.1 404
								.replace('<!--', '')
								.replace('-->', '')
				;
			let slide_tpl = $('#preview-slide-tpl')
								.html()
								.replace('preview_img_tpl', img_tpl)
								// 1) we need to hide the template's src="${img}" by commenting it output
								// 2) otherwise there will be 404 not found error in browser logs:
								// when the page first load into a browser
								// e.g. GET /poland/$%7Bimage%7D HTTP/1.1 404
								.replace('<!--', '')
								.replace('-->', '')
							;

            $('.uniform-uploader').dmUploader({
                url:          '{!! route('api.upload.image') !!}',
                fieldName:    'image',
                dataType:     'json',
                extraData:    {},
                allowedTypes: 'image/*',
                onNewFile: function(id, file){
                    let reader = new FileReader();

					// image replacement
					if ($(this).hasClass('image-uploader')) i_slide_id = $(this).attr('data-slide-id')
					// slide creation and image upload
					else i_slide_id = id;

					reader.onload = function(e) {
						if (i_slide_id != id)
						// image replacement
						{
							let el = $("#preview-" + i_slide_id + ' .file-thumbnail-header');
							el.next().addClass('d-none');
							el.after(
								$.tmpl(
									img_tpl
									,
									{
										'id': i_slide_id,
										'image': {
											'original': file.name,
											'size': (file.size / 1024 / 1024).toFixed(2),
											'url': e.target.result
										}
									}
								)
							);
						}
						else
						// slide creation and image upload
						{
							viewSlide({
								'id': i_slide_id,
								'image': {
									'original': file.name,
									'size': (file.size / 1024 / 1024).toFixed(2),
									'url': e.target.result
								}
							});
						}
					}
					reader.readAsDataURL(file);
				},
				onUploadProgress: function(id, percent){
					// image replacement
					if ($(this).hasClass('image-uploader')) i_slide_id = $(this).attr('data-slide-id')
					// slide creation and image upload
					else i_slide_id = id;

					$('#preview-' + i_slide_id).find('.file-thumb-progress').removeClass('kv-hidden').find('.progress .progress-bar').css('width', percent + '%');
				},
				onUploadSuccess: function(id, data){
					// image replacement
					if ($(this).hasClass('image-uploader')) i_slide_id = $(this).attr('data-slide-id')
					// slide creation and image upload
					else i_slide_id = id;

					$('#preview-' + i_slide_id).find('.file-thumb-progress').addClass('kv-hidden');

					if (i_slide_id != id)
						// image replacement
						{
						let image = $("#preview-" + i_slide_id + ' .file-preview-frame');

						image.replaceWith(
							$.tmpl(
								img_tpl
								,
								{
									'id': i_slide_id,
									'image': data.image
								}
							)
						);
	            	}
	            	else
            		// slide creation and image upload
	            	{
						$('#preview-' + id).replaceWith(
							$.tmpl(
								slide_tpl
								,
								{
									'id': id,
									'position': data.position,
									'image': data.image
								}
							)
						);
	            	}
                    calculatePositions();
                },
                onUploadError: function(id, message){
                    notify(message, 'danger', 2000);
                },
            });

            $(document).on('click', '.kv-slide-remove', (e) => {
                let slide = $(e.target).closest('.slide-preview-frame');
                slide.remove();
                calculatePositions();
            });

            $(document).on('click', '.kv-file-remove', (e) => {
                let image = $(e.target).closest('.file-preview-frame');

                {{--$.ajax({--}}
                    {{--'url': '{!! route('api.file.delete', ['${id}']) !!}'.replace('${id}', image.data('id')),--}}
                    {{--'type': 'POST',--}}
                    {{--'dataType': 'json',--}}
                    {{--'success': function(data){--}}
                        {{--console.log(1, data);--}}
                    {{--},--}}
                    {{--'error': function(data){--}}
                        {{--console.log(0, data);--}}
                    {{--}--}}
                {{--});--}}

                image.next().removeClass('d-none');
                // hide previous image
                //image.addClass('kv-hidden');
                image.remove();
            });

            function viewSlide(data){
				$.tmpl(slide_tpl, data).appendTo('#previews');
			}

            function calculatePositions(){
                $('.slide-preview-frame').each((i, el) => {
                    $(el).find('.position-slide input').val(i);
                });
            }

            let select = $('.select2');

            select.select2({
                minimumResultsForSearch: Infinity,
                placeholder: select.data('placeholder'),
            });

            $('form').on('submit', function(e){
                e.preventDefault();

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
                            window.location.href = '{!! route('admin.sliders') !!}';
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
    {{--{!! dd($slider->slides->toArray()) !!}--}}
    <div class="card form">
        <div class="card-body p-0">
            <div class="card-body">
                <form class="form-validate-jquery" action="{!! $slider->id ? route('api.sliders.update', $slider->id) : route('api.sliders.store') !!}" method="post">
                    <div class="px-2">
                        <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/sliders.form.legends.main') !!}</legend>
                        <div class="form-group row field" data-name="name">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.title.label') !!} <span class="text-danger">*</span></label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/sliders.form.fields.title.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <input type="text" name="name" class="form-control" placeholder="{!! trans('app/sliders.form.fields.title.label') !!}" autocomplete="off" value="{!! $slider->name !!}">
                            </div>
                        </div>
                        <div class="form-group row field" data-name="slides">
                            <div class="col-lg-3">
                                <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.slides.label') !!}</label>
                                <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/sliders.form.fields.slides.rules') !!}"><i class="icon-info3"></i></span>
                            </div>
                            <div class="col-lg-9 field-body">
                                <div class="file-preview-thumbnails" id="previews">
                                    @if($slider->slides)
                                        @foreach($slider->slides as $slide)
                                            <div class="w-100">
                                                <div class="slide-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb m-0 mb-2" id="preview-{!! $slide->id !!}" data-id="{!! $slide->id !!}">
											        <div class="file-thumbnail-header">
                                                        <div class="file-actions">
                                                            <div class="file-footer-buttons">
                                                                <button type="button" class="kv-slide-remove" title="{!! trans('admin/file.remove-slide') !!}"><i class="icon-bin"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>

													<div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb m-0 mb-2" id="preview-image-{!! $slide->image->id !!}" data-id="{!! $slide->image->id !!}">
													    <div class="kv-file-content text-center" style="height: 8rem">
													        <img src="{!! $slide->image->url !!}" class="file-preview-image kv-preview-data" title="{!! $slide->image->original !!}" alt="{!! $slide->image->name !!}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
													    </div>
													    <div class="row w-100 field d-none" data-name="slides.{!! $slide->id !!}.image_id" id="image-id-{!! $slide->image->id !!}">
													        <div class="col-lg-4">
													            <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.position.label') !!} <span class="text-danger">*</span></label>
													        </div>
													        <div class="col-lg-8 field-body">
													            <input type="text" name="slides[{!! $slide->id !!}][image_id]" value="{!! $slide->image->id !!}" class="form-control" placeholder="{!! trans('app/sliders.form.fields.position.label') !!}"/>
													        </div>
													    </div>
													    <div class="file-thumbnail-footer">
													        <div class="file-thumb-progress kv-hidden">
													            <div class="progress">
													                <div class="progress-bar bg-success progress-bar-success progress-bar-striped active" style="width:0%;">{!! trans('admin/file.initializing') !!}</div>
													            </div>
													        </div>
													        <div class="file-actions">
													            <div class="file-footer-buttons">
													                <button type="button" class="kv-file-remove" title="{!! trans('admin/file.remove-image') !!}"><i class="icon-bin"></i></button>
													            </div>
													        </div>
													        <div class="file-footer-caption" title="{!! $slide->image->original !!}">
													            <div class="file-caption-info">{!! $slide->image->original !!}</div>
													            <div class="file-size-info"> <samp>({!! round($slide->image->size / 1024, 2) !!} MB)</samp></div>
													        </div>
													    </div>
													</div>

													<div class="uniform-uploader image-uploader d-none" data-slide-id="{!! $slide->id !!}" data-image-id="{!! $slide->image->id !!}"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">{!! trans('common/form.fields.image_id.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">{!! trans('common/form.fields.image_id.label') !!}</span></div>

                                                    <div class="clearfix"></div>

                                                    <div class="position-slide row w-100 field d-none" data-name="slides.{!! $slide->id !!}.position" id="position-slide-{!! $slide->id !!}">
                                                        <div class="col-lg-4">
                                                            <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.position.label') !!} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-lg-8 field-body">
                                                            <input type="text" name="slides[{!! $slide->id !!}][position]" value="{!! $slide->position !!}" class="form-control" placeholder="{!! trans('app/sliders.form.fields.position.label') !!}"/>
                                                        </div>
                                                    </div>
                                                    <div class="tabs p-2">
                                                        <ul class="nav nav-tabs nav-tabs-highlight">
                                                            @foreach($localizations as $code => $localization)
                                                                <li class="nav-item">
                                                                    <a href="#slider-{!! $slider->id !!}-{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!}" data-toggle="tab">
                                                                        <img src="{!! asset('admin/images/lang/' . $code . '.png') !!}" width="30rem" class="mr-1">
                                                                        {!! $localization !!}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="tab-content">
                                                            @foreach($localizations as $code => $localization)
                                                                <div class="tab-pane px-2 data {!! $app->getLocale() === $code ? 'active' : ''!!}" id="slider-{!! $slider->id !!}-{!! $code !!}">
                                                                    <div class="row w-100 field" data-name="slides.{!! $slide->id !!}.{!! $code !!}.upper_title" id="upper_title">
                                                                        <div class="col-lg-4">
                                                                            <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.upper_title.label') !!} <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-lg-8 field-body">
                                                                            <input value="{!! $slide->translate($code)->upper_title !!}" type="text" name="slides[{!! $slide->id !!}][{!! $code !!}][upper_title]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.upper_title.label') !!}"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row w-100 field" data-name="slides.{!! $slide->id !!}.{!! $code !!}.title" id="title">
                                                                        <div class="col-lg-4">
                                                                            <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.title.label') !!} <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-lg-8 field-body">
                                                                            <input value="{!! $slide->translate($code)->title !!}" type="text" name="slides[{!! $slide->id !!}][{!! $code !!}][title]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.title.label') !!}"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row w-100 field" data-name="slides.{!! $slide->id !!}.{!! $code !!}.description" id="description">
                                                                        <div class="col-lg-4">
                                                                            <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.description.label') !!} <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-lg-8 field-body">
                                                                            <input value="{!! $slide->translate($code)->description !!}" type="text" name="slides[{!! $slide->id !!}][{!! $code !!}][description]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.description.label') !!}"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row w-100 field" data-name="slides.{!! $slide->id !!}.{!! $code !!}.button_text" id="button-text">
                                                                        <div class="col-lg-4">
                                                                            <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.button_text.label') !!} <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-lg-8 field-body">
                                                                            <input value="{!! $slide->translate($code)->button_text !!}" type="text" name="slides[{!! $slide->id !!}][{!! $code !!}][button_text]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.button_text.label') !!}"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row w-100 field" data-name="slides.{!! $slide->id !!}.{!! $code !!}.button_url" id="button-url">
                                                                        <div class="col-lg-4">
                                                                            <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.button_url.label') !!} <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-lg-8 field-body">
                                                                            <input value="{!! $slide->translate($code)->button_url  !!}" type="text" name="slides[{!! $slide->id !!}][{!! $code !!}][button_url]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.button_url.label') !!}"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="uniform-uploader"><input type="file" class="form-control-uniform" multiple><span class="filename" style="user-select: none;">{!! trans('common/form.fields.image_id.label') !!}</span><span class="action btn btn-primary legitRipple" style="user-select: none;">{!! trans('common/form.fields.image_id.label') !!}</span></div>
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
    <div id="preview-img-tpl" class="d-none">
				<div class="file-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb m-0 mb-2" id="preview-image-${image.id}" data-id="${image.id}">
<!--
					<div class="kv-file-content text-center" style="height: 8rem">
					    <img src="${image.url}" class="file-preview-image kv-preview-data" title="${image.original}" alt="${image.original}" style="width:auto;height:auto;max-width:100%;max-height:100%;">
					</div>
					<div class="row w-100 field d-none" data-name="slides.${id}.image_id" id="image-id" value="${image.id}">
					    <div class="col-lg-4">
					        <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.position.label') !!} <span class="text-danger">*</span></label>
					    </div>
					    <div class="col-lg-8 field-body">
					        <input type="text" name="slides[${id}][image_id]" value="${image.id}" class="form-control" placeholder="{!! trans('app/sliders.form.fields.position.label') !!}"/>
					    </div>
					</div>

					<div class="file-thumbnail-footer">
						<div class="file-thumb-progress kv-hidden">
							<div class="progress">
								<div class="progress-bar bg-success progress-bar-success progress-bar-striped active" style="width:0%;">{!! trans('admin/file.initializing') !!}</div>
							</div>
						</div>
					<div class="file-actions">
						<div class="file-footer-buttons">
							<button type="button" class="kv-file-remove" title="{!! trans('admin/file.remove-image') !!}"><i class="icon-bin"></i></button>
						</div>
					</div>
					<div class="file-footer-caption" title="${image.original}">
						<div class="file-caption-info">${image.original}</div>
							<div class="file-size-info"> <samp>(${image.size} MB)</samp></div>
						</div>
					</div>
-->
				</div>
    </div>
    <div id="preview-slide-tpl" class="d-none">
<!--
        <div class="w-100">
            <div class="slide-preview-frame krajee-default file-preview-initial file-sortable kv-preview-thumb m-0 mb-2" id="preview-${id}" data-id="${id}">
				<div class="file-thumbnail-header">
					<div class="file-actions">
						<div class="file-footer-buttons">
							<button type="button" class="kv-slide-remove" title="{!! trans('admin/file.remove-slide') !!}"><i class="icon-bin"></i></button>
						</div>
					</div>
				</div>
				preview_img_tpl
				<div class="clearfix"></div>

                <div class="position-slide row w-100 field d-none" data-name="slides.${id}.position" id="position-slide-${id}">
                    <div class="col-lg-4">
                        <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.position.label') !!} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-8 field-body">
                        <input type="text" name="slides[${id}][position]" value="${position}" class="form-control" placeholder="{!! trans('app/sliders.form.fields.position.label') !!}"/>
                    </div>
                </div>
                <div class="tabs p-2">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        @foreach($localizations as $code => $localization)
                            <li class="nav-item">
                                <a href="#slider-${id}-{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!}" data-toggle="tab">
                                    <img src="{!! asset('admin/images/lang/' . $code . '.png') !!}" width="30rem" class="mr-1">
                                    {!! $localization !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($localizations as $code => $localization)
                            <div class="tab-pane px-2 data {!! $app->getLocale() === $code ? 'active' : ''!!}" id="slider-${id}-{!! $code !!}">
                                <div class="row w-100 field" data-name="slides.${id}.{!! $code !!}.upper_title" id="upper_title">
                                    <div class="col-lg-4">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.upper_title.label') !!} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8 field-body">
                                        <input type="text" name="slides[${id}][{!! $code !!}][upper_title]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.upper_title.label') !!}"/>
                                    </div>
                                </div>
                                <div class="row w-100 field" data-name="slides.${id}.{!! $code !!}.title" id="title">
                                    <div class="col-lg-4">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.title.label') !!} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8 field-body">
                                        <input type="text" name="slides[${id}][{!! $code !!}][title]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.title.label') !!}"/>
                                    </div>
                                </div>
                                <div class="row w-100 field" data-name="slides.${id}.{!! $code !!}.description" id="description">
                                    <div class="col-lg-4">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.description.label') !!} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8 field-body">
                                        <input type="text" name="slides[${id}][{!! $code !!}][description]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.description.label') !!}"/>
                                    </div>
                                </div>
                                <div class="row w-100 field" data-name="slides.${id}.{!! $code !!}.button_text" id="button-text">
                                    <div class="col-lg-4">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.button_text.label') !!} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8 field-body">
                                        <input type="text" name="slides[${id}][{!! $code !!}][button_text]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.button_text.label') !!}"/>
                                    </div>
                                </div>
                                <div class="row w-100 field" data-name="slides.${id}.{!! $code !!}.button_url" id="button-url">
                                    <div class="col-lg-4">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/sliders.form.fields.button_url.label') !!} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8 field-body">
                                        <input type="text" name="slides[${id}][{!! $code !!}][button_url]" class="form-control" placeholder="{!! trans('app/sliders.form.fields.button_url.label') !!}"/>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
-->
    </div>
@endsection