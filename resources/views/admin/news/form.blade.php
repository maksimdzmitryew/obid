@extends('layouts.admin')

@section('title-icon')<i class="fa fa-newspaper-o mr-2"></i>@endsection

@section('title'){!! $news->id ? trans('app/news.form.title.edit') : trans('app/news.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.news') !!}" class="breadcrumb-item">{!! trans('app/news.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $news->id ? trans('app/news.form.title.edit') : trans('app/news.form.title.create') !!}</span>
            </div>
            <a href="{!! $news->id ? route('admin.news.form', $news->id) : route('admin.news.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('/admin/css/form/form.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/css/common/waddon.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admin/js/plugins/ui/moment/moment_locales.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{!! asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/forms/selects/select2.min.js') !!}"></script>
    <script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>

    <script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/tags/tagsinput.min.js') }}"></script>

    <script src="{{ asset('/admin/js/forms.js') }}"></script>
    <script src="{{ asset('/admin/js/forms_datetime.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            function formatRepo (repo, field) {
                if (repo.loading) return repo.text;

                var markup =
                    '<div class="select2-result-repository clearfix">' +
                        '<div class="select2-result-repository__meta">' +
                            '<div class="select2-result-repository__title">' + repo[field] + '</div>' +
                        '</div>' +
                    '</div>';

                return markup;
            }

            // Format selection
            function formatRepoSelection (repo, field) {
                return repo[field] || repo.text;
            }

            function settings(params){
                return {
                    ajax: {
                        url: params.url,
                        dataType: 'json',
                        delay: 200,
                        data: function (settings) {
                            let filters = {};

                            if(params.filters){
                                for(let p in params.filters){
                                    console.log(p, params.filters[p]);
                                }
                            }

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
                    templateResult: function(repo){
                        return formatRepo(repo, params.filter);
                    },
                    templateSelection: function(repo){
                        return formatRepoSelection(repo, params.filter);
                    }

                }
            }

            $('#festival-id').select2(settings({
                url: '{!! route('api.festivals.index') !!}',
                filter: 'name',
            }));

            $('#event-id').select2(settings({
                url: '{!! route('api.events.index') !!}',
                filter: 'title'
            }));

            $('#category-id').multiselect();



            $('form').on('submit', function(e){
                e.preventDefault();

                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                let data = {},
                    form = $(this);

                // console.log(form.serializeArray());

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
                            window.location.href = '{!! route('admin.news') !!}';
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
                <form class="form-validate-jquery" action="{!! $news->id ? route('api.news.update', $news->id) : route('api.posts.store') !!}" method="post">
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
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/news.form.legends.main') !!}</legend>
                            <div class="px-2">
                                <div class="form-group row field" data-name="published">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.published.label') !!}</label>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input name="published" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $news->published ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="published_at">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.published_at.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.published_at.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="hidden" name="published_at" id="published_at" value="{!! $news->getOriginal('published_at', now()) !!}">
                                        <input type="text" class="form-control datepicker" placeholder="{!! trans('app/news.form.fields.published_at.label') !!}" autocomplete="off" data-date-from="{!! $news->getOriginal('published_at', now()) !!}" data-date-to="{!! $news->getOriginal('published_at', now()) !!}">
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="promoting">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.promoting.label') !!}</label>
                                    </div>
                                    <div class="field-body form-check-switch form-check-switch-left">
                                        <input name="promoting" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $news->promoting ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>

                                @include('modules.image.admin_form', ['item' => $news])
	                            @include('modules.image.admin_gallery', ['item' => $news])

                                @if( ! empty($categories))
                                    <div class="form-group row field" data-name="category_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.category.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.category.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="category_id" id="category-id" data-placement="{!! trans('app/news.form.fields.category.label') !!}">
                                                @foreach($categories as $category)
                                                    <option value="{!! $category->id !!}" {!! $news->category && $news->category->id === $category->id ? 'selected="selected"' : '' !!}>{!! $category->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row field" data-name="festival_id">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.festival.label') !!} <span class="text-danger">*</span></label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.festival.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <select name="festival_id" id="festival-id" data-placeholder="{!! trans('app/news.form.fields.festival.label') !!}">
                                            @if($news->festival)
                                                <option value="{!! $news->festival->id !!}">{!! $news->festival->name !!}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="event_id">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.event.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.event.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <select name="event_id" id="event-id" data-placeholder="{!! trans('app/news.form.fields.event.label') !!}">
                                            @if($news->event)
                                                <option value="{!! $news->event->id !!}">{!! $news->event->title !!}</option>
                                            @endif
                                        </select>
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
                                            <div class="form-group row field" data-name="{!! $code !!}.title">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.title.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[title]" class="form-control" placeholder="{!! trans('app/news.form.fields.title.label') !!}" autocomplete="off" value="{{ $news->id ? $news->translate($code)->title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.slug">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.slug.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.slug.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[slug]" class="form-control" placeholder="{!! trans('app/news.form.fields.slug.label') !!}" autocomplete="off" value="{{ $news->id ? $news->translate($code)->slug : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.excerpt">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.excerpt.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.excerpt.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[excerpt]" class="form-control" placeholder="{!! trans('app/news.form.fields.excerpt.label') !!}" autocomplete="off" value="{{ $news->id ? $news->translate($code)->excerpt : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.body">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.body.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.body.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control ckeditor" rows="3" cols="3" name="{!! $code !!}[body]" placeholder="{!! trans('app/news.form.fields.body.label') !!}">{{ $news->id ? $news->translate($code)->body : '' }}</textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane px-2" id="seo">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/news.form.legends.seo') !!}</legend>
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
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.meta_title.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.meta_title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_title]" class="form-control" placeholder="{!! trans('app/news.form.fields.meta_title.label') !!}" autocomplete="off" value="{{ $news->id ? $news->translate($code)->meta_title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_keywords">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.meta_keywords.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.meta_keywords.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_keywords]" class="form-control" placeholder="{!! trans('app/news.form.fields.meta_keywords.label') !!}" autocomplete="off" value="{{ $news->id ? $news->translate($code)->meta_keywords : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/news.form.fields.meta_description.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/news.form.fields.meta_description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" rows="3" cols="3" name="{!! $code !!}[meta_description]" placeholder="{!! trans('app/news.form.fields.meta_description.label') !!}"></textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
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
@endsection
