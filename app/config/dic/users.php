<?php

return array(

    /*
    'fields_i18n' => function() {

    },
    */

    'fields' => function() {

        return array(
            'identity' => array(
                'title' => 'Ссылка на профиль в соц.сети',
                'type' => 'text',
                'default' => '',
            ),
            'friends' => array(
                'title' => 'Полная информация о друзьях',
                'type' => 'textarea',
                'default' => '',
            ),
            'full_social_info' => array(
                'title' => 'Полная информация о пользователе',
                'type' => 'textarea',
                'default' => '',
            ),
            'user_token' => array(
                'title' => 'Токен безопасности',
                'type' => 'text',
                'default' => '',
            ),
            'user_last_action_time' => array(
                'title' => 'Метка времени последней активности',
                'type' => 'text',
                'default' => '',
            ),
        );
    },

    'seo' => 0,

    'versions' => 0,

    /*
    'group_actions' => array(
        'moderator' => function() {
            return array(
                'dicval_create' => 0,
            );
        },

    ),
    */
);