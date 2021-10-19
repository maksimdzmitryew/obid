<th width="1px">{!! trans('user/crud.table.actions') !!}</th>

@php
$s_field_name			= 'published';

$a_trans_path[0]	= $_env->s_sgl.'::crud';
$a_trans_path[1]	= 'user/'.$_env->s_sgl;
$a_trans_path[2]	= 'user/crud';

$s_label			= '';
for ($i = 0; $i < count($a_trans_path); $i++)
{
	$s_tmp			= $a_trans_path[$i] . '.field.'.$s_field_name.'.label';
	if (empty($s_label) && trans($s_tmp) != $s_tmp)
	{
		$s_label = trans($s_tmp);
	}
}
@endphp

<th width="5%">{!! $s_label !!}</th>

@if ($b_title_final)
@php
	$s_name			= 'title';
	$s_label		= 'crud.field.'.$s_name.'.label';
	$s_tmp			= $_env->s_sgl.'::crud.field.' . $s_name . '.label';
	if ($s_tmp != trans($s_tmp)) $s_label = $s_tmp;
@endphp
<th width="50%">{!! trans($s_label) !!}</th>
@endif

@if (isset($a_columns) && count($a_columns) > 0)
@foreach ($a_columns AS $s_field_name => $s_type)

@php
$a_trans_path[0]	= $_env->s_sgl.'::crud';
$a_trans_path[1]	= 'user/'.$_env->s_sgl;
$a_trans_path[2]	= 'user/crud';

$s_label			= '';
for ($i = 0; $i < count($a_trans_path); $i++)
{
	$s_tmp			= $a_trans_path[$i] . '.field.'.$s_field_name.'.label';
	if (empty($s_label) && trans($s_tmp) != $s_tmp)
	{
		$s_label = trans($s_tmp);
	}
}

if (!$b_title_final && $s_field_name == 'slug')
{
	$s_col_width = '50%';
}
else
{
	$s_col_width = '10%';
}
@endphp


<th width="{{ $s_col_width }}">{!! $s_label !!}</th>
@endforeach
@endif

<th width="15%" style="min-width: 230px;">{!! trans('user/crud.table.created_at') !!}</th>
<th width="15%" style="min-width: 230px;">{!! trans('user/crud.table.updated_at') !!}</th>
<th width="1px">{!! trans('user/crud.field.id.label') !!}</th>
