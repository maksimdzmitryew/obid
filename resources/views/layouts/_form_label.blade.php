			@if ($_env->s_utype == 'user' && $s_route_list)
			<a href="{!! route($s_route_list) !!}" target="_blank">
			@endif
			<span class="label">
				{!! $s_label !!}
			</span>
			@if ($_env->s_utype == 'user' && $s_route_list)
			</a>
			@endif
			{!! $b_required ? '<span class="text-danger">*</span>' : '' !!}
