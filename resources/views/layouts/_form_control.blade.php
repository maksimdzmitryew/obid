@php
include(base_path().'/resources/views/layouts/_form_variables.php');
@endphp
@include($theme . '::' . $_env->s_utype . '._form_' . $control)
