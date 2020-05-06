<?php
$menu_title = [];
$menu_color = [];
$menu_icon = [];
$menu_list = [];
/*
$menu_title = 'entertainment';
$menu_color = '#f5ad42';
$menu_icon = 'fa fa-sign-language';
$menu_list = ['festivals' => 'icon-music', 'partners' => 'fa fa-handshake-o', 'events' => 'icon-calendar', 'presses' => 'icon-newspaper', 'news' => 'fa fa-globe'];
{{--@ include('admin.common._card_group')--}}*/

$menu_title[] = 'materials';
$menu_color[] = '#5933d6';
$menu_icon[] = 'fa fa-file-image-o';
$menu_list[] = ['place', 'style', 'building', 'element', ];

$menu_title[] = 'improvements';
$menu_color[] = '#f5ad42';
$menu_icon[] = 'fa fa-envelope';
$menu_list[] = ['opinion', 'mark', 'complaint', ];
#$menu_list[] = ['report', 'issue', ];

$menu_title[] = 'people';
$menu_color[] = '#33d669';
$menu_icon[] = 'fa fa-address-book';
$menu_list[] = ['user', ];#, 'artists' => 'icon-mic2'];

/*
{{--@ include('admin.common._card_group')--}}

$menu_title = 'lists';
$menu_color = '#ab2b67';
$menu_icon = 'fa fa-list';
$menu_list = ['categories' => 'icon-list2', 'places' => 'icon-pin-alt', 'cities' => 'icon-city', 'vocations' => 'icon-headset', 'professions' => 'fa fa-briefcase'];
{{--@ include('admin.common._card_group')--}}

$menu_title = 'website';
$menu_color = '#141edb';
$menu_icon = 'fa fa-cogs';
$menu_list = ['settings' => 'fa fa-cog', 'texts' => 'icon-file-text2', 'pages' => 'icon-versions'];
{{--@ include('admin.common._card_group')--}}*/
