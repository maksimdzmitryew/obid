@if(isset($texts->confidentiality_signup) || isset($texts->confidentiality_footer))
<p class="confidentiality">

@if($id == 'signup' && isset($texts->confidentiality_signup))
{!! trans($texts->confidentiality_signup, ['app_name' => $_env->s_title]) !!}
@endif

@if($id == 'footer' && isset($texts->confidentiality_footer))
{!! trans($texts->confidentiality_footer, ['app_name' => $_env->s_title]) !!}
@endif

</p>
@endif

