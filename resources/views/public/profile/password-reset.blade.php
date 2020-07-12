{{--
@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper(trans('user/form.text.reset') . ' | ' . config('app.name')) !!}</title>
@endsection

@include('public.partials._profile', ['s_id' => '#password-reset-form'])

@section('content')

<div class="content sign-in-page">
    <div class="container-fluid">
        <div class="single-form-block-wrap">
            <div class="single-form-block">
                <div class="title-box">
                    <h1 class="w-100">
                    	{!! trans('user/form.text.reset') !!}
                    </h1>
                </div>

                <div class="tab-content section-tab" id="pressTabContent">
                    <div class="tab-pane fade show active" id="sign-text-tab" role="tabpanel" aria-labelledby="sign-tab">
                        <div class="single-content form-page-wrap">
                            <div class="inner">
                                <form action="{!! route('password_reset') !!}" method="POST" class="form-page" id="password-reset-form">
                                    @csrf
                                    <div class="form-group row field" data-field="email">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="sign_email">
                                            	{!! trans('user/form.field.email') !!}
                                        	</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="text" class="form-control" id="sign_email" placeholder="" name="email">
                                        </div>
                                    </div>

                                    <div class="btn-wrap row form-group">
                                        <div class="btn-inner offset-md-3 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap">
                                            <button type="submit" class="btn btn-primary">
                                                {!! trans('user/form.button.reset') !!}
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
--}}