@extends($theme . '::' . $_env->s_utype . '.master')

@section('title')
{!! mb_strtoupper(trans('personal::guest.text.'.request()->segment(2)) . ' &#60; ' . trans('general.' . request()->segment(1))) !!}
@endsection

@include('public.partials._profile', ['s_id' => '#profile-form, #create-demand-form, #create-order-form'])

@section('content')

	  <div class="container">
		<div id="profile_wrap">
			<div class="profile">
				<ul class="tabs">
					<li data-tab="tab-activity" {!! request()->segment(2) == 'activity' ? ' class="active"' : '' !!}>{!! trans('personal::guest.text.activity') !!}</li>
					<li data-tab="tab-profile" {!! request()->segment(2) == 'profile' ? ' class="active"' : '' !!}>{!! trans('personal::guest.text.profile') !!}</li>
					<div class="divider"></div>
				</ul>
				<div class="content">

@include($_env->s_view . '._activity')
@include($_env->s_view . '._profile')


				</div>
			</div>
			<div class="infoblocks"></div>

		</div>
	  </div>

@append