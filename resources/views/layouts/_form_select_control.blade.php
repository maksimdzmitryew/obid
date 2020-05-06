	@if ($b_readonly || $b_disabled)
	<input type="hidden" name="{!! $s_id !!}{!! $b_many ? '[]' : '' !!}" value="{!! $s_selected_id !!}"/>
	@endif
		<select name="{!! $s_id !!}{!! $b_many ? '[]' : '' !!}" class="select2-dropdown {!! $b_many ? 'multi-select' : '' !!}" id="{!! $s_id !!}@if ($b_readonly || $b_disabled){!! '_off' !!}@endif" data-placeholder="{!! $s_hint !!} {!! $s_typein !!}" data-url="{!! route($s_route_api) !!}"{!! $b_many ? ' multiple' : '' !!}{!! $b_disabled ? ' disabled="disabled"' : '' !!}{!! $b_readonly ? ' readonly' : '' !!}>
			@if($s_selected_id)
				<option value="{!! $s_selected_id !!}">
					{!! $s_selected_title !!}
				</option>
			@elseif ($b_many && $$name)
				 @foreach($$name as $o_tmp)
				 @php $b_selected = (in_array($o_tmp->id, $o_item->$name->pluck('id')->toArray())); @endphp
				<option value="{!! $o_tmp->id !!}" {!! $b_selected ? 'selected="selected"' : '' !!}>
					{!! $o_tmp->translate($app->getLocale())->title !!}
				</option>
				@endforeach
			@endif
		</select>

@section('css-select')
<link rel="stylesheet" href="{!! asset('/css/select2.css?v=' . $version->css) !!}">
@endsection
@section('js-select')
<script src="{{ asset('/admin/js/plugins/forms/selects/select2.min.js') }}"></script>
<script src="{!! asset('/js/liveDropDowns.js?v=' . $version->js) !!}"></script>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function () {
//	$("#{!! $s_id !!}").trigger('change');
	@if ($b_readonly)
	$("#{!! $s_id !!}_off").select2({disabled:'readonly'});
	$("#{!! $s_id !!}_off").trigger('change');
	@endif
	@if ($b_disabled)
	$("#{!! $s_id !!}_off").select2({disabled:true});
	@endif
});
</script>
@append

