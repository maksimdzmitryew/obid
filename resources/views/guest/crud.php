<?php

$s_tmp				= request()->route()->getAction()['as'];
$a_tmp				= explode('.', $s_tmp);
$s_category			= mb_strtolower($a_tmp[1]);

$s_form_route		= mb_strtolower($a_tmp[1]).'.'.mb_strtolower($a_tmp[2]);
$s_utype			= $a_tmp[0];

$s_cat_sgl_low		= mb_strtolower(trans($s_category . '::crud.names.sgl'));
$s_cat_sgl_up		= mb_strtoupper($s_cat_sgl_low);
$s_cat_sgl_u1		= ucfirst($s_cat_sgl_low);

$s_cat_plr_low		= mb_strtolower(trans($s_category . '::crud.names.plr'));
$s_cat_plr_up		= mb_strtoupper($s_cat_plr_low);
$s_cat_plr_u1		= ucfirst($s_cat_plr_low);

$s_create_route		= route($s_utype.'.'.$s_form_route);
#$s_delete_route		= route('api.' . $s_category . '.destroy');
$s_list_route		= route($s_utype . '.personal.places');
$s_cancel_route		= route($s_utype . '.personal.places');
$s_opinion_route	= route($s_utype . '.opinion.form', [':type', ':id']);
$s_list_name		= trans('common/form.breadcrumbs.list') . ' ' . trans($s_category . '::crud.names.list');

$s_title			= trans($s_category . '::crud.names.plr');

if (isset($$s_category))
{
	$o_item				= $$s_category;
	$s_page_action		= ($o_item->id
								? trans('common/form.text.edit')
								: trans('common/form.text.create')
							)
							. ' '
							. ($o_item->id
								? trans($s_category . '::crud.names.txt_edit')
								: trans($s_category . '::crud.names.txt_create')
							)
							;
	$s_page_route		= ($o_item->id
								? route('admin.' . $s_category . '.form', $o_item->id)
								: route('admin.' . $s_category . '.form')
							);
	$s_form_method		= ($o_item->id
								? 'post'
								: 'post'
							);

	$s_form_route		= ($o_item->id
								? route('api.' . $s_category . '.update', $o_item->id)
								: route('api.' . $s_category . '.store')
							);

	switch ($s_category)
	{
		case 'opinion':
		$s_btn_primary		= trans('common/form.actions.view') . ' ' . trans("common/form.breadcrumbs.list");
		$s_route_primary	= $s_list_route;
		$s_btn_secondary	= '';
		$s_route_secondary	= '';
		$s_btn_extra		= '';
		$s_route_extra		= '';
		break;
		case 'place':
		$s_btn_primary		= trans('common/form.actions.evaluate');
		$s_route_primary	= $s_opinion_route;
		$s_btn_secondary	= trans('common/form.actions.create_more');
		$s_route_secondary	= $s_create_route;
		$s_btn_extra		= trans('common/form.actions.view') . ' ' . trans("common/form.breadcrumbs.list");
		$s_route_extra		= $s_list_route;
		break;
		default:
		$s_btn_primary		= ($o_item->id
									? trans('common/form.actions.continue') . ' ' . trans('common/form.actions.edit')
									: trans('common/form.actions.create_more')
								);
		$s_route_primary	= $s_page_route;
		$s_btn_secondary	= trans("common/form.breadcrumbs.list");
		$s_route_secondary	= $s_list_route;
		break;
	}
}

if (!isset($b_script_loaded))
	$b_script_loaded = [];
