<h3>{{ trans('user/form.text.reset_subj') }}</h3>

<p>{!! trans('user/form.text.reset_preface') !!}</p>

<h4>{!! trans('user/form.text.reset_option', ['cnt' => 1]) !!}</h4>
<p>
	<a href="{!! route('password_change', ['token' => $hash]) !!}">{!! trans('user/form.button.reset_link') !!}</a>
</p>

<h4>{!! trans('user/form.text.reset_option', ['cnt' => 2]) !!}</h4>
<p>
	{!! trans('user/form.text.reset_link') !!}: {!! route('password_change', ['token' => $hash]) !!}
</p>

<h4>{!! trans('user/form.text.reset_option', ['cnt' => 3]) !!}</h4>
<p>
	{!! trans('user/form.text.reset_manual') !!} {!! route('password_change', ['token' => NULL]) !!} {!! trans('user/form.text.reset_token') !!} {!! $hash !!}
</p>