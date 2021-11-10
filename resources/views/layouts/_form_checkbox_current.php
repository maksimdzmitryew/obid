<?php

	if ($b_item_id_isset)
	{
#		$o_collection = $$name->keyBy('id');
#		$s_selected_id = $o_item->$s_id;
		$s_selected_title = ($s_value ? 'checked="checked"' : '');#$o_collection[$o_item->$s_id]->translate($app->getLocale())->title;
	}
	else
	{
		$s_selected_title = ($_env->a_default[$s_fieldname] ? 'checked="checked"' : '');
	}
