@extends('layouts.public')

@section('meta')
	<title>{!! mb_strtoupper(trans('general.my-area') . ' | ' . trans('app.name')) !!}</title>
	<meta name="title" content="{!! trans('meta.cabinet') !!}">
	<meta name="description" content="{!! trans('meta.cabinet') !!}">
	<meta name="keywords" content="{!! trans('meta.cabinet') !!}">
@endsection

@section('css')
	<link rel="stylesheet" href="{!! asset('/admin/js/plugins/pickers/air-datepicker/datepicker.min.css') !!}">
@endsection

@section('js')
	<script src="{{ asset('/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/datepicker.min.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/i18n/datepicker.en.js') }}"></script>
	<script src="{{ asset('/admin/js/plugins/pickers/air-datepicker/i18n/datepicker.de.js') }}"></script>
	<script src="{!! asset('/admin/js/plugins/templates/jquery.tmpl.js') !!}"></script>
	<script src="{!! asset('/user/js/filter_category.js') !!}"></script>
	{{--<script src="{{ mix('/admin/js/app.js') }}"></script>--}}
@append

@section('script')

<!-- http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm -->
@if (Cookie::get( config('cookie-consent.cookie_name') ) !== null)
<script async defer src="https://apis.google.com/js/api.js" id="gapi"></script>
@endif

<script>
	$(document).ready(() => {

		$(document).on('click', '.bookmark',  (e) => {
			let target = $(e.currentTarget),
				favorite = '{{--{!! route('public.event.favorite', ':event') !!}--}}',
				unfavorite = '{{--{!! route('public.event.unfavorite', ':event') !!}--}}';

			$.ajax({
				type: 'post',
				url: $(target).hasClass('added') ? unfavorite.replace(':event', target.data('event-id')) : favorite.replace(':event', target.data('event-id')),
				success: (data) => {
					//console.log(data);
				}
			});

			//window.location.href = $(target).hasClass('added') ? unfavorite.replace(':event', target.data('event-id')) : favorite.replace(':event', target.data('event-id'));
		});

		let input = $('input.date-range'),
			date_start = '{{-- !! $dates->first() ?? null !! --}}',
			date_end = '{{-- !! $dates->last() ?? null !! --}}';

		let picker = input.datepicker({
			dateFormat: 'yyyy-mm-dd',
			prevHtml: '<svg width="27" height="19" viewBox="0 0 27 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
			'<path d="M0.654556 8.77965L8.33761 0.881904C8.80637 0.400042 9.56661 0.400042 10.0354 0.881904C10.5042 1.36386 10.5042 2.14515 10.0354 2.62711L4.40168 8.41823H24.9206C25.5836 8.41823 26.1211 8.97077 26.1211 9.65225C26.1211 10.3336 25.5836 10.8863 24.9206 10.8863H4.40168L10.0352 16.6774C10.504 17.1594 10.504 17.9406 10.0352 18.4226C9.80085 18.6634 9.49352 18.784 9.1863 18.784C8.87907 18.784 8.57185 18.6634 8.33742 18.4226L0.654556 10.5249C0.185698 10.0429 0.185698 9.26161 0.654556 8.77965Z" fill="#0E293C"/>\n' +
			'</svg>',
			nextHtml: '<svg width="26" height="19" viewBox="0 0 26 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
			'<path d="M25.4665 10.525L17.7835 18.4228C17.3147 18.9046 16.5545 18.9046 16.0857 18.4228C15.6169 17.9408 15.6169 17.1595 16.0857 16.6776L21.7194 10.8865L1.20048 10.8865C0.537526 10.8865 0 10.3339 0 9.65244C0 8.97106 0.537526 8.41841 1.20048 8.41841L21.7194 8.41841L16.0859 2.62729C15.6171 2.14533 15.6171 1.36405 16.0859 0.882086C16.3202 0.641304 16.6276 0.520666 16.9348 0.520666C17.242 0.520666 17.5492 0.641304 17.7837 0.882086L25.4665 8.77983C25.9354 9.26179 25.9354 10.0431 25.4665 10.525Z" fill="#0E293C"/>\n' +
			'</svg>',
			inline: true,
			language: '{!! app()->getLocale() !!}',
			range: true,
			onSelect: function(formattedDate, date, inst){

				$('#holdings-from, #holdings-to').val('').prop('disabled', true);

				if(date[0])
					$('#holdings-from').val(moment(date[0]).format('YYYY-MM-DD HH:mm:ss')).prop('disabled', false);

				if(date[1])
					$('#holdings-to').val(moment(date[1]).format('YYYY-MM-DD HH:mm:ss')).prop('disabled', false);;
			}
		});

		// TODO: refactoring copy-paste code
		if(0 && date_start && date_end){
			picker.data('datepicker').selectDate([
				new Date(date_start),
				new Date(date_end)
			]);
		}

		picker.data('date-from', date_start).data('date-to', date_end);

		$('#filters-form').on('submit', (e) => {
			e.preventDefault();

			$.ajax({
				url: '{{--{!! route('public.cabinet.favorite-events') !!}--}}',
				type: 'get',
				data: $(e.target).serialize(),
				success: viewEntries
			});
		});

		$('#filter-reset-btn').on('click', (e) => {
			$('#filter-category .tab').each((i, checkbox) => {
				toggleCheckbox($(checkbox), true);
			});

			$('.filter-city #city-id').prop('disabled', true).attr('disabled', 'disabled').val($('.filter-city #cities option').first().prop('selected', 'selected'));
			$('.filter-city #cities').trigger('refresh');

			picker.data('datepicker').clear();

			// TODO: refactoring copy-paste code
			if(0 && date_start && date_end){
				picker.data('datepicker').selectDate([
					new Date(date_start),
					new Date(date_end)
				]);
			}

			$('#holdings-from').val(picker.data('date-from'));
			$('#holdings-to').val(picker.data('date-to'));

			$('#filters-form').submit();
		});

		$(document).on('click', '.pagination .page-item a', (e) => {
			let elem = $(e.currentTarget);

			e.preventDefault();

			$('#filters-form').find('#offset').val((elem.data('page') - 1) * elem.data('limit'));
			$('#filters-form').submit();
		});

		$(document).on('click', '.pagination .page-item.prev-page-item', (e) => {
			let elem = $(e.currentTarget);

			if(elem.hasClass('disabled')) return;

			$('#filters-form').find('#offset').val((elem.data('current') - 2) * elem.data('limit'));
			$('#filters-form').submit();
			//viewEntries();
		});

		$(document).on('click', '.pagination .page-item.next-page-item', (e) => {
			let elem = $(e.currentTarget);

			if(elem.hasClass('disabled')) return;

			$('#filters-form').find('#offset').val((elem.data('current')) * elem.data('limit'));
			$('#filters-form').submit();
			//viewEntries();
		});

		function viewPagination(total, start, limit){

			let container = $('.pagination'),
				pages = Math.ceil(total / limit),
				current = start / limit + 1,
				arrow_left = $('#arrow-left').tmpl({
					total: total,
					limit: limit,
					current: current
				}),
				arrow_right = $('#arrow-right').tmpl({
					total: total,
					limit: limit,
					current: current
				});

			container.empty();

			if(pages < 2) return;

			container.append(arrow_left.toggleClass('disabled', current <= 1));

			for(let page = (current - 2) < 1 ? 1 : (current - 2); page <= pages && (current + 2) >= page; page++){

				container.append($(page === current ? '#active-page' : '#page').tmpl({
					total: total,
					start: start,
					limit: limit,
					page: page,
					current: current
				}));

			}

			container.append(arrow_right.toggleClass('disabled', current >= pages));
		}

		function viewEntries(data){
			let program_line_tpl = $('#program-line-tpl')
									.html()
									// TODO refactoring
									// 1) we need to hide the template's src="${img}" by commenting it output
									// 2) otherwise there will be 404 not found error in browser logs:
									// when the page first load into a browser
									// e.g. GET /poland/$%7Bimage%7D HTTP/1.1 404
									.replace('<!--', '')
									.replace('-->', '')
									,
				route = "{{-- route('public.event', ':slug') --}}";

			$('#results').empty();

			$.each(data.data, (date, events) => {

				if( ! events.length) return;

				$.tmpl(program_line_tpl, {
					date: moment(date).format('D MMMM YYYY'),
					events: events.map(event => {
						return {
							id: event.id,
							is_favorite: event.is_favorited,
							title: event.title,
							description: event.description,
							image: event.image.url ? event.image : {
								name: 'no image',
								url: '/admin/images/no-image-logo.jpg'
							},
							category: event.category,
							route: route.replace(':slug', event.slug),
							directors: event.directors.map(el => el.name).join(', '),
							holdings: event.holdings.map(holding => {
								return {
									city: holding.city.name + ', ' + holding.place.name,
									date: moment(holding.date_from).format('HH:mm'),
									time: moment(holding.date_from).format('DD/MM'),
								}
							})
						}
					})
				}).appendTo('#results');
			});

			viewPagination(data.total, $('#filters-form').find('#offset').val(), $('#filters-form').find('#amount').val());
		}

		$(window).trigger('resize');


	});
/*
	var CLIENT_ID = '843531194676-u2qn0mf0tc1sslkr7lerua6hvkfpaodk.apps.googleusercontent.com';
	var API_KEY = 'AIzaSyDTvOc0S22s4MfsC_MvsrSyy1olgcbY_7g';

	var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];

	var SCOPES = "https://www.googleapis.com/auth/calendar";


	function handleClientLoad() {
		gapi.load('client:auth2', initClient);
	}
*/

	function generateId(length = 26){
		let str = '',
			chars = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','0','1','2','3','4','5','6','7','8','9'];

		for(let i = 0; i < length; i++){
			str = str.concat(chars[ Math.floor(Math.random() * chars.length) ]);
		}

		return str;
	}

	function initClient() {
		gapi.client.init({
			apiKey: API_KEY,
			clientId: CLIENT_ID,
			discoveryDocs: DISCOVERY_DOCS,
			scope: SCOPES
		}).then(function () {

			$('#sync-btn').on('click', (e) => {

				let is_auth = gapi.auth2.getAuthInstance().isSignedIn.get();

				if( ! is_auth){
					gapi.auth2.getAuthInstance().signIn();
				}else{

					gapi.client.calendar.events.list({
						'calendarId': 'primary',
						'timeMin': (new Date()).toISOString(),
						'showDeleted': false,
						'singleEvents': true,
						'maxResults': 10,
						'orderBy': 'startTime'
					}).then(function(response) {
						var events = response.result.items,
							event_ids = events.map(event => Number(event.id.substr(10)));

						$('#results .event-item').each((i, item) => {

							let event = $(item),
								holding = event.find('.holding').first();

							if(event_ids.indexOf(Number(holding.data('id'))) === -1){

								addEvent({
									'id': generateId(10).concat(holding.data('id')),
									'title': event.data('title'),
									'description': event.data('description'),
									'city': holding.data('city'),
									'date_from':moment(holding.data('dateFrom')).format(),
									'date_to': moment(holding.data('dateTo')).format(),
									'timezone': holding.data('timezone'),
								});

							}

							swal({
								title: 'Success',
								text: 'Events has been synchronized!',
								type: 'success',
								confirmButtonText: 'Ok',
								confirmButtonClass: 'btn btn-primary',
							});
						});
					});
				}
			});

		}, function(error) {
			console.log(error);
			//appendPre(JSON.stringify(error, null, 2));
		});
	}

	function addEvent(event){

		gapi.client.calendar.events.insert({
			'calendarId': 'primary',
			'resource': {
				'id': event.id,
				'summary': event.title,
				'location': event.city,
				'description': event.description,
				'start': {
					'dateTime': event.date_from,
					'timeZone': event.timezone
				},
				'end': {
					'dateTime': event.date_to,
					'timeZone': event.timezone
				},
			}
		}).then(function(response) {

		});
	}

//	document.getElementById('gapi').addEventListener('load', handleClientLoad);
</script>
@append

@section('content')
<div class="content miy-pr-page" id="test">
	<div class="container-fluid">
		<div class="title-box">
			<h1 class="title-block">{{ trans('general.my-area') }}</h1>
			<ul class="nav nav-tabs" id="pressTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link" id="bookmarks-tab" data-toggle="tab" href="#bookmarks-text-tab" role="tab" aria-controls="bookmarks-text-tab" aria-selected="false">{{ trans('general.bookmarks') }}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile-text-tab" role="tab" aria-controls="profile-text-tab" aria-selected="true">{{ trans('general.user-profile') }}</a>
				</li>
				@if($b_admin)
				<li class="nav-item">
					<a class="nav-link" href="{!! route('admin.home') !!}" aria-controls="profile-text-tab" aria-selected="false">{{ trans('general.admin-panel') }}</a>
				</li>
				@endif
				<li class="nav-item">

					@include($theme . '::' . $_env->s_utype . '._signout', ['class' => 'nav-link'])

				</li>
			</ul>
		</div>

		<div class="tab-content section-tab" id="pressTabContent">
			<div class="tab-pane fade" id="bookmarks-text-tab" role="tabpanel" aria-labelledby="bookmarks-tab">
				<div class="filter-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-9 col-sm-7 col-12 vertical-event">
								<div id="results">
									<div class="program-line">
										{{--
										@foreach($event_dates as $date => $events)
											<div class="program-line">
												<div class="block-title">{{ $date }}</div>
												<div class="events" id="events">
													@foreach($events as $event)
														@include('public.partials.event')
													@endforeach
												</div>
											</div>
										@endforeach
										--}}
									</div>
								</div>
							</div>

							<aside class="right-sidebar col-lg-3 col-sm-5 col-12">
								<form action="#" id="filters-form">
									<input type="hidden" name="offset" id="offset" value="0">
									<input type="hidden" name="amount" id="amount" value="20">
									{{--<input type="hidden" name="filters[festivals][]" value="{!! $festival->id !!}">--}}
									<div class="sidebar-inner filter-wrap">
										<div class="sidebar-item">
											{{--
											<a href="#" class="btn btn-primary cal-synk-btn" id="sync-btn">
												<svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
													<rect width="24" height="23" fill="black" fill-opacity="0"/>
													<path d="M2.51917 0.715723V3.50259H2.37817C1.06688 3.50259 0 4.58597 0 5.91783V6.04552L0.0187407 6.17173L0.845896 11.7326V11.7481V20.5848C0.845896 21.9166 1.91266 23 3.22407 23H20.7759C22.0872 23 23.1541 21.9165 23.1541 20.5848V11.7481V11.7326L23.9813 6.17173L24 6.04552V5.91783C24 4.58597 22.9331 3.50259 21.6218 3.50259H21.4808V0.715723C21.4808 0.320529 21.1652 0 20.7759 0H3.22407C2.83486 0 2.51917 0.320529 2.51917 0.715723ZM4.19245 1.69952H19.8074V3.50259H4.19245V1.69952ZM21.6218 5.2021C22.0111 5.2021 22.3267 5.52263 22.3267 5.91783L21.4807 11.6049V11.7481V16.2891V20.5848C21.4807 20.98 21.1651 21.3005 20.7758 21.3005H3.22407C2.83475 21.3005 2.51917 20.98 2.51917 20.5848V16.2891V11.7481V11.6049L1.67327 5.91783C1.67327 5.52263 1.98897 5.2021 2.37817 5.2021H21.6218ZM6.20127 15.3682L6.20216 15.3346L6.27545 15.1113H7.78575V15.3379C7.78575 15.7064 7.91292 16.0079 8.1745 16.2598C8.43944 16.5148 8.77633 16.6388 9.20435 16.6388C9.62256 16.6388 9.93936 16.5143 10.1731 16.2581C10.4112 15.9969 10.527 15.6601 10.527 15.2285C10.527 14.7347 10.4193 14.3669 10.2065 14.1356C9.99793 13.9088 9.65055 13.7937 9.17434 13.7937H7.98063V12.4094H9.17434C9.62969 12.4094 9.94795 12.3028 10.1203 12.0925C10.3027 11.8698 10.3952 11.5428 10.3952 11.1207C10.3952 10.728 10.2968 10.4237 10.0943 10.1903C9.8992 9.96562 9.60805 9.8564 9.20424 9.8564C8.80432 9.8564 8.48506 9.9765 8.22827 10.2234C7.97471 10.4669 7.85156 10.7643 7.85156 11.1328V11.3595H6.36424L6.26262 11.1531L6.26117 11.1034C6.23908 10.3715 6.51395 9.73925 7.07795 9.22395C7.63314 8.71693 8.34852 8.45996 9.20435 8.45996C10.0678 8.45996 10.7588 8.68906 11.2581 9.14113C11.7649 9.60011 12.0218 10.2743 12.0218 11.1452C12.0218 11.6008 11.9022 12.0225 11.6663 12.3988C11.5049 12.6561 11.2981 12.8762 11.0486 13.0562C11.3486 13.2395 11.5916 13.4764 11.7736 13.7642C12.0257 14.1629 12.1536 14.6473 12.1536 15.2042C12.1536 16.079 11.8736 16.7776 11.3215 17.2806C10.7763 17.7774 10.064 18.0293 9.20424 18.0293C8.41401 18.0293 7.70788 17.7891 7.1055 17.3153C6.48349 16.8266 6.17918 16.1715 6.20127 15.3682ZM15.4582 10.1505L13.5589 10.1688V8.81108L17.0907 8.43492V17.9015H15.4582V10.1505Z" fill="black"/>
												</svg>
												<span class="text">{ { -- !! trans('general.google-calendar-sync') !! -- } }</span>
											</a>
											--}}
										</div>
										<div class="sidebar-item filter-category" id="filter-category">
{{--
											<h5 class="sidebar-title">{{ trans('general.category') }}</h5>
											<div class="sidebar-item-content">
												<div class="row">
													@foreach($events_categories as $event_category)
														<div class="col-6 tab">
															<input type="hidden" name="filters[categories][]" value="{!! $event_category->id !!}" disabled="disabled">
															<div class="filter-label">
																{{ $event_category->name }}
															</div>
														</div>
													@endforeach
												</div>
											</div>
--}}
										</div>
										<div class="sidebar-item filter-city" id="filter-city">
											<h5 class="sidebar-title">{{ trans('general.my-city') }}</h5>
											<div class="sidebar-item-content">
												<input type="hidden" name="filters[cities][]" id="city-id" disabled="disabled">
												<select class="full-width" id="cities">
													<option value="">{{ trans('general.select-city') }}</option>
													@foreach($cities as $city)
														<option value="{!! $city->id !!}">{{ $city->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										{{--
										<div class="sidebar-item filter-calendar" id="filter-calendar">
											<h5 class="sidebar-title">{{ trans('general.calendar') }}</h5>
											<div class="sidebar-item-content">
												<input type="hidden" id="holdings-from" name="filters[holdings][from]">
												<input type="hidden" id="holdings-to" name="filters[holdings][to]">
												<input type="text" class="form-control date-range d-none" placeholder="Date">
											</div>
										</div>
										<div class="sidebar-item filter-reset">
											<button class="btn btn-primary full-width" id="filter-apply-btn">{{ trans('general.filter') }}</button>
											<button type="button" class="btn btn-secondary full-width mt-2" id="filter-reset-btn">
												{{ trans('general.reset-filters') }}
											</button>
										</div>
										--}}
									</div>
								</form>
							</aside>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade show active" id="profile-text-tab" role="tabpanel" aria-labelledby="profile-tab">
				<div class="single-event-wrap profile-page-wrap">
					<div class="row">
						<div class="col-lg-9 col-md-8 col-12 single-content form-page-wrap">
							<div class="inner">
								<form action="{{-- route('public.profile.update') --}}" method="POST" class="form-page" id="profile-form">
									@csrf
									<div class="form-group row">
										<div class="col-md-3 col-sm-4 col-12 label-wrap">
											<label for="profile_first_name">{!! trans('user/form.field.first_name') !!}</label>
										</div>
										<div class="col-md-9 col-sm-8 col-12 control-wrap">
											<input type="text" class="form-control" id="profile_first_name" placeholder="{!! trans('user/form.field.first_name') !!}" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}">
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-3 col-sm-4 col-12 label-wrap">
											<label for="profile_last_name">{!! trans('user/form.field.last_name') !!}</label>
										</div>
										<div class="col-md-9 col-sm-8 col-12 control-wrap">
											<input type="text" class="form-control" id="profile_last_name" placeholder="{!! trans('user/form.field.last_name') !!}" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-3 col-sm-4 col-12 label-wrap">
											<label for="profile_email">{!! trans('user/form.field.email') !!}</label>
										</div>
										<div class="col-md-9 col-sm-8 col-12 control-wrap">
											<input type="email" class="form-control" id="profile_email" name="email" placeholder="{!! trans('user/form.field.email') !!}" value="{{ old('email') ? old('email') : $user->email }}">
										</div>
									</div>
									{{-- <div class="form-group row">
										<div class="col-md-3 col-sm-4 col-12 label-wrap">
											<label for="profile_country">Country</label>
										</div>
										<div class="col-md-9 col-sm-8 col-12 control-wrap">
											<select name="profile_country" id="profile_country" class="full-width">
												<option selected>France</option>
												<option value="1">One</option>
												<option value="2">Two</option>
												<option value="3">Three</option>
											</select>
										</div>
									</div> --}}
									<div class="form-group row">
										<div class="col-md-3 col-sm-4 col-12 label-wrap">
											<label for="profile_old_pass">{!! trans('user/form.field.password_old') !!}</label>
										</div>
										<div class="col-md-9 col-sm-8 col-12 control-wrap">
											<input type="password" class="form-control" id="profile_old_pass" name="old_password">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-3 col-sm-4 col-12 label-wrap">
											<label for="profile_new_pass">{!! trans('user/form.field.password_new') !!}</label>
										</div>
										<div class="col-md-9 col-sm-8 col-12 control-wrap">
											<input type="password" class="form-control" id="profile_new_pass" name="password">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-3 col-sm-4 col-12 label-wrap">
											<label for="profile_again_pass">{!! trans('user/form.field.repeat') !!}</label>
										</div>
										<div class="col-md-9 col-sm-8 col-12 control-wrap">
											<input type="password" class="form-control" id="profile_again_pass" name="password_confirmation">
										</div>
									</div>

									<div class="form-group form-check row">
										<div class="check-inner offset-md-3 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap">
											<input type="checkbox" class="form-check-input" id="check_subscribe" name="subscribe"{{-- old('subscribe') ? old('subscribe') == true ? 'checked' : '' : $subscribe == true ? 'checked' : '' --}}>
											<label class="form-check-label" for="check_subscribe">{{ trans('general.want-recieve-updates') }}</label>
										</div>
									</div>
									<div class="btn-wrap row">
										<div class="btn-inner offset-md-3 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap">
											<button type="submit" class="btn btn-primary">
												{{ trans('general.save-changes') }}
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{--
<div id="program-line-tpl" class="d-none">
	<div class="program-line">
		<div class="block-title">${date}</div>
		<div class="events">
			{%each(i, event) events %}
			<div class="event-item">
				<div class="row d-flex align-items-center">
					<div class="col-lg-4 col-12">
						<div class="img-wrap">
							<div class="bookmark {%if is_favorite %}added{%/if%}" data-event-id="${event.id}">
								<svg class="mark_icon" width="25" height="37" viewBox="0 0 25 37" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 0V34.2246C1 35.0039 1.85185 35.4837 2.51829 35.0799L12.0077 29.3289C12.339 29.1281 12.7563 29.1367 13.079 29.3509L21.5433 34.9692C22.208 35.4104 23.0963 34.9338 23.0963 34.136V0" stroke="white" stroke-width="2"/>
								</svg>
								<span class="mark-plus">+</span>
							</div>
							<a href="${event.route}"><img src="${event.image.url}" alt="${event.image.name}"></a>
						</div>
					</div>
					<div class="col-lg-8 col-12">
						<div class="descr">
							<h5 class="event-title"><a href="${event.route}">${event.title}</a></h5>
							<div class="short small-text">${event.description}</div>
							<div class="box">
								<a href="#" class="label">${event.category.name}</a>
								<div class="name">${event.directors}</div>
							</div>
						</div>
					</div>
				</div>
				<div class="sub-event sub-event-stoke">
					<div class="row flex-nowrap item-wrap">
						{%each(i, holding) event.holdings %}
						<div class="sub-event-item col-lg-2 col-sm-4 col-6">
							<div class="info-box">
								<div class="time">${holding.date}</div>
								<div class="date">${holding.time}</div>
								<div class="name">${holding.city}</div>
							</div>
						</div>
						{%/each%}
					</div>
				</div>
			</div>
			{%/each%}
		</div>
	</div>
</div>
--}}
<div id="arrow-left" class="d-none">
	<li class="page-item prev-page-item" data-current="${current}" data-total="${total}" data-limit="${limit}">
		<svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"></rect>
			<rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"></rect>
			<path d="M0.435841 9.94886L9.9585 0.435333C10.5395 -0.145111 11.4818 -0.145111 12.0628 0.435333C12.6439 1.0159 12.6439 1.95702 12.0628 2.53758L5.08016 9.5135L30.5121 9.5135C31.3338 9.5135 32 10.1791 32 11C32 11.8208 31.3338 12.4865 30.5121 12.4865L5.08016 12.4865L12.0625 19.4624C12.6437 20.0429 12.6437 20.9841 12.0625 21.5646C11.7721 21.8547 11.3912 22 11.0104 22C10.6296 22 10.2488 21.8547 9.95826 21.5646L0.435841 12.0511C-0.145279 11.4705 -0.145279 10.5294 0.435841 9.94886Z" fill="black"></path>
		</svg>
	</li>
</div>
<div id="arrow-right" class="d-none">
	<li class="page-item next-page-item" data-current="${current}" data-total="${total}" data-limit="${limit}">
		<a class="page-link" href="http://culture-scapes.loc/news?page=2">
			<svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
				<rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"></rect>
				<rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"></rect>
				<path d="M31.5642 12.0511L22.0415 21.5647C21.4605 22.1451 20.5182 22.1451 19.9372 21.5647C19.3561 20.9841 19.3561 20.043 19.9372 19.4624L26.9198 12.4865H1.48792C0.666229 12.4865 0 11.8209 0 11C0 10.1792 0.666229 9.51353 1.48792 9.51353H26.9198L19.9375 2.53761C19.3563 1.95705 19.3563 1.01592 19.9375 0.435362C20.2279 0.145319 20.6088 0 20.9896 0C21.3704 0 21.7512 0.145319 22.0417 0.435362L31.5642 9.94889C32.1453 10.5295 32.1453 11.4706 31.5642 12.0511Z" fill="black"></path>
			</svg>
		</a>
	</li>
</div>
<div id="page" class="d-none">
	<li class="page-item">
		<a class="page-link" href="#" data-page="${page}" data-total="${total}" data-start="${start}" data-limit="${limit}">${page}</a>
	</li>
</div>
<div id="active-page" class="d-none">
	<li class="page-item active">
		<span class="page-link">${page}</span>
	</li>
</div>

@endsection
