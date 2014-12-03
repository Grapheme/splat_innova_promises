<?php

return array(

    /*
    'fields_i18n' => function() {

    },
    */

    'fields' => function() {

        /**
         * Предзагружаем нужные словари с данными, по системному имени словаря, для дальнейшего использования.
         * Делается это одним SQL-запросом, для снижения нагрузки на сервер БД.
         */
        $dics_slugs = array(
            'users',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);

        return array(
            'user_id' => array(
                'title' => 'Пользователь',
                'type' => 'select',
                'values' => $lists['users'], ## Используется предзагруженный словарь
            ),
            'promise_text' => array(
                'title' => 'Текст комментария',
                'type' => 'textarea',
            ),
        );
    },

    /*
     * HOOKS - набор функций-замыканий, которые вызываются в некоторых местах кода модуля словарей, для выполнения нужных действий.
     */
    'hooks' => array(

        /**
         * Вызывается в методе index, перед выводом данных в представление (вьюшку).
         * На этом этапе уже известны все элементы, которые будут отображены на странице.
         */
        'before_index_view' => function ($dic, $dicvals) {
            /**
             * Предзагружаем нужные словари
             */

            /*
            $dics_slugs = array(
                'users',
            );
            $dics = Dic::whereIn('slug', $dics_slugs)->get();
            $dics = Dic::modifyKeys($dics, 'slug');
            #Helper::tad($dics);
            Config::set('temp.index_dics', $dics);
            */
        },

    ),

    #/*
    'second_line_modifier' => function($line, $dic, $dicval) {

        #$dics = Config::get('temp.index_dics');
        #Helper::tad($dics);
        #$dic_products = $dics['products'];

        return '';
    },
    #*/

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

    /**
     * Скрыть Название с формы
     * По умолчанию название отображается
     */
    'hide_name' => 1,


);