<?php

return array(

    /*
    'fields_i18n' => function() {

    },
    */

    'fields' => function() {

        return array(
            'auth_method' => array(
                'title' => 'Метод авторизации',
                'type' => 'text',
                'default' => '',
            ),
            'identity' => array(
                'title' => 'Идентификатор пользователя (внутри соц.сети, или почта)',
                'type' => 'text',
                'default' => '',
            ),
            'email' => array(
                'title' => 'email',
                'type' => 'text',
                'default' => '',
            ),
            'password' => array(
                'title' => 'Хеш пароля (если пользователь регистрировался не через соц.сеть)',
                'type' => 'textline',
            ),
            'bdate' => array(
                'title' => 'Дата рождения',
                'type' => 'text',
                'default' => '',
            ),
            'city' => array(
                'title' => 'Город',
                'type' => 'text',
                'default' => '',
            ),
            'avatar' => array(
                'title' => 'Фотография пользователя',
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
            'notifications' => array(
                'title' => 'Настройки уведомлений пользователя',
                'type' => 'text',
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

    /**
     * HOOKS - набор функций-замыканий, которые вызываются в некоторых местах кода модуля словарей, для выполнения нужных действий.
     */
    'hooks' => array(

        /**
         * Вызывается первым из всех хуков в каждом действенном методе модуля
         */
        'before_all' => function ($dic) {
        },

        /**
         * Вызывается в самом начале метода index, после хука before_all
         */
        'before_index' => function ($dic) {
        },

        /**
         * Вызывается в методе index, перед выводом данных в представление (вьюшку).
         * На этом этапе уже известны все элементы, которые будут отображены на странице.
         */
        'before_index_view' => function ($dic, $dicvals) {
        },

        /**
         * Вызывается в самом начале методов create и edit
         */
        'before_create_edit' => function ($dic) {
        },

        /**
         * Вызывается в начале метода create, сразу после хука before_create_edit
         */
        'before_create' => function ($dic) {
        },

        /**
         * Вызывается в начале метода edit, сразу после хука before_create_edit
         */
        'before_edit' => function ($dic, $dicval) {
        },

        /**
         * Вызывается в самом начале методов store и update
         */
        'before_store_update' => function ($dic) {
        },

        /**
         * Вызывается в начале метода postStore, сразу после хука before_store_update
         */
        'before_store' => function ($dic) {
        },

        /**
         * Вызывается в метода postStore, после создания записи
         */
        'after_store' => function ($dic, $dicval) {
        },

        /**
         * Вызывается в начале метода postStore, сразу после хука before_store_update
         */
        'before_update' => function ($dic, $dicval) {
        },

        /**
         * Вызывается в метода postStore, после обновления записи
         */
        'after_update' => function ($dic, $dicval) {
        },

        /**
         * Вызывается в начале метода destroy
         */
        'before_destroy' => function ($dic, $dicval) {
        },

        /**
         * Вызывается в конце метода destroy, после удаления записи словаря
         */
        'after_destroy' => function ($dic, $dicval) {

            $user = $dicval;
            $user_promises = Dic::valuesBySlug('promises', function($query) use ($user) {
                $query->join_field('user_id', 'user_id', function($join, $value) use ($user) {
                    $join->where($value, '=', $user->id);
                });
            });
            foreach ($user_promises as $promise) {
                $promise->delete();
            }

        },

    ),

    'seo' => 0,

    'versions' => 0,

    'first_line_modifier' => function($line, $dic, $dicval) {

        $prefix = '';
        if ($dicval->auth_method == 'facebook') {
            $prefix = '<i class="fa fa-facebook-square" style="color:#8498BD"></i>';
        } elseif ($dicval->auth_method == 'vkontakte') {
            $prefix = '<i class="fa fa-vk" style="color:#8EA7C9"></i>';
        } elseif ($dicval->auth_method == 'odnoklassniki') {
            $prefix = '<i class="fa fa-dribbble" style="color:#F5B57B"></i>';
        } elseif ($dicval->auth_method == 'native') {
            $prefix = '<i class="fa fa-envelope-o" style="color:#34B60F"></i>';
        }

        #Helper::d($line);

        #/*
        if (trim($line) == '') {
            #$line = $dicval->email;
            $line = 'без имени';
        }
        #*/

        return $prefix . ' ' . $line;
    },

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