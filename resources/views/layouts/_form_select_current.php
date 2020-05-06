<?php

	$s_selected_title = '';
	$s_selected_id = NULL;
	if($o_item->$s_id)
	{
		$o_collection		= $$name->keyBy('id');
		$s_selected_id		= $o_item->$s_id;
		$s_selected_title	= $o_collection[$o_item->$s_id]->translate($app->getLocale())->title;
	}
