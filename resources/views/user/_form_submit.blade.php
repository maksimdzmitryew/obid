@php
$s_type = 'submit';
@endphp
<div class="d-flex justify-content-end align-items-center">
	<button type="{!! $s_type !!}" title="{!! trans('user/crud.button.'.$s_type.'.key') !!}" class="btn btn-styled ml-2">{!! trans('user/crud.button.'.$s_type.'.label') !!} <i class="icon-paperplane ml-2"></i></button>
</div>
