	<button type="button" class="btn btn-sm btn-danger tooltip-helper" id="btn-{!! $btn_id ?? 'delete'!!}" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.delete.key') !!} | {!! trans('user/crud.button.delete.label') !!} 
{{--
//
// TODO remove when users Module is ready
/********************************* datatable *********************************/
--}}
				@if ($s_category == 'user')
				{!! trans('app/user.btn.delete') !!}
				@else
				{!! trans($s_category . '::crud.names.btn_delete') !!}
				@endif
{{--
/********************************* /datatable *********************************/
// TODO remove when users Module is ready
//
--}}
		" data-trigger="hover"><i class="icon-trash"></i><span class="text"></span></button>
