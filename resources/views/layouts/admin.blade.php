@include($theme . '::layouts._header')

	<!-- Global stylesheets -->
	<link rel="stylesheet" href="{{ asset($theme . '/css/tabs.css?v=' . $version->css) }}">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
{{--
	<link rel="stylesheet" href="{{ asset('css/sweet_alert.css?v=' . $version->css) }}">
--}}
	<link rel="stylesheet" href="{{ asset('icons/icomoon/styles.css') }}">
	<link rel="stylesheet" href="{{ asset('icons/fontawesome/css/all.min.css?v=5.13.0') }}">
	<link href="{!! asset('/css/noty.css?v=' . $version->css) !!}" rel="stylesheet" type="text/css">
	<link href="{!! asset('/css/override.css?v=' . $version->css) !!}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	@yield('css')
	@yield('css-checkbox')
    @yield('css-file')
	@yield('css-image')
	@yield('css-input')
	@yield('css-select')

@section('script')
<script type="text/javascript">
@include('common.var2js')
@include('user.var2js')
</script>
@append

</head>
<body>

<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-light navbar-static">

	<!-- Header with logos -->
	<div class="navbar-header navbar-dark d-none d-md-flex align-items-md-center">
		<div class="navbar-brand navbar-brand-md">
			<a href="{!! route('guest.welcome.index') !!}" class="d-inline-block" target="_blank">
				<span style="font-size: .8rem; color: #ff6a5f; font-weight: bold; font-family: Tahoma; letter-spacing: .1rem">@include($theme . '::layouts._setting', ['slug' => 'title'])</span>
				{{--<img src="/img/logo.png" alt="">--}}
			</a>
		</div>

		{{--<div class="navbar-brand navbar-brand-xs">
			<a href="index.html" class="d-inline-block">
				<img src="/admin/images/logo_icon_light.png" alt="">
			</a>
		</div>--}}
	</div>
	<!-- /header with logos -->

	<!-- Mobile controls -->
	<div class="d-flex flex-1 d-md-none">
		<div class="navbar-brand mr-auto">
			<a href="index.html" class="d-inline-block">
				<img src="/admin/images/logo_dark.png" alt="">
			</a>
		</div>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
			<i class="icon-tree5"></i>
		</button>

		<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
			<i class="icon-paragraph-justify3"></i>
		</button>
	</div>
	<!-- /mobile controls -->

	<!-- Navbar content -->
	<div class="collapse navbar-collapse navbar-dark" id="navbar-mobile">

		<ul class="navbar-nav ml-md-auto">
			<li class="nav-item dropdown">
				<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
					<img src="/images/flags/{!! $app->getLocale() !!}.png" class="img-flag mr-2" alt=""> {!! $localizations[$app->getLocale()] !!}
				</a>

				<div class="dropdown-menu dropdown-menu-right">
					@foreach($localizations as $code => $lang)
						<a href="{{ route('change-lang', $code) }}" class="dropdown-item {!! $code === $app->getLocale() ? 'active' : '' !!}">
							<img src="/images/flags/{!! $code !!}.png" class="img-flag" alt=""> {!! $lang !!}
						</a>
					@endforeach
				</div>
			</li>
			{{--
			<li class="nav-item dropdown">
				<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
					<i class="icon-bell2"></i>
					<span class="d-md-none ml-2">Messages</span>
					<span class="badge badge-mark border-pink-400 ml-auto ml-md-0"></span>
				</a>

				<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
					<div class="dropdown-content-header">
						<span class="font-weight-semibold">Messages</span>
						<a href="#" class="text-default"><i class="icon-compose"></i></a>
					</div>

					<div class="dropdown-content-body dropdown-scrollable">
						<ul class="media-list">
							<li class="media">
								<div class="mr-3 position-relative">
									<img src="/admin/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
								</div>

								<div class="media-body">
									<div class="media-title">
										<a href="#">
											<span class="font-weight-semibold">James Alexander</span>
											<span class="text-muted float-right font-size-sm">04:58</span>
										</a>
									</div>

									<span class="text-muted">who knows, maybe that would be the best thing for me...</span>
								</div>
							</li>

							<li class="media">
								<div class="mr-3 position-relative">
									<img src="/admin/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
								</div>

								<div class="media-body">
									<div class="media-title">
										<a href="#">
											<span class="font-weight-semibold">Margo Baker</span>
											<span class="text-muted float-right font-size-sm">12:16</span>
										</a>
									</div>

									<span class="text-muted">That was something he was unable to do because...</span>
								</div>
							</li>

							<li class="media">
								<div class="mr-3">
									<img src="/admin/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
								</div>
								<div class="media-body">
									<div class="media-title">
										<a href="#">
											<span class="font-weight-semibold">Jeremy Victorino</span>
											<span class="text-muted float-right font-size-sm">22:48</span>
										</a>
									</div>

									<span class="text-muted">But that would be extremely strained and suspicious...</span>
								</div>
							</li>

							<li class="media">
								<div class="mr-3">
									<img src="/admin/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
								</div>
								<div class="media-body">
									<div class="media-title">
										<a href="#">
											<span class="font-weight-semibold">Beatrix Diaz</span>
											<span class="text-muted float-right font-size-sm">Tue</span>
										</a>
									</div>

									<span class="text-muted">What a strenuous career it is that I've chosen...</span>
								</div>
							</li>

							<li class="media">
								<div class="mr-3">
									<img src="/admin/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
								</div>
								<div class="media-body">
									<div class="media-title">
										<a href="#">
											<span class="font-weight-semibold">Richard Vango</span>
											<span class="text-muted float-right font-size-sm">Mon</span>
										</a>
									</div>

									<span class="text-muted">Other travelling salesmen live a life of luxury...</span>
								</div>
							</li>
						</ul>
					</div>

					<div class="dropdown-content-footer bg-light">
						<a href="#" class="text-grey mr-auto">All messages</a>
						<div>
							<a href="#" class="text-grey" data-popup="tooltip" title="Mark all as read"><i class="icon-radio-unchecked"></i></a>
							<a href="#" class="text-grey ml-2" data-popup="tooltip" title="Settings"><i class="icon-cog3"></i></a>
						</div>
					</div>
				</div>
			</li>
			--}}

			<li class="nav-item dropdown dropdown-user">
				<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
					<img src="/admin/images/placeholders/placeholder.jpg" class="rounded-circle" alt="">
					<span>{!! Auth::user()->first_name !!}</span>
				</a>

				<div class="dropdown-menu dropdown-menu-right">
					<a href="{!! route('guest.personal.profile') !!}" class="dropdown-item">
						<i class="icon-user-plus"></i>
						{!! trans('general.user-profile') !!}
					</a>
					{{--
					<a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
					<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-indigo-400 ml-auto">58</span></a>
					--}}
					<div class="dropdown-divider"></div>
					{{--
					<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
					--}}

					@include($theme . '::guest._signout', ['class' => 'dropdown-item'])
					{{-- include($theme . '::' . $_env->s_utype . '._signout', ['class' => 'dropdown-item']) --}}

				</div>
			</li>
		</ul>
	</div>
	<!-- /navbar content -->

</div>
<!-- /main navbar -->

<!-- Page content -->
<div class="page-content">

	<!-- Main sidebar -->
	<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

		<!-- Sidebar mobile toggler -->
		<div class="sidebar-mobile-toggler text-center">
			<a href="#" class="sidebar-mobile-main-toggle">
				<i class="icon-arrow-left8"></i>
			</a>
			Navigation
			<a href="#" class="sidebar-mobile-expand">
				<i class="icon-screen-full"></i>
				<i class="icon-screen-normal"></i>
			</a>
		</div>
		<!-- /sidebar mobile toggler -->

		@include('admin.common.menu')

	</div>
	<!-- /main sidebar -->

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="mb-3 border-top-1 border-top-primary">
				<div class="page-header page-header-light" style="margin-bottom: 0;">
					<div class="page-header-content header-elements-md-inline">
						<div class="page-title py-3">
							<h5><span class="font-weight-semibold">@yield('title-icon')@yield('title')</span></h5>
						</div>
					</div>
					@yield('breadcrumbs')
				</div>
			</div>
		</div>
		<!-- /page header -->

		<!-- Content area -->
		<div class="content pt-0">@yield('content')</div>
		<!-- /content area -->

		<!-- Footer -->
		<div class="navbar navbar-expand-lg navbar-light">
			<div class="text-center d-lg-none w-100">
				<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
					<i class="icon-unfold mr-2"></i>
					Footer
				</button>
			</div>

			<div class="navbar-collapse collapse" id="navbar-footer">
				<div class="navbar-text main">
					<a href="https://www.linkedin.com/in/maximax/" target="_blank">maximax</a> at efte.in
					<br />Version: {{ $version->app }}
					<br />@php echo date("H:i:s m/d/Y") @endphp
				</div>
				<div class="navbar-text sub">
					<i><u>Other Versions</u></i>
					<br />
					<div class="version ver-name">anonym</div>
					<div class="version ver-id">{{ $version->anonym }}</div>
					<br />
					<div class="version ver-name">person</div>
					<div class="version ver-id">{{ $version->person }}</div>
					<br />
					<div class="version ver-name">api</div>
					<div class="version ver-id">{{ $version->api }}</div>
					<br />
					<div class="version ver-name">css</div>
					<div class="version ver-id">{{ $version->css }}</div>
					<br />
					<div class="version ver-name">js</div>
					<div class="version ver-id">{{ $version->js }}</div>
				</div>
			</div>
		</div>
		<!-- /footer -->

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->
{{--<script src="/admin/js/manifest.js"></script>--}}
{{--<script src="/admin/js/vendor.js"></script>--}}
<script src="{!! asset('/admin/js/main/jquery.min.js') !!}"></script>
<script src="{!! asset('/admin/js/main/bootstrap.bundle.min.js') !!}"></script>
<script src="{!! asset('/admin/js/plugins/loaders/blockui.min.js') !!}"></script>
<script src="{!! asset('/admin/js/plugins/ui/ripple.min.js') !!}"></script>

<script src="{{ asset('/admin/js/plugins/notifications/noty.min.js') }}"></script>
{{--<script src="{{ asset('/admin/js/plugins/notifications/sweetalert1.min.js') }}"></script>--}}
{{--
https://sweetalert.js.org/guides/
https://sweetalert.js.org/docs/#buttons
<script src="{{ asset('/admin/js/plugins/notifications/sweetalert2.min.js') }}"></script>
--}}
<script src="{{ asset('/admin/js/plugins/notifications/sweetalert2html.js') }}"></script>

<script src="{{ asset('/admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/pickers/color/spectrum.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/forms/styling/switchery.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/forms/styling/switch.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>

<script src="{!! asset('/js/common.js?v=' . $version->js) !!}"></script>
<script src="{!! asset('/admin/js/app.js?v=' . $version->js) !!}"></script>
<script src="{!! asset('/admin/js/common.js?v=' . $version->js) !!}"></script>
<script src="{!! asset('/admin/js/session.js?v=' . $version->js) !!}"></script>

@yield('js')
@yield('js-checkbox')
@yield('js-file')
@yield('js-image')
@yield('js-input')
@yield('js-select')

@yield('script')
@yield('script-checkbox')
@yield('script-file')
@yield('script-image')
@yield('script-input')
@yield('script-select')

<div id="div_tmpl_wrapper" class="d-none">
@yield('tmpl')
</div>

</body>
</html>
