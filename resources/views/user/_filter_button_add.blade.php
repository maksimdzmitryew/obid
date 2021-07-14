	<button type="button" class="btn btn-sm btn-success tooltip-helper" id="btn-{!! $btn_id ?? 'add'!!}" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.add.key') !!} | {!! trans('user/crud.button.add.label') !!} 
{{--
//
// TODO remove when users Module is ready
/********************************* datatable *********************************/
--}}
				@if ($s_category == 'user')
				{!! trans('app/user.btn.create') !!}
				@else
				{!! trans($s_category . '::crud.names.btn_create') !!}
				@endif
{{--
/********************************* /datatable *********************************/
// TODO remove when users Module is ready
//
--}}
		" data-trigger="hover"><i class="icon-file-plus"></i><span class="text"></span></button>
