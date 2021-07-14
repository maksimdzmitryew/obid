@include($theme . '::layouts._social_networks')
			<nav>
				<ul>
{{--
					<li><a href="#">Про нас</a></li>
					<li><a href="#">Волонтерам</a></li>
					<li><a href="#">Новости</a></li>
					<li><a href="#">Контакты</a></li>
'public.cabinet'
'guest.personal.profile'
--}}
					@if(Auth::user())
					@if(isset($b_admin) && $b_admin)
					<li><a class="violet" href="{!! route('admin.home') !!}">{{ trans('general.admin-panel') }}</a></li>
					@endif
					<li><a class="blue"  href="{!! route('guest.personal.activity') !!}">{!! trans('personal::guest.text.activity') !!}</a></li>
					<li><a class="blue"  href="{!! route('guest.personal.profile') !!}">{!! trans('general.my-area', ['app_name' => trans('app.name')]) !!}</a></li>
					<li>
					@include($theme . '::guest._signout', ['class' => 'green nav-link'])
					</li>
					@else
					<li><a class="blue"  href="{!! route('signup_page') !!}">{{ trans('general.signup') }}</a></li>
					<li><a class="green" href="{!! route('signin_page') !!}">{{ trans('general.signin') }}</a></li>
					@endif
				</ul>
@include($theme . '::layouts._lang')
			</nav>
			<button class="open_menu"><span></span><span></span><span></span></button>
