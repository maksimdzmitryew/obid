{{--
id is compatible with both blade templating and usage in javascript
--}}
<a href="{!! route('admin.'.$s_category.'.form', [ (isset($id) ? $id : ':id') ]) !!}" class="btn btn-sm btn-primary  tooltip-helper" data-toggle="tooltip" data-placement="top" title="{!! trans('user/crud.button.edit.label') !!} 
{{--
//
// TODO remove when users Module is ready
/********************************* datatable *********************************/
--}}
				@if ($s_category == 'user')
				{!! trans('app/user.btn.edit') !!}
				@else
				{!! trans($s_category . '::crud.names.btn_edit') !!}
				@endif
{{--
/********************************* /datatable *********************************/
// TODO remove when users Module is ready
//
--}}
		" data-trigger="hover"><i class="icon-pencil"></i></a>