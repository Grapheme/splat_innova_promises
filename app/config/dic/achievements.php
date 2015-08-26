<?php

return array(

    'fields' => function() {

        return array(
            'desc' => array(
                'title' => 'Текст ачивки',
                'type' => 'textarea',
            ),
            'count' => array(
                'title' => 'Количество обещаний',
                'type' => 'text',
            ),
            'status' => array(
                'title' => 'Статус обещаний',
                'type' => 'select',
                'values' => ['success' => 'Выполненные', 'fail' => 'Проваленные'],
            ),
            'mode' => array(
                'title' => 'Режим',
                'type' => 'select',
                'values' => ['total' => 'Суммарно', 'row' => 'Подряд'],
            ),
        );
    },

    'seo' => 0,
);