@extends($theme . '::' . $_env->s_utype . '.master')

@section('title')
{{ mb_strtoupper(trans('user/form.text.' . request()->segment(1))) }}
@endsection

@include('public.partials._profile', ['s_id' => '#password-reset-form, #password-change-form'])

@section('content')

	  <div class="container">
		<div id="profile_wrap">
			<div class="profile">
				<ul class="tabs">
					<li data-tab="tab-reset" {!! request()->segment(1) == 'reset' ? ' class="active"' : '' !!}>{!! trans('user/form.text.reset') !!}</li>
					<li data-tab="tab-change" {!! request()->segment(1) == 'change' ? ' class="active"' : '' !!}>{!! trans('user/form.text.change') !!}</li>
					<div class="divider"></div>
				</ul>
				<div class="content">

@include($theme . '::' . $_env->s_utype . '._reset')
@include($theme . '::' . $_env->s_utype . '._change')

				</div>
			</div>
			<div class="infoblocks"></div>

		</div>
	  </div>

@append