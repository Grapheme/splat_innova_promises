<?php

return array(

    'fields' => function() {

        return array(
            'dp' => array(
                'title' => 'Дательный падеж (Москве)',
                'type' => 'text',
            ),
            'aliases' => array(
                'title' => 'Синонимы (по одному на строку)',
                'type' => 'textarea',
            ),
        );
    },


    'second_line_modifier' => function($line, $dic, $dicval) {

        return '';
    },


    'seo' => 0,
);