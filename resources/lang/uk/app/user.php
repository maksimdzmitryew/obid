<?php

return [
    'breadcrumbs' => [
        'list' => 'Users list',
        'create' => 'Create user',
        'edit' => 'Edit user'
    ],
    'list' => [
        'title' => 'Users list',
        'buttons' => [
            'add' => 'Add new',
            'reset' => 'Reset filters',
            'apply' => 'Apply filter',
            'delete' => 'Deleted selected'
        ],
    ],
    'form' => [
        'submit' => 'Submit',
        'title' => [
            'create' => 'Create user',
            'edit' => 'Edit user'
        ],
        'tabs' => [
            'main' => 'Main',
            'secondary' => 'Secondary'
        ],
        'fields' => [
            'first_name' => [
                'label' => 'Enter first name',
                'rules' => 'required'
            ],
            'last_name' => [
                'label' => 'Enter last name',
                'rules' => 'required'
            ],
            'role_id' => [
                'label' => 'Select role',
                'rules' => 'one from list'
            ],
            'email' => [
                'label' => 'Enter email',
                'rules' => 'required | email'
            ],
            'password' => [
                'label' => 'Enter password',
                'rules' => 'required | min-length: 6 | max-length : 20'
            ],
            'password_confirmation' => [
                'label' => 'Confirm password',
                'rules' => 'required | same: password'
            ],
            'old_password' => [
                'label' => 'Enter old password',
                'rules' => 'required | min-length: 6 | max-length : 20'
            ],
            'new_password' => [
                'label' => 'Enter new password',
                'rules' => 'required | min-length: 6 | max-length : 20'
            ],
            'new_password_confirmation' => [
                'label' => 'Confirm new password',
                'rules' => 'required | min-length: 6 | max-length : 20'
            ],

        ],
        'legends' => [
            'main' => 'Main info',
            'password' => 'Change password'
        ]
    ]
];
