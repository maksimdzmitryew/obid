<th width="1px">{!! trans('user/crud.table.actions') !!}</th>
<th width="5%">{!! trans('user/crud.table.published') !!}</th>

@if (!isset($b_title) || (isset($b_title) && $b_title))
<th width="50%">{!! trans('crud.field.title.label') !!}</th>
@endif

@if (isset($a_columns) && count($a_columns) > 0)
@foreach ($a_columns AS $s_name => $s_type)
<th width="10%">{!! trans($_env->s_sgl.'::crud.field.' . $s_name . '.label') !!}</th>
@endforeach
@endif

<th width="15%">{!! trans('user/crud.table.created_at') !!}</th>
<th width="15%">{!! trans('user/crud.table.updated_at') !!}</th>
<th width="1px">{!! trans('user/crud.field.id.label') !!}</th>
