@php
# $version = include_once( __DIR__ . '/../../../version.php');
@endphp<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Auth</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/admin/css/app.css?v={{ config('version.css')) }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

</head>
<body>
<!-- Page content -->
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">@yield('content')</div>
        <!-- /content area -->

    </div>
    <!-- /main content -->


</div>
<!-- /page content -->
<script src="/admin/js/app.js"></script>
</body>
</html>
