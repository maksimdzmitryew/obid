<?php

$s_label			= '';
$s_rules			= '';
$b_many				= FALSE;
$b_disabled			= FALSE;
$b_readonly			= FALSE;
$s_typein			= '';
$s_hint				= '';
$s_route			= '';
$s_route_api		= '';
$s_route_list		= '';

if (stristr($name, '_id'))
{
	$id				= $name;
#	if (stristr($name, '_ids'))
	$b_many			= (stristr($name, '_ids'));
	$name			= str_replace(['_ids','_id',], '', $name);
}

#$b_many = (isset($many) ? $many : FALSE);
if (!isset($id)) # direct/simple value
	$s_id = $name;
else # expected to be a foreign key *_id
{
	$s_id			= $id;
#	$s_label = trans('user/'.$name.'.names.sgl');
#	$s_typein = trans('user/'.$name.'.names.typein');
	$s_route_list	= 'admin.'.$name.'.index';
	$s_route_api	= 'api.'.$name.'.index';
}

$s_dataname			= ($code ? $code .'.' : '') . $s_id;
$s_fieldname		= ($code ? $code .'[' : '') . $s_id . ($code ? ']' : '');
$s_value			= $o_item->id
						? ($code ? $o_item->translate($code)->$name : $o_item->$name)
						: ''
						;
$s_class_name		= (isset($s_class_name) ? $s_class_name : '');

$a_labels			= [];

/**
 * ------ Project specific ------
 */
/**
 * Access-role specific
 */
$a_field_trans[]	= $_env->s_utype . '/' . $name . '.names';
/**
 * Access-role independent
 */
$a_field_trans[]	= $name . '.names';

/**
 * ------ This Module specific ------
 */
/**
 * Access-role specific
 */
$a_field_trans[]	= $s_category . '::' . $_env->s_utype . '/crud';
/**
 * Access-role independent
 */
$a_field_trans[]	= $s_category . '::crud';

/**
 * ------ Original Module specific ------
 */
/**
 * Access-role specific
 */
$a_field_trans[]	= $name . '::' . $_env->s_utype . '/crud.names';
/**
 * Access-role independent
 */
$a_field_trans[]	= $name . '::crud.names';

/**
 * ------ General 1 of 2 ------
 * Module specific
 */
/**
 * Access-role specific
 */
$a_field_trans[]	= $_env->s_utype . '/' . $s_category;
/**
 * Access-role independent
 */
$a_field_trans[]	= $s_category;
/**
 * ------ General 2 of 2 ------
 * Module independent
 */
/**
 * Access-role specific
 */
$a_field_trans[]	= $_env->s_utype . '/crud';
/**
 * Access-role independent
 */
$a_field_trans[]	= 'crud';

$i = 0;
do
{
	$s_tmp			= $a_field_trans[$i] . '.sgl';
	if (empty($s_label) && $s_tmp != trans($s_tmp)) $s_label = trans($s_tmp);

	$s_tmp			= $a_field_trans[$i] . '.field.' . $name . '.label';
	if (empty($s_label) && $s_tmp != trans($s_tmp)) $s_label = trans($s_tmp);

	$s_tmp			= $a_field_trans[$i] . '.field.' . $name . '.typein';
	if (empty($s_typein) && $s_tmp != trans($s_tmp)) $s_typein = trans($s_tmp);
	$s_tmp			= $a_field_trans[$i] . '.typein';
	if (empty($s_typein) && $s_tmp != trans($s_tmp)) $s_typein = trans($s_tmp);

	$s_tmp			= $a_field_trans[$i] . '.hint.' . $control;
	if (empty($s_hint) && $s_tmp != trans($s_tmp)) $s_hint = trans($s_tmp);

	$i++;
}
while ((empty($s_label) || empty($s_typein) || empty($s_hint)) && $i < count($a_field_trans));

/**
 * fallback to plain field name, typein, and hint
 */
if (empty($s_label)) $s_label		= '“'.$name.'”';
if (empty($s_typein)) $s_typein		= '“'.$name.'”';
if (empty($s_hint)) $s_hint			= '“'.$control.'”';

/**
dump($s_label, $s_typein);
 * Module specific user-role related
 */

/*elseif (trans('user/'.$s_category.'.field.'.$s_id.'.label') != 'user/'.$s_category.'.field.'.$s_id.'.label')
{
	$s_label = trans('user/'.$s_category.'.field.'.$s_id.'.label');
	$s_typein = trans('user/'.$s_category.'.field.'.$s_id.'.typein');

}
elseif (trans('user/crud.field.'.$name.'.label') != 'user/crud.field.'.$name.'.label')
{
	$s_label = trans('user/crud.field.'.$name.'.label');
	$s_typein = trans('user/crud.field.'.$name.'.typein');
}
*/
/*
if (trans('user/'.$s_category.'.field.'.$s_id.'.rules') != 'user/'.$s_category.'.field.'.$s_id.'.rules')
	$s_rules = trans('user/'.$s_category.'.field.'.$s_id.'.rules');
elseif (trans('user/crud.field.'.$name.'.rules') != 'user/crud.field.'.$name.'.rules')
	$s_rules = trans('user/crud.field.'.$name.'.rules');
*/
$s_rules			= $_env->a_rule[$s_id];
$b_required			= (stripos($s_rules, 'required') !== FALSE);
$b_disabled			= isset($o_item->disabled) && in_array($s_id, $o_item->disabled);
$b_readonly			= isset($o_item->readonly) && in_array($s_id, $o_item->readonly);

include(base_path().'/resources/views/layouts/_form_' . $control . '_current.php');
