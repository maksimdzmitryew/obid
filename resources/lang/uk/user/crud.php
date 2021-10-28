<?php

return [
	'tab' => [
		'data' => [
			'name'		=> 'Дані',
			'info'		=> 'Загальна інформація',
		],
		'manage' => [
			'name'		=> 'Керування',
			'info'		=> 'Управління записом',
		],
		'photo' => [
			'name'		=> 'Світлини',
			'info'		=> 'Фотографії об’єкта',
		],
	],
	'filter' => [
		'label'			=> 'Фільтрувати за',
		'title'			=> 'Назвою',
		'created_at'	=> 'датою створення',
		'updated_at'	=> 'датою оновлення',
		'perpage'		=> 'записів на сторінці',
	],
	'table' => [
		'created_at'	=> 'Створено',
		'updated_at'	=> 'Оновлено',
		'actions'		=> 'Дії',
		'published'		=> 'Опубліковано', # published - formally made public; "published accounts"
		'enabled'		=> 'Так',
		'disabled'		=> 'Ні',
	],
	'field' => [
		'active' => [
			'label'		=> 'Дійсний',
			'filterby'	=> 'дійсністю',
			'typein'	=> 'дійсність',
		],
		'id' => [
			'label'		=> 'ID',
		],
		'image' => [
			'label'		=> 'Зображення',
			'filterby'	=> 'зображенням',
			'typein'	=> 'зображенні',
		],
		'published' => [
			'label'		=> 'Оприлюднено',
			'filterby'	=> 'оприлюднені',
			'typein'	=> 'оприлюднене',
		],
		'role' => [
			'label'		=> 'Роль',
			'filterby'	=> 'роллю',
			'typein'	=> 'роль',
		],
		'timezone' => [
			'label'		=> 'Виберіть часовий пояс',
		],
		'user_name' => [
			'label'		=> 'Ім‘я Прізвище',
		],




//
// TODO remove when users Module is ready
/********************************* datatable *********************************/
		'first_name'	 => [
			'label'			=> 'Ім’я',
			'filterby'	=> 'ім’ям',
			'typein'		=> 'Ім’я',
		],
		'last_name' 	=> [
			'label'			=> 'Прізвище',
			'filterby'	=> 'прізвищем',
			'typein'		=> 'прізвище',
		],
		'email' => [
			'label'			=> 'Е-пошта',
			'filterby'	=> 'е-поштою',
			'typein'		=> 'е-пошту',
		],
/********************************* /datatable *********************************/
// /TODO remove when users Module is ready
//




	],
	'hint' => [
		'disabled'		=> 'Ні',
		'enabled'		=> 'Так',



//
// TODO remove when users Module is ready
/********************************* filter *********************************/
		'select'		=> 'Оберіть',
/********************************* /filter *********************************/
// /TODO remove when users Module is ready
//



	],
	'button' => [
		'add' => [
			'label'		=> 'Додати',
			'key'		=> 'ctrl+A',
		],
		'apply' => [
			'label'		=> 'Шукати (Застосувати фільтри)',
			'key'		=> 'ctrl+S',
		],
		'delete' => [
			'label'		=> 'Видалити вибраних',
			'key'		=> 'ctrl+D',
		],
		'download' => [
			'label'		=> 'Скачати всі',
			'key'		=> '',
		],
		'edit' => [
			'label'		=> 'Редагувати',
			'key'		=> '',
		],
		'reset' => [
			'label'		=> 'Скинути фільтри',
			'key'		=> 'ctrl+B',
		],
		'submit' => [
			'label'		=> 'Зберегти',
			'key'		=> 'ctrl+S',
		],
	],
];
