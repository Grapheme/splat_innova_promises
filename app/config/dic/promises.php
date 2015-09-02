<?php

return array(

    /*
    'fields_i18n' => function() {

    },
    */

    'fields' => function($dicval) {

        /**
         * Предзагружаем нужные словари с данными, по системному имени словаря, для дальнейшего использования.
         * Делается это одним SQL-запросом, для снижения нагрузки на сервер БД.
         */
        /*
        $dics_slugs = array(
            'users',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);
        */
        $user = Dic::valueBySlugAndId('users', $dicval->user_id);

        return array(
            /*
            'user_id' => array(
                'title' => 'Пользователь',
                'type' => 'select',
                'values' => $lists['users'], ## Используется предзагруженный словарь
            ),
            */
            'user_id' => array(
                'title' => 'ID пользователя (не изменять!)',
                'type' => 'text',
                #'first_note' => 'Не менять! Имя не показывается из соображений оптимизации.',
                'second_note' => $user->name
                                 . ' - <a href="' . URL::route('entity.edit', ['users', $user->id]) . '">изменить</a>'
                                 . ' / <a href="' . URL::route('app.profile_id', [$user->id]) . '" target="_blank">профиль</a>'
                ,
            ),
            'promise_text' => array(
                'title' => 'Текст обещания',
                'type' => 'textarea',
            ),
            'style_id' => array(
                'title' => 'Стиль оформления',
                'type' => 'text',
            ),
            'only_for_me' => array(
                'no_label' => true,
                'title' => 'Обещание видно только автору',
                'type' => 'checkbox',
                'label_class' => 'normal_checkbox',
            ),
            'time_limit' => array(
                'title' => 'Крайнее время выполнения обещания',
                'type' => 'text',
            ),
            /*
            'date_finish' => array(
                'title' => 'Крайняя дата выполнения обещания (dd.mm.yyyy)',
                'type' => 'date',
                'others' => array(
                    'class' => 'text-center',
                    'style' => 'width: 221px',
                    'placeholder' => 'Нажмите для выбора'
                ),
                'handler' => function($value) {
                    return $value ? @date('Y-m-d', strtotime($value)) : $value;
                },
                'value_modifier' => function($value) {
                    return $value ? date('d.m.Y', strtotime($value)) : date('d.m.Y');
                },
            ),
            */
            'finished_at' => array(
                'title' => 'Обещание выполнено (дата/время)',
                'type' => 'text',
            ),
            'promise_fail' => array(
                'no_label' => true,
                'title' => 'Обещание не выполнено',
                'type' => 'checkbox',
                'label_class' => 'normal_checkbox',
            ),

            'promise_report' => array(
                'title' => 'Отчет об обещании',
                'type' => 'textarea',
            ),
            #/*
            'promise_of_the_week' => array(
                'no_label' => true,
                'title' => 'Обещание недели',
                'type' => 'checkbox',
                'label_class' => 'normal_checkbox',
            ),
            'mainpage' => array(
                'no_label' => true,
                'title' => 'Выводить на главной',
                'type' => 'checkbox',
                'label_class' => 'normal_checkbox',
            ),
            #*/

            'promise_friends_ids' => array(
                'title' => 'IDs друзей, которым дано обещание',
                'type' => 'textarea',
            ),
            'promise_friends_emails' => array(
                'title' => 'E-mail\' друзей, которым дано обещание',
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

            $dicvals = DicVal::extracts($dicvals, null, true, true);
            #Helper::ta($dicvals);
            $user_ids = [];
            foreach ($dicvals as $dicval) {
                $user_ids[] = $dicval->user_id;
            }
            $user_ids = array_unique($user_ids);

            $users = Dic::valuesBySlugAndIds('users', $user_ids, true);
            #Helper::tad($users);
            Config::set('temp.users', $users);

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

        /**
         * Вызывается в методе postStore, после создания или обновления записи
         */
        'after_store_update' => function ($dic, $dicval) {
            if ($dicval->promise_of_the_week)
                DicFieldVal::where('key', 'promise_of_the_week')->where('dicval_id', '!=', $dicval->id)->update(['value' => 0]);
        },

        /**
         * Вызывается в конце метода destroy, после удаления записи словаря
         */
        'after_destroy' => function ($dic, $dicval) {

            @unlink(public_path('uploads/cards/' . $dicval->id . '.jpg'));
        },

    ),

    #/*
    'second_line_modifier' => function($line, $dic, $dicval) {

        $line = '';
        if ($dicval->only_for_me)
            $line .= '<i class="fa fa-eye-slash txt-color-red"></i> &nbsp;&nbsp;';
        else
            $line .= '<i class="fa fa-eye txt-color-green"></i> &nbsp;&nbsp;';

        $users = Config::get('temp.users');
        if (isset($users[$dicval->user_id]) && is_object($users[$dicval->user_id]))
            $line .= $users[$dicval->user_id]->name;

        return $line;
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
);