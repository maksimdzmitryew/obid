<?php

	$s_selected_id			= NULL;
	$s_name_select			= $name . '_list';
	if ($b_item_id_isset)
	{
		$o_collection			= $$name->keyBy('id');
#		$o_collection			= $$s_name_select->keyBy('id');
		$s_selected_id		= $o_item->$s_id;
		$s_selected_title	= $o_collection[$s_selected_id]->translate($app->getLocale())->title;
	}
