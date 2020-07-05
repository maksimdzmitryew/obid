<?php

	$s_selected_title = '';
#	$s_selected_id = NULL;
	if($o_item->id)#if($o_item->$s_id)
	{
#		$o_collection = $$name->keyBy('id');
#		$s_selected_id = $o_item->$s_id;
		$s_selected_title = ($s_value ? 'checked="checked"' : '');#$o_collection[$o_item->$s_id]->translate($app->getLocale())->title;
	}
	else
	{
		$s_selected_title = ($_env->a_default[$s_fieldname] ? 'checked="checked"' : '');
	}