<?php

include(base_path().'/resources/views/user/menu.php');
$a_parts = [];
foreach ($menu_list AS $k => $a_items)
	for ($i = 0; $i < count($a_items); $i++)
		$a_parts[] = ucfirst($a_items[$i]);
sort($a_parts);

$a_modules = [];
$a_res = file_get_contents(base_path().'/modules_statuses.json');
$a_modules = array_keys(json_decode($a_res, TRUE));
/**
 *	first value is expected to be decoration theme for frontend so we keep it at its place after sorting
 */
$s_theme = array_shift($a_modules);
sort($a_modules);
array_unshift($a_modules, $s_theme);

return ['list' => $a_parts, 'modules' => $a_modules];
