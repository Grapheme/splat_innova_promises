<?php

return array(

    'fields' => function() {

        return array(
            'desc' => array(
                'title' => 'Текст ачивки',
                'type' => 'textarea',
            ),
            'image' => array(
                'title' => 'Иконка',
                'type' => 'image',
                'params' => array(
                    'maxFilesize' => 1, // MB
                    #'acceptedFiles' => 'image/*',
                    #'maxFiles' => 2,
                ),
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