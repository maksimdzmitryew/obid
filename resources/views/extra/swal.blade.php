<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{!! asset('/admin/css/app.css') !!}" rel="stylesheet" type="text/css">
</head>
<body>
<button id="basic">click</button>
<script src="{!! asset('/admin/js/main/jquery.min.js') !!}"></script>
<script src="{!! asset('/admin/js/main/bootstrap.bundle.min.js') !!}"></script>
<script src="{{ asset('/admin/js/plugins/notifications/noty.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/forms/styling/switchery.min.js') }}"></script>
<script src="{{ asset('/admin/js/plugins/forms/styling/switch.min.js') }}"></script>
<script>
    $(document).ready(() => {
        $('#basic').on('click', function() {
            swal({
                title: 'Here is a message!'
            });
        });
    });
</script>
</body>
</html>