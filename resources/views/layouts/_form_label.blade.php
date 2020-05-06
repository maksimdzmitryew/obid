			@if ($s_route_list && $_env->s_utype == 'user')
			<a href="{!! route($s_route_list) !!}" target="_blank">
			@endif
			{!! $s_label !!}
			@if ($s_route_list && $_env->s_utype == 'user')
			</a>
			@endif
			{!! $b_required ? '<span class="text-danger">*</span>' : '' !!}
