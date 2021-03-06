<?php

return array(

    /*
    'fields_i18n' => function() {

    },
    */

    'fields' => function($dicval = NULL) {

        /**
         * Предзагружаем нужные словари с данными, по системному имени словаря, для дальнейшего использования.
         * Делается это одним SQL-запросом, для снижения нагрузки на сервер БД.
         */
        /*
        $dics_slugs = array(
            'users',
            'promises',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        */
        $user = Dic::valueBySlugAndId('users', is_object($dicval) ? $dicval->user_id : NULL);
        $promise = Dic::valueBySlugAndId('promises', is_object($dicval) ? $dicval->promise_id : NULL);

        #Helper::d($user);
        #Helper::d($promise);

        #Helper::ta($dicval);
        #Helper::dd($lists);

        return array(
            'promise_id' => array(
                'title' => 'Обещание',
                'type' => 'textline',
                'view_text' => !@$promise->name ? '[ обещание не найдено ]' : '<a href="' . URL::route('app.promise', is_object($dicval) ? $dicval->promise_id : NULL) . '" target="_blank">' . @$promise->name . '</a>', ## Используется предзагруженный словарь
            ),
            'user_id' => array(
                'title' => 'Пользователь',
                'type' => 'textline',
                'view_text' => !@$user->name ? '[ пользователь не найден ]' : '<a href="' . URL::route('app.profile_id', is_object($dicval) ? $dicval->user_id : NULL) . '" target="_blank">' . @$user->name . '</a>', ## Используется предзагруженный словарь
            ),
            'comment_text' => array(
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
            #*/

            $dicvals_ids = Dic::makeLists($dicvals, NULL, 'id');
            #Config::set('temp.elements_ids', $dicvals_ids);
            $textfields = DicTextFieldVal::where('key', 'comment_text')
                ->whereIn('dicval_id', $dicvals_ids)
                ->get()
            ;
            $comment_texts = array();
            if (count($textfields)) {
                $comment_texts = Dic::makeLists($textfields, NULL, 'value', 'dicval_id');
            }
            Config::set('temp.comment_texts', $comment_texts);
            #Helper::ta($comment_texts);
        },

    ),

    #/*
    'first_line_modifier' => function($line, $dic, $dicval) {

        $comment_texts = Config::get('temp.comment_texts');
        $cut_text = mb_substr(@$comment_texts[$dicval->id], 0, 50);
        return $cut_text . (mb_strlen($cut_text) < mb_strlen($dicval->comment_text) ? '...' : '');
    },
    #*/

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