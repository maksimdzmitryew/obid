@php
$name = 'mark';
@endphp

@section('script')
<script type="text/javascript">
@include($_env->s_sgl . '::common.var2js')
@include($_env->s_sgl . '::common.form_js')
$(document).ready(function () {
});
</script>
@append
@section('script')
<script type="text/javascript">
$(document).ready(function () {
@foreach($opinion->vote AS $k => $v)
	addMarks(
				"div_select_place_id .div_control",
				"div_tmpl_opinion",
				{!! $v->place_id !!},
//				{id: '{!! $v->element_id !!}', text: '{!! $element[$v->element_id] !!}'},
				{id: '{!! $v->element_id !!}', title: '{!! $element[$v->element_id] !!}'},
				'{!! $mark[$v->mark_id] !!}',
				{!! $v->mark_id !!},
			);
@endforeach
});
</script>
@append

@php
$control = 'input';
$s_model_name = 'opinion';
$s_model_nameid = 'vote[${id}]';

$s_visible_input = 'mark_id';
$s_tmp = str_replace('${id}', '.*.', $s_model_nameid.'['.$s_visible_input.']');
$s_tmp = str_replace(array('[',']'), '', $s_tmp);
$b_required = (isset($_env->a_rule[$s_tmp]) && stripos($_env->a_rule[$s_tmp], 'required') !== FALSE);
@endphp

@section('js')
<script type="text/javascript">
@include($_env->s_sgl . '::common.form_tmpl')
</script>
@append

