<?php
return [
	'field' => [
		'description' => [
			'label'		=> 'Опис',
			'filterby'	=> 'описом',
			'typein'	=> 'текст опису',
		],
		'email' => [
			'label'		=> 'Е-пошта',
			'filterby'	=> 'е-поштою',
			'typein'	=> 'е-пошту',
		],

//
// TODO remove when users Module is ready
/********************************* filters at items list page *********************************/
		'first_name'	=> [
			'label'		=> 'Ім’я',
			'filterby'	=> 'ім’ям',
			'typein'	=> 'Ім’я',
		],
		'last_name' 	=> [
			'label'		=> 'Прізвище',
			'filterby'	=> 'прізвищем',
			'typein'	=> 'прізвище',
		],
/********************************* filters at items list page *********************************/
// TODO remove when users Module is ready
//

		'name_first'	=> [
			'label'		=> 'Ім’я',
			'filterby'	=> 'ім’ям',
			'typein'	=> 'Ім’я',
		],
		'name_last' 	=> [
			'label'		=> 'Прізвище',
			'filterby'	=> 'прізвищем',
			'typein'	=> 'прізвище',
		],
		'phone' => [
			'label'		=> 'Телефон',
			'filterby'	=> 'телефоном',
			'typein'	=> 'телефон',
		],
		'title' => [
			'label'		=> 'Назва',
			'filterby'	=> 'назвою',
			'typein'	=> 'назву',
		],
	],
	'hint' => [
		'input'			=> 'Введіть',
		'checkbox'		=> 'Перемкніть',
		'file'			=> 'Завантажіть',
		'image'			=> 'Завантажіть',
		'select'		=> 'Виберіть',
	],
];
