<?php
return [
    'title' => 'Тренеры',
    'single' => 'тренера',
    'model' => 'App\Trener',
    /**
     * The display columns
     */
    'columns' => [
        'name' => [
            'title' => 'Имя'
        ],
        'room' => [
            'title' => 'Дорожка',
            'output' => function ($value){
                if($value == 'room-1'){
                    return "Дорожка 1";
                }
                if($value == 'room-2'){
                    return "Дорожка 2";
                }
                if($value == 'room-3'){
                    return "Дорожка 3";
                }
                if($value == 'room-4'){
                    return "Дорожка 4";
                }
            }
        ],
        'phone' => [
            'title' => 'Телефон',
        ],
        'graf' => [
            'title' => 'Расписание',
        ]

    ],
    /**
     * The editable fields
     */
    'edit_fields' => [

        'room' => [
            'title' => 'Дорожка',
            'type' => 'text',
        ],
        'name' => [
            'title' => 'Имя',
            'type' => 'text',
        ],
        'phone' => [
            'title' => 'Телефон',
            'type' => 'text',
        ],
        'graf_time' => [
            'title' => 'Гравик четный',
            'type' => 'bool',
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
        'phone' => [
            'title' => 'Телефон',
        ],
        'room' => [
            'title' => 'Дорожка',
        ],

    ],

];