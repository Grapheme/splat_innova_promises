<?php

return array(

    'fields' => function($dicval = NULL) {

        return array(
            'author_id' => array(
                'title' => 'ID юзера, на которого подписались',
                'type' => 'text',
            ),
        );
    },

    #/*
    'second_line_modifier' => function($line, $dic, $dicval) {

        #$dics = Config::get('temp.index_dics');
        #Helper::tad($dics);
        #$dic_products = $dics['products'];

        return '';
    },
    #*/

);