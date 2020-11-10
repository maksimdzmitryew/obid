<div class="buttons col-md-12 col-lg-8 col-xl-8 text-right">
@if (isset($a_buttons) && count($a_buttons) > 0)
@foreach ($a_buttons AS $s_name => $s_type)
	<a href="{{ route($_env->s_utype . '.' . $s_category . '.download', $s_type) }}" class="btn btn-outline-primary tooltip-helper" id="btn-{!! $s_name !!}" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.' . $s_name . '.label') !!} {!! trans($s_category . '::crud.names.btn_' . $s_name) !!}" data-trigger="hover" title="{!! trans('user/crud.button.' . $s_name . '.label') !!} {!! trans($s_category . '::crud.names.btn_' . $s_name) !!}">
	<i class="icon-file-spreadsheet"></i>
</a>
@endforeach
@endif
	<button type="button" class="btn btn-sm btn-success tooltip-helper" id="btn-add" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.add.key') !!} | {!! trans('user/crud.button.add.label') !!} {!! trans($s_category . '::crud.names.btn_create') !!}" data-trigger="hover"><i class="icon-file-plus"></i><span class="text"></span></button>
	<button type="button" class="btn btn-sm btn-danger tooltip-helper" id="btn-delete" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.delete.key') !!} | {!! trans('user/crud.button.delete.label') !!} {!! trans($s_category . '::crud.names.btn_delete') !!}" data-trigger="hover"><i class="icon-trash"></i><span class="text"></span></button>
	<button type="button" class="btn btn-sm btn-primary tooltip-helper" id="btn-filter" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.apply.key') !!} | {!! trans('user/crud.button.apply.label') !!}" data-trigger="hover"><i class="icon-filter3"></i><span class="text"></span></button>
	<button type="button" class="btn btn-sm btn-info tooltip-helper" id="btn-reset" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.reset.key') !!} | {!! trans('user/crud.button.reset.label') !!}" data-trigger="hover"><i class="icon-reset"></i><span class="text"></span></button>
</div>
