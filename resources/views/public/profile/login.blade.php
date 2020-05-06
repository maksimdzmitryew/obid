@extends('layouts.public')

@section('meta')
	<title>{!! mb_strtoupper(trans('general.my-area') . ' | ' . trans('app.name')) !!}</title>
@endsection

@include('public.partials._profile', ['s_id' => '#register-form, #sign-in-form'])

@section('content')

<div class="content sign-in-page">
    <div class="container-fluid">
        <div class="single-form-block-wrap">
            <div class="single-form-block">
                <div class="title-box">
                    <h1 class="title-block">
                    	{!! trans('general.my-area') !!}
                    </h1>
                    <ul class="nav nav-tabs" id="pressTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="sign-tab" data-toggle="tab" href="#sign-text-tab"
                               role="tab"
                               aria-controls="sign-text-tab" aria-selected="true">{!! trans('user/form.text.signin') !!}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab" data-toggle="tab" href="#register-text-tab" role="tab"
                               aria-controls="register-text-tab" aria-selected="false">{!! trans('user/form.text.signup') !!}</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content section-tab" id="pressTabContent">
                    <div class="result-text-title">
                        {{ trans('user/form.text.hint_in') }}
                    </div>
                    <div class="tab-pane fade show active" id="sign-text-tab" role="tabpanel"
                         aria-labelledby="sign-tab">
                        <div class="single-content form-page-wrap">
                            <div class="inner">
                                <form action="{!! route('signin') !!}" method="POST" class="form-page" id="sign-in-form">
                                    @csrf
                                    <div class="form-group row field" data-field="email">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="sign_email">{!! trans('user/form.field.email') !!}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="text" class="form-control" id="sign_email"
                                                   placeholder="" name="email" value="{{ $email }}">
                                        </div>
                                    </div>

                                    <div class="form-group row field" data-field="password">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="sign_pass">{!! trans('user/form.field.password') !!}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="password" class="form-control" id="sign_pass"
                                                   placeholder="" name="password">
                                        </div>
                                    </div>

                                    <div class="form-group row field" data-field="email">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="sign_email">{!! trans('user/form.field.safety_options') !!}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                        	@for ($i = 0; $i < 3; $i++)
											<div class="check-inner offset-md-0 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap" style="margin-left: 10px;">
												<input type="radio" class="form-check-input" name="login_safety" value=" {!! $i !!}"  {!! $i == $safety ? 'checked="checked"' : '' !!}>
												<label class="form-check-label">{{ trans('user/form.button.remember-' . $i) }}</label>
											</div>
											@endfor
                                        </div>
                                    </div>

                                    <input type="hidden" id="recap_response_signin" placeholder="" name="g-recaptcha-response">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.google.recaptcha.key') }}"></div>

                                    <div class="btn-wrap row form-group" style="margin-top: 26px;">
                                        <div class="btn-inner offset-md-3 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap">
                                            <button type="submit" class="btn btn-primary">
                                                {!! trans('user/form.button.signin') !!}
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="offset-md-3 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap">
                                    <a href="{!! route('password_reset') !!}">{!! trans('user/form.button.forgot') !!}</a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="register-text-tab" role="tabpanel" aria-labelledby="register-tab">
                        <div class="single-content form-page-wrap">
                            <div class="inner">
                                <form action="{!! route('register') !!}" method="POST" class="form-page" id="register-form">
                                    @csrf
{{--
                                    <div class="form-group row field" data-field="first_name">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="register_first_name">{!! trans('user/form.field.name') !!}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="text" class="form-control" id="register_first_name" placeholder="" name="first_name">
                                        </div>
                                    </div>

                                    <div class="form-group row field" data-field="last_name">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="register_last_name">{!! trans('user/form.field.last') !!}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="text" class="form-control" id="register_last_name" placeholder="" name="last_name">
                                        </div>
                                    </div>
--}}
                                    <div class="form-group row field" data-field="email">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="email">{!! trans('user/form.field.email') !!}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="email" class="form-control"  placeholder="" name="email">
                                        </div>
                                    </div>

                                    <div class="form-group row field" data-field="password">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="password">{!! trans('user/form.field.password') !!}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="password" class="form-control" id="password" placeholder="" name="password">
                                        </div>
                                    </div>

                                    <div class="form-group row field" data-field="password_confirmation">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="password_confirmation">{!! trans('user/form.field.password_confirmation') !!}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="password" class="form-control" id="password_confirmation" placeholder="" name="password_confirmation">
                                        </div>
                                    </div>
{{--
                                    <div class="form-group row field" data-field="register_country">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="register_country">{{ trans('general.country') }}</label>
                                        </div>

                                        <div class="col-md-9 col-sm-8 col-12 control-wrap">
                                            <div class="jq-selectbox jqselect full-width" id="register_country-styler" style="z-index: 10;">
                                                <select name="profile_country" id="register_country" class="full-width">
                                                    @foreach($countries as $country)
                                                        <option value="{!! $country->id !!}">{!! $country->name !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
--}}
                                    <input type="hidden" id="recap_response_signup" placeholder="" name="g-recaptcha-response">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.google.recaptcha.key') }}"></div>

                                    <div class="btn-wrap row form-group">
                                        <div class="btn-inner offset-md-3 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap">
                                            <button type="submit" class="btn btn-primary">
                                                {!! trans('user/form.button.signup') !!}
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

@endsection
