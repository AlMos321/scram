<?php
return [
    'title' => 'Користувачі',
    'single' => 'користувача',
    'model' => 'App\User',
    /**
     * The display columns
     */
    'columns' => [
        'id' => [
            'title' => '#'
        ],
        'name' => [
            'title' => 'Імя'
        ],
        'surname' => [
            'title' => 'Прізвище'
        ],
        'email' => [
            'title' => 'Email'
        ],
        'ruls' => [
            'title' => 'Праваі'
        ],
        'phone' => [
            'title' => 'Телефон',
        ],
    ],
    /**
     * The editable fields
     */
    'edit_fields' => [
        'name' => [
            'type' => 'text',
            'title' => 'Імя'
        ],
        'surname' => [
            'type' => 'text',
            'title' => 'Прізвище'
        ],
        'email' => [
            'type' => 'text',
            'title' => 'Email'
        ],
        'password' => [
            'type' => 'password',
            'title' => 'Пароль',
        ],
        'phone' => [
            'type' => 'text',
            'title' => 'Телефон',
        ],
        'ruls' => [
            'type' => 'text',
            'title' => 'Права(0-користувач, 2-скрам мастер, 1-адмін)'
        ],
    ],
    /**
     * The filter fields
     *
     * @type array
     */
    'filters' => [
        'id',
        'name' => [
            'title' => 'Имя',
        ],
        'email' => [
            'title' => 'Email',
        ],
    ],
];