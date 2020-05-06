@extends($theme . '::' . $_env->s_utype . '.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('welcome.name') !!}
    </p>
    <p>
         and is extending {!! config('providnykV1.name') !!}.
    </p>
@endsection
