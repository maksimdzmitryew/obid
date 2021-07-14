<?php
$menu_title			= [];
$menu_color			= [];
$text_color			= [];
$menu_icon			= [];
$menu_list			= [];
/*
$menu_title = 'entertainment';
$menu_color = '#f5ad42';
$menu_icon = 'fa fa-sign-language';
$menu_list = ['festivals' => 'icon-music', 'partners' => 'fa fa-handshake-o', 'events' => 'icon-calendar', 'presses' => 'icon-newspaper', 'news' => 'fa fa-globe'];
{{--@ include('admin.common._card_group')--}}*/
$menu_title[]		= 'foods';
$menu_color[]		= '#5933d6';
$text_color[]		= '#DDD';
$menu_icon[]		= 'fas fa-hat-chef';
$menu_list[]		= ['provider', 'course', 'meal', 'plate', ];


$menu_title[]		= 'needs';
$menu_color[]		= '#f5ad42';
$text_color[]		= '#555';
$menu_icon[]		= 'fas fa-cash-register';
$menu_list[]		= ['demand', ];
#$menu_list[] = ['report', 'issue', ];

$menu_title[]		= 'people';
$menu_color[]		= '#33d669';
$text_color[]		= '#555';
$menu_icon[]		= 'fa fa-address-book';
$menu_list[]		= ['user', ];

$menu_title[]		= 'website';
$menu_color[]		= '#141edb';
$text_color[]		= '#DDD';
$menu_icon[]		= 'fa fa-cogs';
$menu_list[]		= ['page', 'reaction', ];
#$menu_list[] = ['settings', 'texts', 'page', ];

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
