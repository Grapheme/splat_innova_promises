<?php

return array(

    'fields' => function() {

        return array(
            'dp' => array(
                'title' => 'Дательный падеж (Москве)',
                'type' => 'text',
            ),
        );
    },


    'second_line_modifier' => function($line, $dic, $dicval) {

        return '';
    },


    'seo' => 0,
);