@extends($theme . '::' . $_env->s_utype . '.master')

@section('title')
{{ mb_strtoupper(trans('user/form.text.' . request()->segment(1))) }}
@endsection

@include('public.partials._profile', ['s_id' => '#signin-form, #signup-form'])

@section('content')

	  <div class="container">
		<div id="profile_wrap">
			<div class="profile">
				<ul class="tabs">
					<li data-tab="tab-signin" {!! request()->segment(1) == 'signin' ? ' class="active"' : '' !!}>{!! trans('user/form.text.signin') !!}</li>
					<li data-tab="tab-signup" {!! request()->segment(1) == 'signup' ? ' class="active"' : '' !!}>{!! trans('user/form.text.signup') !!}</li>
					<div class="divider"></div>
				</ul>
				<div class="content">

@include($theme . '::' . $_env->s_utype . '._signin')
@include($theme . '::' . $_env->s_utype . '._signup')


				</div>
			</div>
			<div class="infoblocks"></div>

		</div>
	  </div>

@append