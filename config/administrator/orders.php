<?php
return [
    'title' => 'Заказы',
    'single' => 'заказ',
    'model' => 'App\Order',
    /**
     * The display columns
     */
    'columns' => [
        'type' => [
            'title' => 'Тип',
            'output' => function ($value){
                if($value == 'child'){
                    return "Детский";
                }
                if($value == 'adult'){
                    return "Взрослый";
                }
            }
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
        'id' => [
            'title' => 'Время и дати бронирования',
            'output' => function ($value){
                $time = DB::select('select * from times where order_id = '. $value);

                $strTime = "";
                foreach ($time as $val) {
                    $strTime = $strTime . date('Y-m-d: H ', $val->time) . "-" . date('H', strtotime("+1 hour", $val->time)) . "<br>";
                }
                return $strTime;
            }
        ],
        'name' => [
            'title' => 'Имя'
        ],
        'email' => [
            'title' => 'Email'
        ],
        'description' => [
            'title' => 'Примечания'
        ],
        'phone' => [
            'title' => 'Телефон',
        ],
        'card_number' => [
            'title' => 'Абонимент'
        ],
        'total_summ' => [
            'title' => 'Сумма к оплате'
        ],

        'is_paid' => [
            'title' => 'Оплачено',
            'output' => function ($value){
                if ($value == 1){
                    return "Да";
                } else {
                    return "Нет";
                }

            }
        ],
        'trener_name' => [
            'title' => 'Тренер'
        ],
    ],
    /**
     * The editable fields
     */
    'edit_fields' => [
        'user_id' => [
            'title' => 'Позльзователь',
            'type' => 'text',
        ],
        'type' => [
            'title' => 'Тип',
            'type' => 'text',
        ],
        'room' => [
            'title' => 'Дорожка',
            'type' => 'text',
        ],
        'name' => [
            'title' => 'Имя',
            'type' => 'text',
        ],
        'email' => [
            'title' => 'email',
            'type' => 'text',
        ],
        'description' => [
            'title' => 'Примечание',
            'type' => 'text',
        ],
        'phone' => [
            'title' => 'Телефон',
            'type' => 'text',
        ],
        'card_number' => [
            'title' => 'Абонимент',
            'type' => 'text',
        ],
        'total_summ' => [
            'title' => 'Сумма к оплате',
            'type' => 'text',
        ],
        'is_paid' => [
            'title' => 'Оплачено',
            'type' => 'bool',
        ],
        'type2' => [
            'title' => 'Тип'
        ],
        'trener_name' => [
            'title' => 'Тренер'
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
        'Email' => [
            'title' => 'Email',
        ],
        'is_paid' => [
            'title' => 'Оплачено',
            'type' => 'bool'
        ],
        'card_number' => [
            'title' => 'Абонимент',
        ],
    ],

];