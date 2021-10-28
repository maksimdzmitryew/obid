<?php

return [
    'breadcrumbs' => [
        'list' => 'Спис користувачів',
        'create' => '=====',
        'edit' => '-----'
    ],
    'list' => [
        'title' => 'Спис користувачів',
        'buttons' => [
            'add' => 'Add new',
            'reset' => 'Reset filters',
            'apply' => 'Apply filter',
            'delete' => 'Deleted selected'
        ],
    ],
    'menu' => [
        'title' => 'Користувачи',
        ],
    'btn' => [
        'create' => 'користувача',
        'edit' => 'користувача',
        'delete' => 'користувачів',
        ],
    'form' => [
        'submit' => 'Submit',
        'title' => [
            'create' => 'Створення користувача',
            'edit' => 'Edit user'
        ],
        'tabs' => [
            'main' => 'Дані',
            'secondary' => 'Secondary'
        ],
        'fields' => [
            'first_name' => [
                'label' => 'Введіть Ім’я',
                'rules' => 'required'
            ],
            'last_name' => [
                'label' => 'Введіть Прізвище',
                'rules' => 'required'
            ],
            'role_id' => [
                'label' => 'Оберіть роль',
                'rules' => 'one from list'
            ],
            'email' => [
                'label' => 'Введіть email',
                'rules' => 'required | email'
            ],
            'password' => [
                'label' => 'Введіть гасло',
                'rules' => 'required | min-length: 6 | max-length : 20'
            ],
            'password_confirmation' => [
                'label' => 'Підтвердження гасла',
                'rules' => 'required | same: password'
            ],
            'old_password' => [
                'label' => 'Введіть бегучий гасло',
                'rules' => 'required | min-length: 6 | max-length : 20'
            ],
            'new_password' => [
                'label' => 'Введіть new гасло',
                'rules' => 'required | min-length: 6 | max-length : 20'
            ],
            'new_password_confirmation' => [
                'label' => 'Confirm new гасло',
                'rules' => 'required | min-length: 6 | max-length : 20'
            ],

        ],
        'legends' => [
            'main' => 'Загальна інформація',
            'password' => 'Change гасло'
        ]
    ]
];
