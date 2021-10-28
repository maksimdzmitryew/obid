<style>
.card_group {
	width:200px; height:200px; display:block; float:left;
}
.card_group li {
	list-style: none;
}
.card_group .top_level {
	display: block;
}
.card_group .sub_level {
	display: none;
}
.card_group:hover>div.top_level {
	display: none;
}
.card_group:hover>div.sub_level {
	display: block;
}
.top_level {
	padding-top:20%;text-align: center;
}
.sub_level {
	text-align: left; padding-left: 10px;
}
.sub_level a {
	color: white
}
.sub_level i {
	padding-right: 10px;
}
</style>

@foreach($menu_title AS $i_idx => $menu_name)
<div class="card_group" style="background-color:{{ $menu_color[$i_idx] }}; color:{{ $text_color[$i_idx] }};">
	<div class="top_level" style="">
		<i style="font-size:6em" class="{{ $menu_icon[$i_idx] }}"></i>
		<br />
		<font style="font-size:2em">{!! trans('menu.' . $menu_name) !!}</font>
	</div>
	<div class="sub_level" style="">
		@foreach($menu_list[$i_idx] AS $i_cnt => $menu_item)
		<a href="{!! route('admin.' . $menu_item . '.index') !!}" class="nav-link" style="color:{{ $text_color[$i_idx] }};">
		<i class="{!! Config::get($menu_item.'.ico') !!} {!! config('icons.'.$menu_item) !!}"></i><span>
{{--
//
// TODO remove when users Module is ready
/********************************* datatable *********************************/
--}}
				@if ($menu_item == 'user')
				{!! trans('app/user.menu.title') !!}
				@else
				{!! trans($menu_item . '::crud.names.plr') !!}
				@endif
{{--
/********************************* /datatable *********************************/
// TODO remove when users Module is ready
//
--}}
				</span>
		</a>
		@endforeach
	</div>
</div>
@endforeach
