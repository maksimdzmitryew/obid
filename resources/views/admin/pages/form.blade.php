@extends('layouts.admin')

@php
    $s_tmp              = request()->route()->getAction()['as'];
    $a_tmp              = explode('.', $s_tmp);
    $s_category         = mb_strtolower($a_tmp[1]);

    $s_cat_sgl_low      = mb_strtolower(trans('app/' . $s_category . '.names.sgl'));
    $s_cat_sgl_up       = mb_strtoupper($s_cat_sgl_low);
    $s_cat_sgl_u1       = ucfirst($s_cat_sgl_low);

    $s_cat_plr_low      = mb_strtolower(trans('app/' . $s_category . '.names.plr'));
    $s_cat_plr_up       = mb_strtoupper($s_cat_plr_low);
    $s_cat_plr_u1       = ucfirst($s_cat_plr_low);

    $s_list_route       = route('admin.' . $s_category);
    $s_list_name        = $s_cat_plr_u1 . ' ' . trans('common/form.breadcrumbs.list');
    $s_page_action      = ($page->id
                                ? trans('common/form.actions.edit')
                                : trans('common/form.actions.create')
                            )
                            . ' ' . $s_cat_sgl_low;
    $s_page_route       = ($page->id
                                ? route('admin.' . $s_category . '.form', $page->id)
                                : route('admin.' . $s_category . '.form')
                            );
    $s_form_route       = ($page->id
                                ? route('api.' . $s_category . '.update', $page->id)
                                : route('api.' . $s_category . '.store')
                            );

    $s_btn_primary		= trans("common/form.actions.view") . ' ' . trans("common/form.breadcrumbs.list");

    $s_btn_secondary	= ($page->id
                                ? trans("common/form.actions.continue") . ' ' . trans('common/form.actions.edit')
                                : trans("common/form.actions.create_more")
                            );
@endphp

@section('title-icon')<i class="{!! trans('app/' . $s_category . '.names.ico') !!} mr-2"></i>@endsection

@section('title'){!! $s_page_action !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! $s_list_route !!}" class="breadcrumb-item">{!! $s_list_name !!}</a>
                <span class="breadcrumb-item active">{!! $s_page_action !!}</span>
            </div>
            <a href="{!! $s_page_route !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('script')
    <script>
		s_page_route	= '{!! $s_page_route !!}';
		s_text_list		= '{!! $s_btn_primary !!}';
		s_text_continue	= '{!! $s_btn_secondary !!}';
		s_list_route	= '{!! $s_list_route !!}';


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
                        confirmButtonText: s_text_list,
                        confirmButtonClass: 'btn btn-primary',
                        cancelButtonText: s_text_continue,
                        cancelButtonClass: 'btn btn-light',
                    }).then((confirm) => {
                        if(confirm.value){
                            window.location.href = s_list_route;
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
                <form class="form-validate-jquery" action="{!! $s_form_route !!}" method="post">
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
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/pages.form.legends.main') !!}</legend>
                            <div class="px-2">
                                <div class="form-group row field" data-name="published">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.published.label') !!}</label>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input name="published" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $page->published ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>

                                <div class="form-group row field" data-name="slug">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/pages.form.fields.slug.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/pages.form.fields.slug.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="slug" class="form-control" placeholder="{!! trans('app/pages.form.fields.slug.label') !!}" autocomplete="off" value="{{ $page->id ? $page->slug : '' }}">
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
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/pages.form.fields.name.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/pages.form.fields.name.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[name]" class="form-control" placeholder="{!! trans('app/pages.form.fields.name.label') !!}" autocomplete="off" value="{{ $page->id ? $page->translate($code)->name : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.excerpt">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/pages.form.fields.excerpt.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/pages.form.fields.excerpt.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[excerpt]" class="form-control" placeholder="{!! trans('app/pages.form.fields.excerpt.label') !!}" autocomplete="off" value="{{ $page->id ? $page->translate($code)->excerpt : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.body">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/pages.form.fields.body.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/pages.form.fields.body.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control ckeditor" rows="3" cols="3" name="{!! $code !!}[body]">{{ $page->id ? $page->translate($code)->body : '' }}</textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane px-2" id="seo">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/pages.form.legends.seo') !!}</legend>
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
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/pages.form.fields.meta_title.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/pages.form.fields.meta_title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_title]" class="form-control" placeholder="{!! trans('app/pages.form.fields.meta_title.label') !!}" autocomplete="off" value="{{ $page->id ? $page->translate($code)->meta_title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_keywords">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/pages.form.fields.meta_keywords.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/pages.form.fields.meta_keywords.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_keywords]" class="form-control" placeholder="{!! trans('app/pages.form.fields.meta_keywords.label') !!}" autocomplete="off" value="{{ $page->id ? $page->translate($code)->meta_keywords : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/pages.form.fields.meta_description.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/pages.form.fields.meta_description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" rows="3" cols="3" name="{!! $code !!}[meta_description]" placeholder="{!! trans('app/pages.form.fields.meta_description.label') !!}"></textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-styled ml-2">{!! trans('app/pages.form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
