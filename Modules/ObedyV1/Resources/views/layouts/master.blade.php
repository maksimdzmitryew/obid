@include($theme . '::layouts._header')

  <!-- Global stylesheets -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  {{--
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
  --}}
  {{--
  <link rel="stylesheet" href="{{ asset('css/jquery.formstyler.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.formstyler.theme.css') }}">
  --}}
  {{--
  <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.css') }}">
  --}}

{{--
  <link rel="stylesheet" href="{{ asset('css/sweet_alert.css?v=' . $version->css) }}">
--}}
  <link rel="stylesheet" href="{{ asset('icons/icomoon/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('icons/fontawesome/css/all.min.css?v=5.13.0') }}">
  <!-- /global stylesheets -->

  <link rel="stylesheet" href="{{ asset($theme . '/css/' . $_env->s_utype . '_app.css?v=' . $version->css) }}">
  <link rel="stylesheet" href="{{ asset($theme . '/css/tabs.css?v=' . $version->css) }}">
    <link href="{!! asset('/css/noty.css?v=' . $version->css) !!}" rel="stylesheet" type="text/css">

  @yield('css')

  <link href="{!! asset('/css/override.css?v=' . $version->css) !!}" rel="stylesheet" type="text/css">
  <link rel="shortcut icon" href="/{!! $theme !!}/img/icon.png" type="image/png">

  @section('script')
  <script type="text/javascript">
  @include('common.var2js')
  </script>
  @append
  @section('js')
  <!-- Notifications related JavaScript -->
  <script src="{!! asset('/admin/js/main/bootstrap.bundle.min.js') !!}"></script>
  <script src="{{ asset('/admin/js/plugins/forms/styling/switch.min.js') }}"></script>
  <script src="{{ asset('/admin/js/plugins/notifications/noty.min.js') }}"></script>
  <script src="{!! asset('/admin/js/common.js?v=' . $version->js) !!}"></script>
  {{--
  <script src="{{ asset('/js/app_public.js?v=' . $version->js) }}"></script>
  --}}
  <script src="{{ asset($theme . '/js/' . $_env->s_utype . '_app.js?v=' . $version->js) }}"></script>
  @append

</head>
<body>
@if (config('app.env') == 'production')
@include('public.partials._googe_tagmanager_body')
@endif
@include($theme . '::' . $_env->s_utype . '.header')

<section
  id="{{ request()->segment(1) == ''
    || request()->segment(1) == 'place'
    || request()->segment(1) == 'opinion'
    ? 'map_screen'
    : 'custom_page'
    }}"
  class="{{
        (
          request()->segment(1) == ''
          ? 'general_page'
          :   (
              request()->segment(1) == 'place' || request()->segment(1) == 'opinion'
              ? ''
              : request()->segment(1) . '_page'
            )
        )
      }}"
>
@yield('content')
</section>

@include($theme . '::' . $_env->s_utype . '.footer')

{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{!! asset('/admin/js/main/jquery.min.js') !!}"></script>
--}}

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
{{--<script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQueryFormStyler/2.0.2/jquery.formstyler.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="{!! asset('/js/common.js?v=' . $version->js) !!}"></script>

<!-- Optional JavaScript -->
<!-- http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm -->
@if (Cookie::get( config('cookie-consent.cookie_name') ) !== null)
@endif
{{--
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('js/jquery.formstyler.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/notifications/sweetalert1.min.js') }}"></script>
--}}
{{--
https://sweetalert.js.org/guides/
https://sweetalert.js.org/docs/#buttons
it allows for multiple action buttons being shown
<script src="{{ asset('/admin/js/plugins/notifications/sweetalert2.min.js') }}"></script>
--}}
{{--
version by another author
we used v.1 of it
it allows for 2 action buttons only
on the bright side, it allowed html formatting and text in "footer" under action buttons
https://sweetalert2.github.io/
--}}
<script src="{{ asset('/admin/js/plugins/notifications/sweetalert2html.js') }}"></script>

@yield('js')

@yield('script')

<div id="div_tmpl_wrapper" class="d-none">
@yield('tmpl')
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
