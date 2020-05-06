@extends('layouts.public')

@section('script')
    <script>

        $(document).ready(() => {

            $('#password-changes-form').on('submit', (e) => {

                e.preventDefault();

                let form = $(e.currentTarget);

                $.ajax({
                    'url': form.attr('action'),
                    'type': 'post',
                    'data': form.serialize(),
                }).done((data) => {
                    form.find('.error').remove();

                    swal({
                        title: 'Success',
                        text: data.message,
                        type: 'success',
                        confirmButtonText: 'Ok',
                        confirmButtonClass: 'btn btn-primary',
                    }).then(() => {
                        window.location.href = '{!! route('public.cabinet') !!}';
                    });

                }).fail((xhr) => {
                    let response = xhr.responseJSON;

                    if(response.errors.token)
                        window.location.href = '{!! route('signin_page') !!}';

                    form.find('.error').remove();

                    $.each(response.errors, (field, message) => {
                        form.find(`[data-field=${field}] .field-body`).append($('<div class="error pt-2">').html(message));
                    });
                })

            });

        });

    </script>
@append

@section('content')

<div class="content sign-in-page">
    <div class="container-fluid">
        <div class="single-form-block-wrap">
            <div class="single-form-block">
                <div class="title-box">
                    <h1 class="w-100 text-center">{{ trans('auth.reset-password') }}</h1>
                </div>

                <div class="tab-content section-tab" id="pressTabContent">
                    <div class="tab-pane fade show active" id="sign-text-tab" role="tabpanel" aria-labelledby="sign-tab">
                        <div class="single-content form-page-wrap">
                            <div class="inner">
                                <form action="{!! route('password_change', $token) !!}" method="POST" class="form-page" id="password-changes-form">
                                    @csrf
                                    <div class="form-group row field" data-field="password">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="sign_email">{{ trans('auth.fields.password') }}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="password" class="form-control" id="password" placeholder="" name="password">
                                        </div>
                                    </div>

                                    <div class="form-group row field" data-field="password_confirmation">
                                        <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                            <label for="sign_email">{{ trans('auth.fields.password_confirmation') }}</label>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-12 control-wrap field-body">
                                            <input type="password" class="form-control" id="password-confirmation" placeholder="" name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="btn-wrap row form-group">
                                        <div class="btn-inner offset-md-3 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap">
                                            <button type="submit" class="btn btn-primary">
                                                {{ trans('auth.change-password') }}
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
