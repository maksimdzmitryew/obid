@exntends('layouts.public')

@section('content')

<div class="content registr-journalist-page bg-grey">
    <div class="container-fluid">
        <div class="single-form-block-wrap">
            <div class="single-form-block">
                <h1 class="title-block mb-4">Press Registration</h1>

                <div class="single-content form-page-wrap">
                    <div class="inner">
                        <form action="#" class="form-page" id="journalist-form">
                            <div class="form-group row">
                                <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                    <label for="journalist_first_name">First Name</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-12 control-wrap">
                                    <input type="text" class="form-control" id="journalist_first_name"
                                           placeholder="John">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                    <label for="journalist_last_name">Last name</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-12 control-wrap">
                                    <input type="text" class="form-control" id="journalist_last_name"
                                           placeholder="Newman">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                    <label for="journalist_email">Email</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-12 control-wrap">
                                    <input type="text" class="form-control" id="journalist_email"
                                           placeholder="john.newman@gmail.com">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                    <label for="journalist_country">Country</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-12 control-wrap">
                                    <select name="profile_country" id="journalist_country" class="full-width">
                                        <option selected>France</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                    <label for="journalist_media_type">Country</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-12 control-wrap">
                                    <select name="profile_country" id="journalist_media_type" class="full-width">
                                        <option selected>Magazine</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                    <label for="journalist_organization">Organization</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-12 control-wrap">
                                    <input type="text" class="form-control" id="journalist_organization"
                                           placeholder="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3 col-sm-4 col-12 label-wrap">
                                    <label for="journalist_function">Function</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-12 control-wrap">
                                    <select name="profile_country" id="journalist_function" class="full-width">
                                        <option selected>Editor</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>

                            <div class="btn-wrap row form-group">
                                <div class="btn-inner offset-md-3 col-md-9 offset-sm-4 col-sm-8 col-12 control-wrap">
                                    <button type="submit" class="btn btn-primary">
                                        Create a new account
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

@endsection
