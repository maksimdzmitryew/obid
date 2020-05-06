@extends('layouts.admin')

@section('title-icon')<i class="icon-calendar mr-2"></i>@endsection

@section('title'){!! $event->id ? trans('app/events.form.title.edit') : trans('app/events.form.title.create') !!}@endsection

@section('breadcrumbs')
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
				@include('admin.common._breadcrumb_home')
                <a href="{!! route('admin.events') !!}" class="breadcrumb-item">{!! trans('app/events.list.title') !!}</a>
                <span class="breadcrumb-item active">{!! $event->id ? trans('app/events.form.title.edit') : trans('app/events.form.title.create') !!}</span>
            </div>
            <a href="{!! $event->id ? route('admin.events.form', $event->id) : route('admin.events.form') !!}" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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
    <script src="{{ asset('/admin/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/templates/jquery.tmpl.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/ui/sortable.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/forms/tags/tagsinput.min.js') }}"></script>
    <script src="{{ asset('/admin/js/forms.js') }}"></script>
    <script src="{{ asset('/admin/js/forms_datetime.js') }}"></script>
    <script src="{{ asset('/admin/js/forms_sortable.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            let s_form = 'form';
            let s_link = @if ($event->id) "{!! route('public.festival.event', [':festival_slug', ':event_slug']) !!}"
            				.replace(':event_slug', '{{ $event->slug }}')
            				.replace(':festival_slug', '{{ $event->festival->slug }}')
        					@else
        					''
        					@endif
    					;

        				;
			let locales = [];
			let o_preview = {};
			let b_open = false;

            @foreach($localizations as $code => $localization)
            	locales.push('{!! $code !!}');
            @endforeach

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

                            filters[params.filter] = settings.term;

                            return {
                                filters: filters,
                                vocation_id: params.vocation_id
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

            $( ".artists" ).each(function() {
                $( this ).select2(settings({
                    url: '{!! route('api.artists.index') !!}',
                    filter: 'name',
                    multiple: true,
                    vocation_id: $(this).attr('data-vocation'),
                }));
            });
            // $('.artists').select2(settings({
            //     url: '{!! route('api.artists.index') !!}',
            //     filter: 'name',
            //     multiple: true,
            // }));

            $('.sortable-target .select2-selection__rendered').sortable({
                containment: 'parent',
                tolerance: 'pointer',
                items: '.select2-selection__choice:not(.select2-search--inline)'
            }).disableSelection();

            $('#holdings .places').select2(settings({
                url: '{!! route('api.places.index') !!}',
                filter: 'name'
            }));

            $('#festival-id').select2(settings({
                url: '{!! route('api.festivals.index') !!}',
                filter: 'name'
            }));



            $(document).on('click', '#add-holding', (e) => {
                let holding = $.tmpl($('#holding-tpl').html(), {
                    id: Math.random().toString(36).substring(2),
                    date_from: moment().format('YYYY-MM-DD HH:mm:ss'),
                    date_to: moment().add(1, 'hours').format('YYYY-MM-DD HH:mm:ss'),
                }).appendTo('#holdings');

                holding.find('.places').select2(settings({
                    url: '{!! route('api.places.index') !!}',
                    filter: 'name'
                }));
                $('#holdings .sw').bootstrapSwitch();

                //console.log(holding);

                holding.find('.daterange-single').daterangepicker({
                    autoApply: true,
                    startDate: moment(),
                    endDate: moment().add(1, 'hours'),
                    //singleDatePicker: true,
                    timePicker: true,
                    locale: {
                        format: 'LLL'
                    },
                }).on('apply.daterangepicker', (e, picker) => {
                    picker.element.closest('.field').find('#holdings-date-from').val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                    picker.element.closest('.field').find('#holdings-date-to').val(picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
                });
            });

            $(document).on('click', '.delete-holding', (e) => {
                $(e.currentTarget).closest('.holding').remove();
            });

            $(document).on('click', '#add-vocation', (e) => {
                let id = Math.random().toString(36).substring(2);
                let vocation = $.tmpl($('#vocation-tpl').html(), {
                    id: id,
                }).appendTo('#vocations');
                vocation.attr('data-id',id);

                vocation.find('.vocation-select').multiselect();

                vocation.find('.artists-area').sortable({
                    containment: 'parent',
                    tolerance: 'pointer',
                }).disableSelection();
            });

            $(document).on('click', '.delete-vocation', (e) => {
                $(e.currentTarget).closest('.vocation').remove();
            });

            $(document).on('change', '.vocation-select', (e) => {
                element = $(e.currentTarget);
                element.closest('.vocation').attr('data-vocation-id',element.val())
                element.closest('.vocation').find('.artists-area').empty();
            });

            $(document).on('click', '.append-artist', (e) => {
                let vocation = $.tmpl($('#artist-tpl').html(), {
                    id: Math.random().toString(36).substring(2),
                    parrent_id: $(e.currentTarget).closest('.vocation').attr('data-id')
                }).appendTo($(e.currentTarget).closest('.vocation').find('.artists-area'));

                vocation.find('.new-artist').select2(settings({
                    url: '{!! route('api.artists.index') !!}',
                    filter: 'name',
                    multiple: true,
                    vocation_id: $(e.currentTarget).closest('.vocation').attr('data-vocation-id'),
                }));
            });

            $(document).on('click', '.remove-artist', (e) => {
                $(e.currentTarget).closest('.artist').remove();
            });

			$(".preview").click( () =>
			{
	        	$(s_form).submit();
			});

            $(s_form).on('submit', function(e){
                e.preventDefault();

                //$('input.image_copyright').prop('disabled', true);

                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                let data = {},
                    form = $(this);

                    // console.log(form.serializeArray());

                // clicked 'preview' button
            	if( typeof e.originalEvent == 'undefined')
            	{
            		res = $(this).find('.' + 'item-content').has('.' + 'mr-1');
            		lang_0_code = res[0].hash.replace('#', '');
            		lang_0_active = (res[0].className.indexOf('active') > -1);
            		lang_1_code = res[1].hash.replace('#', '');
            		lang_1_active = (res[1].className.indexOf('active') > -1);

            		if (lang_0_active) lang_code = lang_0_code;
            		if (lang_1_active) lang_code = lang_1_code;

            		o_preview = {
					    time: 'now',
					    body: $('textarea[name="'+lang_code+'[body]"]').val(),
					    element_id: '#event-text-tab',
					}

					if (typeof(Storage) !== "undefined") {
					    window.localStorage.setItem('preview', JSON.stringify(o_preview));
					    b_open = (typeof o_window_ref == 'undefined');
					    if (!b_open)
					    {
						    b_open = b_open || (o_window_ref.closed);
						    b_open = b_open || (typeof o_window_ref.window != 'object');
					    }
					    if (b_open)
					    {
					    	o_window_ref = window.open(s_link, '_blank');
						    notify('Preview has been opened in a separate tab', 'info', 3000);
					    }
					    else
					    {
						    notify('Preview already opened. Refresh that page', 'info', 3000);
					    }
				    } else {
					    notify('Apologies. This browser does not support preview', 'danger', 3000);
					}
	                return false;
            	}

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
                            window.location.href = '{!! route('admin.events') !!}';
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
                <form class="form-validate-jquery" action="{!! $event->id ? route('api.events.update', $event->id) : route('api.events.store') !!}" method="post">
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
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/events.form.legends.main') !!}</legend>
                            <div class="px-2">
                                <div class="form-group row field" data-name="published">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/festivals.form.fields.published.label') !!}</label>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input name="published" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $event->published ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>
                                @if($categories)
                                    <div class="form-group row field" data-name="category_id">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.category.label') !!} <span class="text-danger">*</span></label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.category.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="category_id" class="form-control multi-select" data-placeholder="{!! trans('app/events.form.fields.category.label') !!}">
                                                <option value="">{!! trans('common/form.fields.category.label') !!}</option>
                                                @foreach($categories as $category)
                                                    <option value="{!! $category->id !!}" {!! $event->category && $event->category->id === $category->id ? 'selected="selected"' : '' !!}>{!! $category->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row field" data-name="festival_id">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.festival.label') !!} <span class="text-danger">*</span></label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.festival.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <select name="festival_id" class="form-control" id="festival-id" data-placeholder="{!! trans('common/form.fields.festival.label') !!}">
                                            @if($event->festival)
                                                <option value="{!! $event->festival->id !!}">{!! $event->festival->name !!}</option>
                                            @else
                                                <option value="">{!! trans('common/form.fields.festival.label') !!}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                @include('modules.image.admin_form', ['item' => $event])

                                <div class="form-group row field" data-name="promoting_up">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.promoting_up.label') !!}</label>
                                    </div>
                                    <div class="field-body form-check-switch form-check-switch-left">
                                        <input name="promoting_up" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $event->promoting_up ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>
                                <div class="form-group row field" data-name="promoting">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.promoting.label') !!}</label>
                                    </div>
                                    <div class="field-body form-check-switch form-check-switch-left">
                                        <input name="promoting" value="1" type="checkbox" class="switcher" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" {!! $event->promoting ? 'checked=checked' : '' !!}>
                                    </div>
                                </div>

                                <div class="form-group row field" data-name="facebook">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.facebook.label') !!}</label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.facebook.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <input type="text" name="facebook" class="form-control" placeholder="{!! trans('app/events.form.fields.facebook.label') !!}" autocomplete="off" value="{{ $event->id ? $event->facebook : '' }}">
                                    </div>
                                </div>

                                @if($galleries->count())
                                    <div class="form-group row field" data-name="galleries">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.gallery.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.gallery.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select class="multi-select" name="gallery_id" id="gallery-id" data-placeholder="{!! trans('app/events.form.fields.gallery.label') !!}">
                                                <option value="">{!! trans('common/form.fields.gallery.label') !!}</option>
                                                @foreach($galleries as $gallery)
                                                    <option value="{{ $gallery->id }}"  {!! $event->gallery && $event->gallery->id === $gallery->id ? 'selected="selected"' : '' !!}>{{ $gallery->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row field" data-name="holdings">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.holdings.label') !!}  <span class="text-danger">*</span></label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.url.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <button type="button" id="add-holding" class="btn btn-primary tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.add_holding') !!}" data-trigger="hover"><i class="icon-plus3"></i></button>
                                        <div id="holdings">
                                            @if( ! empty($event->holdings))
                                                @foreach($event->holdings as $holding)
                                                    <div class="holding p-3 mt-2" id="holding" style="border: 1px solid silver">
                                                        <div class="buttons text-right">
                                                            <button type="button" class="btn btn-danger delete-holding tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.delete_holding') !!}" data-trigger="hover"><i class="icon-trash"></i></button>
                                                        </div>
                                                        <div class="field search-box-container" data-name="holdings.{!! $holding->id !!}.place_id">
                                                            <div class="field-body">
                                                                <select name="holdings[{!! $holding->id !!}][place_id]" class="places" data-placeholder="{!! trans('app/events.form.fields.holdings.place') !!}">
                                                                    <option value="{!! $holding->place->id !!}" selected="selected">{!! $holding->place->name !!}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="field search-box-container mt-2" data-name="holdings.{!! $holding->id !!}.date">
                                                            <input type="hidden" name="holdings[{!! $holding->id !!}][date_from]" id="holdings-date-from" value="{!! $holding->date_from !!}">
                                                            <input type="hidden" name="holdings[{!! $holding->id !!}][date_to]" id="holdings-date-to" value="{!! $holding->date_to !!}">
                                                            <div class="field-body">
                                                                <input data-date-from="{!! $holding->date_from !!}" data-date-to="{!! $holding->date_to !!}" type="text" class="form-control daterange-single" placeholder="{!! trans('app/events.form.fields.holdings.date') !!}">
                                                            </div>
                                                        </div>

                                                        <div class="field search-box-container mt-2" data-name="holdings.{!! $holding->id !!}.ticket_url">
                                                            <div class="field-body">
                                                                <input value="{!! $holding->ticket_url !!}" name="holdings[{!! $holding->id !!}][ticket_url]" type="text" class="form-control" placeholder="{!! trans('app/events.form.fields.holdings.ticket_url') !!}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row field" data-name="vocations">
                                    <div class="col-lg-3">
                                        <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.vocations.label') !!}  <span class="text-danger">*</span></label>
                                        <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.url.rules') !!}"><i class="icon-info3"></i></span>
                                    </div>
                                    <div class="col-lg-9 field-body">
                                        <button type="button" id="add-vocation" class="btn btn-primary tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.append_vocation') !!}" data-trigger="hover"><i class="icon-plus3"></i></button>
                                        <div id="vocations" class="sortable">
                                            @if( ! empty($event->vocations))
                                                @foreach($event->vocations()->orderBy('event_vocation.order', 'asc')->get() as $vocation)
                                                    <div class="vocation p-3 mt-2" id="vocation" data-id="{!! $vocation->id !!}" data-vocation-id="{!! $vocation->id !!}" style="border: 1px solid silver">
                                                        <div class="buttons text-right">
                                                            <button type="button" class="btn btn-primary append-artist tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.append_artist') !!}" data-trigger="hover"><i class="icon-plus3"></i></button>
                                                            <button type="button" class="btn btn-danger delete-vocation tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.delete_vocation') !!}" data-trigger="hover"><i class="icon-trash"></i></button>
                                                        </div>
                                                        @if($vocations)
                                                            <div class="form-group row field" data-name="vocations.{!! $vocation->id !!}.vocation_id">
                                                                <div class="col-lg-9 field-body">
                                                                    <select name="vocations[{!! $vocation->id !!}][vocation_id]" class="form-control multi-select vocation-select" data-placeholder="{!! trans('app/presses.form.fields.type.label') !!}">
                                                                        @foreach($vocations as $element)
                                                                            <option value="{!! $element->id !!}" {!! $vocation->id === $element->id ? 'selected="selected"' : '' !!}>{!! $element->name !!}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="artists-area sortable">
                                                            @if($event->eventVocations->where('vocation_id','=',$vocation->id)->first()->artists)
                                                                @foreach($event->eventVocations->where('vocation_id','=',$vocation->id)->first()->artists()->orderBy('artist_event_vocation.order', 'asc')->get() as $artist)
                                                                <div class="row artist mb-1">
                                                                    <div class="col-1 text-center d-flex align-items-center justify-content-center">
                                                                        <i class="icon-grid"></i>
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <div class="form-group row field" data-name="vocations.{!! $vocation->id !!}.artists.{!! $artist->id !!}.artist_id">
                                                                            <div class="field-body w-100">
                                                                                <select name="vocations[{!! $vocation->id !!}][artists][{!! $artist->id !!}][artist_id]" class="form-control artists artist-select" data-placeholder="{!! trans('app/events.form.fields.vocations.artist') !!}" data-vocation="{!! $vocation->id !!}">
                                                                                    <option value="{!! $artist->id !!}" selected="selected">{!! $artist->name !!}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn btn-danger remove-artist tooltip-helper ml-3" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.delete_artist') !!}" data-trigger="hover"><i class="icon-trash"></i></button>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{--@foreach(['directors', 'artists', 'executive_producers', 'producers'] as $role)
                                    <div class="form-group row field" data-name="artists.{!! $role !!}">
                                        <div class="col-lg-3">
                                            <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.roles.'.$role.'.label') !!}</label>
                                            <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.roles.'.$role.'.rules') !!}"><i class="icon-info3"></i></span>
                                        </div>
                                        <div class="col-lg-9 field-body">
                                            <select name="artists[{!! $role !!}][]" class="form-control artists" data-placeholder="{!! trans('app/events.form.fields.roles.'.$role.'.label') !!}" multiple>
                                                @if($event->{camel_case($role)})
                                                    @foreach($event->{camel_case($role)} as $artist)
                                                        <option value="{!! $artist->id !!}" selected="selected">{!! $artist->name !!}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">{!! trans('app/events.form.fields.roles.'.$role.'.label') !!}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                @endforeach--}}
                            </div>
                            <hr/>
                            <ul class="nav nav-tabs nav-tabs-highlight">
                                @foreach($localizations as $code => $localization)
                                    <li class="nav-item">
                                        <a href="#{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!} item-content" data-toggle="tab">
                                            <img src="{!! asset('admin/images/lang/' . $code . '.png') !!}" width="30rem" class="mr-1">{!! $localization !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($localizations as $code => $localization)
                                    <div class="tab-pane px-2 {!! $app->getLocale() === $code ? 'active' : ''!!}" id="{!! $code !!}">
                                        <fieldset class="mb-3">
                                            <div class="form-group row field" data-name="{!! $code !!}.slug">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.slug.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.slug.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[slug]" class="form-control" placeholder="{!! trans('common/form.fields.slug.label') !!}" autocomplete="off" value="{{ $event->id ? $event->translate($code)->slug : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.title">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.title.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[title]" class="form-control" placeholder="{!! trans('common/form.fields.title.label') !!}" autocomplete="off" value="{{ $event->id ? $event->translate($code)->title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('common/form.fields.description.label') !!} <span class="text-danger">*</span></label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('common/form.fields.description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" placeholder="{!! trans('common/form.fields.description.label') !!}" rows="3" cols="3" name="{!! $code !!}[description]">{{ $event->id ? $event->translate($code)->description : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.body">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.body.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.body.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="ckeditor" rows="3" cols="3" name="{!! $code !!}[body]">{{ $event->id ? $event->translate($code)->body : '' }}</textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane px-2" id="seo">
                            <legend class="text-uppercase font-size-sm font-weight-bold">{!! trans('app/events.form.legends.seo') !!}</legend>
                            <ul class="nav nav-tabs nav-tabs-highlight">
                                @foreach($localizations as $code => $localization)
                                    <li class="nav-item">
                                        <a href="#seo_{!! $code !!}" class="nav-link {!! $app->getLocale() === $code ? 'active' : ''!!}" data-toggle="tab">
                                            <img src="{!! asset('admin/images/lang/' . $code . '.png') !!}" width="30rem" class="mr-1">
                                            {!! $localization !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($localizations as $code => $localization)
                                    <div class="tab-pane px-2 {!! $app->getLocale() === $code ? 'active' : ''!!}" id="seo_{!! $code !!}">
                                        <fieldset class="mb-3">
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_title">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.meta_title.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.meta_title.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_title]" class="form-control" placeholder="{!! trans('app/events.form.fields.meta_title.label') !!}" autocomplete="off" value="{{ $event->id ? $event->translate($code)->meta_title : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_keywords">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.meta_keywords.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.meta_keywords.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <input type="text" name="{!! $code !!}[meta_keywords]" class="form-control" placeholder="{!! trans('app/events.form.fields.meta_keywords.label') !!}" autocomplete="off" value="{{ $event->id ? $event->translate($code)->meta_keywords : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row field" data-name="{!! $code !!}.meta_description">
                                                <div class="col-lg-3">
                                                    <label class="d-block float-left py-2 m-0">{!! trans('app/events.form.fields.meta_description.label') !!}</label>
                                                    <span class="badge badge-primary tooltip-helper d-block float-right my-2 px-1" data-toggle="tooltip" title="{!! trans('app/events.form.fields.meta_description.rules') !!}"><i class="icon-info3"></i></span>
                                                </div>
                                                <div class="col-lg-9 field-body">
                                                    <textarea class="form-control" rows="3" cols="3" name="{!! $code !!}[meta_description]" placeholder="{!! trans('app/events.form.fields.meta_description.label') !!}">{{ $event->id ? $event->translate($code)->meta_description : '' }}</textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        @if ($event->id)<button type="button" class="btn btn-styled secondary preview ml-2">{!! trans('common/form.preview') !!} <i class="icon-eye ml-2"></i></button>@endif
                        <button type="submit" class="btn btn-styled ml-2">{!! trans('common/form.submit') !!} <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="holding-tpl" class="d-none">
        <div class="holding p-3 mt-2" id="holding" style="border: 1px solid silver">
            <div class="buttons text-right">
                <button type="button" class="btn btn-danger delete-holding tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.delete_holding') !!}" data-trigger="hover"><i class="icon-trash"></i></button>
            </div>
            <div class="field search-box-container" data-name="holdings.${id}.place_id">
                <div class="field-body">
                    <select name="holdings[${id}][place_id]" class="places" data-placeholder="{!! trans('app/events.form.fields.holdings.place') !!}">
                        <option>{!! trans('app/events.form.fields.holdings.place') !!}</option>
                    </select>
                </div>
            </div>
            <div class="field search-box-container mt-2" data-name="holdings.${id}.date">
                <input type="hidden" name="holdings[${id}][date_from]" id="holdings-date-from" value="${date_from}">
                <input type="hidden" name="holdings[${id}][date_to]" id="holdings-date-to" value="${date_to}">
                <div class="field-body">
                    <input type="text" class="form-control daterange-single" placeholder="{!! trans('app/events.form.fields.holdings.date') !!}">
                </div>
            </div>
            <div class="field search-box-container mt-2" data-name="holdings.${id}.ticket_url">
                <div class="field-body">
                    <input name="holdings[${id}][ticket_url]" type="text" class="form-control" placeholder="{!! trans('app/events.form.fields.holdings.ticket_url') !!}">
                </div>
            </div>
        </div>
    </div>
    {{-- waddon --}}
    <div id="vocation-tpl" class="d-none">
        <div class="vocation p-3 mt-2" id="vocation" data-id="${id}" data-vocation-id="1" style="border: 1px solid silver">
            <div class="buttons text-right">
                <button type="button" class="btn btn-primary append-artist tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.append_artist') !!}" data-trigger="hover"><i class="icon-plus3"></i></button>
                <button type="button" class="btn btn-danger delete-vocation tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.delete_vocation') !!}" data-trigger="hover"><i class="icon-trash"></i></button>
            </div>
            @if($vocations)
                <div class="form-group row field" data-name="vocations.${id}.vocation_id">
                    <div class="col-lg-9 field-body">
                        <select name="vocations[${id}][vocation_id]" class="vocation-select" data-placeholder="{!! trans('app/presses.form.fields.type.label') !!}">
                            @foreach($vocations as $element)
                                <option value="{!! $element->id !!}">{!! $element->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="artists-area"></div>
            @endif
        </div>
    </div>
    <div id="artist-tpl" class="d-none">
        <div class="row artist mb-1">
            <div class="col-1 text-center d-flex align-items-center justify-content-center">
                <i class="icon-grid"></i>
            </div>
            <div class="col-8">
                <div class="form-group row field" data-name="vocations.${parrent_id}.artists.${id}.artist_id">
                    <div class="field-body w-100">
                        <select name="vocations[${parrent_id}][artists][${id}][artist_id]" class="form-control new-artist artist-select" data-placeholder="{!! trans('app/events.form.fields.vocations.artist') !!}" data-vocation="1">
                            <option value="">{!! trans('app/events.form.fields.vocations.artist') !!}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-danger remove-artist tooltip-helper ml-3" data-toggle="tooltip" data-placement="top" title="{!! trans('app/events.form.delete_artist') !!}" data-trigger="hover"><i class="icon-trash"></i></button>
            </div>
        </div>
    </div>
@endsection
