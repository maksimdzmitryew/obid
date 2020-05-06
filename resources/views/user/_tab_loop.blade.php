@for ($t = 0; $t < count($form['tabs']); $t++)
@php
$s_tab_key = $form['tabs'][$t];
$b_active = ($t == 0);
@endphp
@include($tpl)
@endfor
