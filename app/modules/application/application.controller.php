<?php

class ApplicationController extends BaseController {

    public static $name = 'application';
    public static $group = 'application';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        Route::group(array(), function() {

            Route::get('/', array('as' => 'app.mainpage', 'uses' => __CLASS__.'@getAppMainPage'));
            Route::get('/me', array('as' => 'app.me', 'uses' => __CLASS__.'@getMePage'));
            Route::get('/about', array('as' => 'app.about', 'uses' => __CLASS__.'@getAboutPage'));

            Route::get('/vk-oauth', array('as' => 'app.vk-oauth', 'uses' => __CLASS__.'@getVkOauth'));
            Route::get('/fb-oauth', array('as' => 'app.fb-oauth', 'uses' => __CLASS__.'@getFbOauth'));
            Route::get('/ok-oauth', array('as' => 'app.ok-oauth', 'uses' => __CLASS__.'@getOkOauth'));
            Route::any('/email-pass-auth', array('as' => 'app.email-pass-auth', 'uses' => __CLASS__.'@postEmailPassAuth'));

            Route::any('/user-logout', array('as' => 'app.user-logout', 'uses' => __CLASS__.'@postUserLogout'));

            Route::get('/get-mainpage-counter', array('as' => 'app.mainpage_counter', 'uses' => __CLASS__.'@getMainPageCounter'));

            Route::get('/profile', array('as' => 'app.profile', 'uses' => __CLASS__.'@getUserProfile'));
            Route::get('/new_promise', array('as' => 'app.new_promise', 'uses' => __CLASS__.'@getNewPromise'));

            Route::get('/restore_password', array('as' => 'app.restore_password', 'uses' => __CLASS__.'@getRestorePassword'));
            Route::any('/do_restore_password', array('as' => 'app.do_restore_password', 'uses' => __CLASS__.'@postDoRestorePassword'));
            Route::get('/restore_password_open_link', array('as' => 'app.restore_password_open_link', 'uses' => __CLASS__.'@getRestorePasswordOpenLink'));
            Route::any('/restore_password_set_new_password', array('as' => 'app.restore_password_set_new_password', 'uses' => __CLASS__.'@postRestorePasswordSetNewPassword'));

            Route::get('/profile/{id}', array('as' => 'app.profile_id', 'uses' => __CLASS__.'@getProfileByID'));
            Route::get('/invite/', array('as' => 'app.send_invite', 'uses' => __CLASS__.'@getSendInvite'));

            Route::get('/promise/{id}', array('as' => 'app.promise', 'uses' => __CLASS__.'@getPromise'));

            Route::any('/update_profile', array('as' => 'app.update_profile', 'uses' => __CLASS__.'@postUserUpdateProfile'));
            Route::any('/update_avatar', array('as' => 'app.update_avatar', 'uses' => __CLASS__.'@postUserUpdateAvatar'));
            Route::any('/send_invite_message', array('as' => 'app.send_invite_message', 'uses' => __CLASS__.'@postSendInviteMessage'));
            Route::any('/add_promise', array('as' => 'app.add_promise', 'uses' => __CLASS__.'@postAddPromise'));
            Route::any('/add_comment', array('as' => 'app.add_comment', 'uses' => __CLASS__.'@postAddComment'));

            Route::post('/user-auth', array('as' => 'app.user-auth', 'uses' => __CLASS__.'@postUserAuth'));
            Route::post('/user-update-friends', array('as' => 'app.user-update-friends', 'uses' => __CLASS__.'@postUserUpdateFriends'));


            Route::any('/ajax/vk-api/post-upload-image', array('as' => 'app.vk-api.post-upload', 'uses' => __CLASS__.'@postVkApiPostUpload'));


            #Route::any('/ajax/feedback', array('as' => 'ajax.feedback', 'uses' => __CLASS__.'@postFeedback'));
            #Route::any('/ajax/search', array('as' => 'ajax.search', 'uses' => __CLASS__.'@postSearch'));


            Route::get('/test/gen_image', array('as' => 'app.test.gen_image', 'uses' => __CLASS__.'@getTestGenImage'));

            Route::get('/sitemap', array('as' => 'app.sitemap', 'uses' => __CLASS__.'@getSitemap'));



            Route::post('/ajax/phone/checkPhone', array('as' => 'app.phone.check-phone', 'uses' => __CLASS__.'@postPhoneCheckPhone'));
            Route::post('/ajax/phone/sendSms', array('as' => 'app.phone.send-sms', 'uses' => __CLASS__.'@postPhoneSendSms'));
            Route::post('/ajax/phone/checkCode', array('as' => 'app.phone.check-code', 'uses' => __CLASS__.'@postPhoneCheckCode'));


            Route::any('/subscribe/{user_id}', array('as' => 'app.subscribe', 'uses' => __CLASS__.'@postSubscribe'));
            Route::any('/unsubscribe/{user_id}', array('as' => 'app.unsubscribe', 'uses' => __CLASS__.'@postUnubscribe'));


            Route::any('/cities', array('as' => 'app.cities', 'uses' => __CLASS__.'@getCities'));
            Route::any('/service/cities', array('as' => 'app.service.cities', 'uses' => __CLASS__.'@getServiceCities'));

            Route::any('/service/post', function(){

                $vk = new \VK\VK(Config::get('site.vk.app_id'), Config::get('site.vk.api_secret'), Config::get('site.vk.access_token'));

                $user1 = '@id' . 1889847;
                $user2 = '@id' . 2740015;
                $message = $user1 . ' оставил персональное обещание для ' . $user2 . ':' . "\n\n" . '«Я обещаю протестить постинг в ВК»';

                $result = $vk->api('wall.post', [
                    'owner_id' => Config::get('site.vk.owner_id'),
                    'message' => $message,
                ]);

                dd($result);

                /*
                $users = $vk->api('users.get', array(
                    'uids'   => '1234,4321',
                    'fields' => 'first_name,last_name,sex'));

                foreach ($users['response'] as $user) {
                    echo $user['first_name'] . ' ' . $user['last_name'] . ' (' . ($user['sex'] == 1 ? 'Girl' : 'Man') . ')<br />';
                }
                */
            });
        });



        Route::get('/statistika', array('as' => 'app.statistics', 'uses' => __CLASS__.'@getStatistics'));
        Route::get('/statistika/promises', array('as' => 'app.statistics_promises', 'uses' => __CLASS__.'@getStatisticsPromises'));
        Route::get('/statistika/promises/all', array('as' => 'app.statistics_promises_all', 'uses' => __CLASS__.'@getStatisticsPromisesAll'));


        Route::get('/how-it-works', array('as' => 'app.hiw', 'uses' => __CLASS__.'@getHiw'));


    }


    /****************************************************************************/


	public function __construct(){

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'tpl' => static::returnTpl(),
            'gtpl' => static::returnTpl(),
            'class' => __CLASS__,

            #'entity' => self::$entity,
            #'entity_name' => self::$entity_name,
        );
        View::share('module', $this->module);

        @session_start();

        #define('domain', 'http://splat.dev.grapheme.ru');

        $this->user = $this->auth();
        $this->promises = $this->get_promises();

        View::share('auth_user', $this->user);

        if (Input::get('debug')) {
            Helper::ta($this->user);
        }

        date_default_timezone_set("Europe/Moscow");
    }


    public function getAppMainPage() {

        /**
         * Всего обещаний дано
         */
        #$dic_promises = Dic::where('slug', 'promises')->first();
        #$total_promises = DicVal::where('dic_id', $dic_promises->id)->count();

        /**
         * Всего выполненных обещаний
         */
        $finished_promises = DicFieldVal::where('key', 'finished_at')->where('value', '>', 0)->count();

        if ($finished_promises < 1800)
            $finished_promises += 1800;

        /**
         * Карточки обещаний для главной
         */
        $mainpage_promises = [];
        $user_ids = [];
        $cities = [];
        $cities_promises_counts = [];
        $promises_comments_count = [];
        #$ids = (array)Config::get('site.mainpage_promises');
        $ids = [];

        /**
         * 26.08.2015
         * Обещание недели - одно, выводится перед всеми другими обещаниями для главной
         * + сделать чекбокс в админке "выводить на главной"
         * + поменять получение этих IDs (из БД, сейчас из конфига, стр.137) + случайный порядок
         * + добавить хук: обещание недели должно быть только одно
         */

        ## IDs обещаний для главной
        $mainpage_promises = DicFieldVal::where('key', 'mainpage')->where('value', '1')->get();
        if (isset($mainpage_promises) && is_object($mainpage_promises) && $mainpage_promises->count()) {
            foreach ($mainpage_promises as $mainpage_promise) {
                $ids[] = $mainpage_promise->dicval_id;
            }
            if (count($ids))
                shuffle($ids);
        }

        ## ID обещания недели
        $promise_of_the_week = DicFieldVal::where('key', 'promise_of_the_week')->where('value', '1')->first();
        if (isset($promise_of_the_week) && is_object($promise_of_the_week) && $promise_of_the_week->dicval_id)
            array_unshift($ids, $promise_of_the_week->dicval_id);

        /**
         * Если есть IDs карточек для вывода на главной...
         */
        if (count($ids)) {

            /**
             * Берем все эти обещания
             */
            $mainpage_promises = Dic::valuesBySlug('promises', function($query) use ($ids) {
                #$query->whereIn(DB::raw('`dictionary_values`.`id`'), $ids);
                $query->whereIn(DB::raw('`dictionary_values`.`id`'), $ids);
                #$query->order_by_field('promise_of_the_week', 'DESC');
                $query->orderBy(DB::raw('FIELD(`dictionary_values`.`id`, ' . implode(', ', $ids) . ')'));
            });
            if (Input::get('dbg-potw')) {

                Helper::smartQueries(1);
                Helper::tad($mainpage_promises);
                die;
            }
            $mainpage_promises = DicVal::extracts($mainpage_promises, null, 1, 1);

            if (count($mainpage_promises)) {

                /**
                 * Берем IDs пользователей, давших эти обещания
                 */
                $user_ids = Dic::makeLists($mainpage_promises, NULL, 'user_id');

                if (count($user_ids)) {

                    /**
                     * Получаем этих пользователей
                     */
                    $users = Dic::valuesBySlug('users', function($query) use ($user_ids) {
                        $query->whereIn('id', $user_ids);
                    });
                    $users = DicVal::extracts($users, null, 1, 1);

                    if (count($users)) {

                        /**
                         * Получаем города пользователей, давших эти обещания. С учетом автозамены "мск" => "Москва", и прочих
                         */

                        $mainpage_promises_city_aliases = (array)Config::get('site.mainpage_promises_city_aliases');

                        foreach ($users as $u => $user) {
                            #$city = mb_strtolower($user->city);
                            if (isset($mainpage_promises_city_aliases[mb_strtolower(trim($user->city))])) {
                                $city = $mainpage_promises_city_aliases[mb_strtolower(trim($user->city))];
                                $user->city = $city;
                                $users[$u] = $user;
                            }
                            $cities[] = $user->city;
                        }
                    }
                }
            }
        }

        /**
         * Если есть список городов, для которых нужно получить кол-во обещаний...
         */
        if (count($cities)) {

            $cities = array_unique($cities);

            /**
             * Получим всех пользователей из нужных городов
             */
            $promises_cities_users = Dic::valuesBySlug('users', function($query) use ($cities) {
                $rand_tbl_alias = $query->leftJoin_field('city', 'city');
                $query->whereIn($rand_tbl_alias.'.value', $cities);
            });
            $promises_cities_users = DicVal::extracts($promises_cities_users, null, true, true);

            /**
             * Получим IDs всех пользователей
             */
            $promises_cities_users_ids = [];
            if (count($promises_cities_users)) {

                $promises_cities_users_ids = Dic::makeLists($promises_cities_users, null, 'id');
                $promises_cities_users_ids = array_unique($promises_cities_users_ids);

                if (count($promises_cities_users_ids)) {

                    /**
                     * Получим все обещания, данные всеми пользователями из списка городов
                     */
                    $promises_cities = Dic::valuesBySlug('promises', function($query) use ($promises_cities_users_ids) {
                        $rand_tbl_alias = $query->leftJoin_field('user_id', 'user_id');
                        $query->whereIn($rand_tbl_alias.'.value', $promises_cities_users_ids);
                    });
                    $promises_cities = DicVal::extracts($promises_cities, null, true, true);

                    if (count($promises_cities)) {

                        /**
                         * Посчитаем кол-во обещаний для каждого города. Пиздец.
                         */
                        $cities_promises_counts = [];
                        foreach ($promises_cities as $promise_city) {
                            $user = @$promises_cities_users[$promise_city->user_id];

                            $city = mb_strtolower(trim($user->city));

                            if (isset($mainpage_promises_city_aliases[mb_strtolower(trim($user->city))])) {
                                $city = $mainpage_promises_city_aliases[mb_strtolower(trim($user->city))];
                                #$user->city = $city;
                                #$users[$u] = $user;
                            }

                            if (!$user || !$city)
                                continue;

                            @++$cities_promises_counts[$city];
                        }
                    }
                }
            }

        }


        /**
         * Получаем комментарии для каждого обещания на главной
         */
        if (count($ids)) {

            $comments = Dic::valuesBySlug('comments', function($query) use ($ids) {
                $rand_tbl_alias = $query->leftJoin_field('promise_id', 'promise_id');
                $query->whereIn($rand_tbl_alias.'.value', $ids);
            });
            $comments = DicVal::extracts($comments, null, true, true);
            if (count($comments)) {
                foreach ($comments as $comment) {
                    @$promises_comments_count[$comment->promise_id]++;
                }
            }
        }


        if (Input::get('debug_mainpage')) {
            /*
            Helper::ta($mainpage_promises);
            Helper::ta($user_ids);
            Helper::ta($users);
            Helper::ta($cities);
            Helper::ta($promises_cities_users);
            Helper::ta($promises_cities_users_ids);
            #Helper::ta($promises_cities);
            Helper::ta($cities_promises_counts);
            */
            Helper::ta($comments);
            Helper::tad($promises_comments_count);

            Helper::smartQueries(1);
            die;
        }

        $mainpage_promises_innova = (array)Config::get('site.mainpage_promises_innova');
        $mainpage_promises_city_aliases = (array)Config::get('site.mainpage_promises_city_aliases');

        return View::make(Helper::layout('index'), compact('user', 'promises', 'finished_promises', 'mainpage_promises', 'users', 'mainpage_promises_innova', 'mainpage_promises_city_aliases', 'cities_promises_counts', 'promises_comments_count'));
    }


    public function getMePage() {

        $this->check_auth(URL::route('app.mainpage'));

        /*
        if (isset($_GET['promise_text']) && $_GET['promise_text'] == '') {
            return Redirect::route('app.me');
        }
        */
        $promise_text = trim(Input::get('promise_text'));
        if ($promise_text !== NULL && $promise_text != '') {
            $_SESSION['promise_text'] = $promise_text;
            $_SESSION['redirect_to_new_promise'] = 1;
        }

        /**
         * Если есть пометка о том, что юзер новый - переадресовываем на страницу редактирования профиля
         */
        if (@$_SESSION['new_user']) {
            return Redirect::route('app.profile');
        }

        /**
         * Если в сессии есть непустой текст обещания (введен перед авторизацией) -
         * перенаправляем пользователя на страницу дачи обещания.
         */
        if (@$_SESSION['promise_text'] && @$_SESSION['redirect_to_new_promise']) {
            unset($_SESSION['redirect_to_new_promise']);
            if ($_SESSION['promise_text'] == 'undefined') {
                unset($_SESSION['promise_text']);
            }
            return Redirect::route('app.new_promise');
        }

        /**
         * Авторизованный пользователь
         */
        $user = $this->user;
        #Helper::tad($user);

        /**
         * Получаем обещания юзера
         */
        $promises = $this->promises;
        #Helper::tad($promises);

        /**
         * Разделим обещания на активные и неактуальные
         */
        $active_promises = array();
        $inactive_promises = array();
        if (count($promises)) {
            foreach ($promises as $p => $promise) {

                $failed = !$promise->finished_at && ($promise->promise_fail || date('Y-m-d H:i:s') > $promise->time_limit);

                if ($failed || $promise->finished_at)
                    $inactive_promises[$p] = $promise;
                else
                    $active_promises[$p] = $promise;
            }
        }

        /**
         * Определим, какие друзья пользователя уже зареганы в системе
         */
        #$existing_friends = array();
        #$non_existing_friends = array();
        #Helper::d('Count user friends: ' . count($user->friends));

        $count_user_friends = 0;
        if (count($user->friends)) {

            $user = $this->processFriends($user);
            #Helper::tad($user);

            $count_user_friends = @count($user->existing_friends) + @count($user->non_existing_friends);

            $friends_uids = array();
            $existing_friends_list = array();

            if (isset($user->friends) && is_array($user->friends) && count($user->friends)) {

                foreach ($user->friends as $friend) {
                    $friend_id = @$friend['uid'] ?: @$friend['id'];
                    $friend_uid = 'http://vk.com/id' . $friend_id;
                    $friends_uids[] = $friend_uid;
                }
                #$friends_uids[] = 'http://vk.com/id1889847';

                #Helper::ta($friends_uids);

                $dic = Dic::where('slug', 'users')->first();
                $existing_friends = DicFieldVal::where('key', 'identity')
                    ->whereIn('value', $friends_uids)
                    ->get()
                ;
                #Helper::ta($existing_friends);

                $existing_friends_list = Dic::makeLists($existing_friends, null, 'value');
                #Helper::tad($existing_friends_list);
            }

        }

        /**
         * Получаем ачивки пользователя
         */
        $achievements = $this->get_achievements($promises);

        /**
         * Получаем участников, на которых подписался пользователь
         */
        $subscribed_friends = new Collection();
        $subscribes = Dic::valuesBySlug('subscribes', function($query) use ($user) {
            $query->where('name', $user->id);
        });
        $subscribes = DicVal::extracts($subscribes, null, true, true);
        if (isset($subscribes) && is_object($subscribes) && $subscribes->count()) {
            #echo '<!--'; Helper::ta($subscribes); echo '-->';
            $subscribed_friends_ids = [];
            foreach ($subscribes as $subscribe) {
                $subscribed_friends_ids[] = $subscribe->author_id;
            }
            $subscribed_friends_ids = array_unique($subscribed_friends_ids);
            if (count($subscribed_friends_ids)) {
                $subscribed_friends = Dic::valuesBySlug('users', function($query) use ($subscribed_friends_ids) {
                    $query->whereIn('id', $subscribed_friends_ids);
                });
                $subscribed_friends = DicVal::extracts($subscribed_friends, null, true, true);
                foreach ($subscribed_friends as $s => $subscribed_friend) {
                    $subscribed_friend = $this->extract_user($subscribed_friend);
                    $subscribed_friends[$s] = $subscribed_friend;
                }
                #echo '<!--'; Helper::ta($subscribed_friends); echo '-->';
            }
        }


        /**
         * Показываем главную страницу юзера
         */
        return View::make(Helper::layout('index_user'), compact('user', 'promises', 'active_promises', 'inactive_promises', 'subscribed_friends', 'existing_friends_list', 'count_user_friends', 'achievements'));
    }


    private function processFriends($user) {

        if (!isset($user->friends) || !$user->friends || !count($user->friends))
            return $user;

        $existing_friends = array();
        $non_existing_friends = array();

        #Helper::ta($user);

        switch ($user->auth_method) {

            case "vkontakte":

                /**
                 * Ключи массива друзей => полный адрес их страницы
                 */
                $array = $user->friends;
                $friends_uids = array();
                foreach ($array as $f => $friend) {
                    $friend['_name'] = $friend['first_name'] . ' ' . @$friend['last_name'];
                    $friend['avatar'] = @$friend['photo_200'];
                    #$friend['sex'] = @$friend['sex'];
                    $friend_ident = 'http://vk.com/id' . $friend['id'];
                    $array[$friend_ident] = $friend;
                    unset($array[$f]);
                    $friends_uids[] = $friend_ident;
                }
                $user->friends = $array;
                #Helper::ta($user->friends);

                /**
                 * Получаем список друзей, которые уже есть в системе
                 */
                #Helper::ta($friends_uids);

                if (count($friends_uids)) {

                    #$dic = Dic::where('slug', 'users')->first();
                    $existing_friends_temp = DicFieldVal::where('key', 'identity')
                        ->whereIn('value', $friends_uids)
                        ->get()
                    ;
                    #Helper::ta($existing_friends_temp);

                    if (count($existing_friends_temp)) {

                        $existing_friends_temp->load('dicval.fields');
                        #Helper::ta($existing_friends_temp);
                        $existing_friends_temp = DicVal::extracts($existing_friends_temp, 'dicval', true);
                        #Helper::tad($existing_friends_temp);

                        $existing_friends_list = Dic::makeLists($existing_friends_temp, null, 'dicval_id', 'value');
                        #Helper::tad($existing_friends_list);
                        $existing_friends_avatars = Dic::makeLists($existing_friends_temp, 'dicval', 'avatar', 'id', true);
                        #Helper::tad($existing_friends_avatars);

                        /**
                         * Фильтруем друзей юзера
                         */
                        $array = $user->friends;
                        foreach ($existing_friends_list as $friend_url => $profile_id) {
                            #Helper::d($friend_url);
                            if (!isset($array[$friend_url]))
                                continue;
                            $friend = $array[$friend_url];
                            /**
                             * Сопоставляем установивших приложение друзей и ID профиля в системе
                             */
                            $friend['profile_id'] = $profile_id;
                            /**
                             * Установим актуальный аватар юзера
                             */
                            $friend['avatar'] = @$existing_friends_avatars[$profile_id];

                            $existing_friends[$friend_url] = $friend;
                            unset($array[$friend_url]);
                        }
                        $user->friends = $array;

                    }

                }


                $non_existing_friends = $user->friends;

                #Helper::tad($existing_friends);
                #Helper::tad($non_existing_friends);

                break;

            case "odnoklassniki":

                /**
                 * Ключи массива друзей => полный адрес их страницы
                 */
                $array = $user->friends;
                $friends_uids = array();
                foreach ($array as $f => $friend) {
                    if (!is_array($friend) || !count($friend))
                        continue;

                    $friend['_name'] = @$friend['first_name'] . ' ' . @$friend['last_name'];
                    $friend['avatar'] = @$friend['pic_3'];
                    $friend_ident = 'http://ok.ru/profile/' . $friend['uid'];
                    $array[$friend_ident] = $friend;
                    unset($array[$f]);
                    $friends_uids[] = $friend_ident;
                }
                $user->friends = $array;
                #Helper::ta($user->friends);

                /**
                 * Получаем список друзей, которые уже есть в системе
                 */
                #Helper::ta($friends_uids);

                if (count($friends_uids)) {

                    #$dic = Dic::where('slug', 'users')->first();
                    $existing_friends_temp = DicFieldVal::where('key', 'identity')
                        ->whereIn('value', $friends_uids)
                        ->get()
                    ;
                    #Helper::ta($existing_friends_temp);

                    if (count($existing_friends_temp)) {

                        $existing_friends_list = Dic::makeLists($existing_friends_temp, null, 'dicval_id', 'value');
                        #Helper::ta($existing_friends_list);

                        /**
                         * Фильтруем друзей юзера
                         */
                        $array = $user->friends;
                        foreach ($existing_friends_list as $friend_url => $profile_id) {
                            #Helper::d($friend_url);
                            if (!isset($array[$friend_url]))
                                continue;
                            $friend = $array[$friend_url];
                            /**
                             * Сопоставляем установивших приложение друзей и ID профиля в системе
                             */
                            $friend['profile_id'] = $profile_id;
                            $existing_friends[$friend_url] = $friend;
                            unset($array[$friend_url]);
                        }
                        $user->friends = $array;

                    }

                }

                $non_existing_friends = $user->friends;

                #Helper::tad($existing_friends);
                #Helper::tad($non_existing_friends);

                break;

            case "facebook":

                /**
                 * taggable_friends - все друзья юзера
                 * + name
                 * + picture
                 * friends - друзья юзера, установившие наше приложение
                 * + name
                 * + facebook id
                 */

                #Helper::tad($user);

                /**
                 * Установившие
                 */
                $friends = @(array)$user->friends['friends'];
                $existing_friends_names = array();
                $friends_uids = array();
                $existing_friends_list = array();

                /**
                 * Если есть друзья, установившие приложение...
                 */
                if (count($friends)) {
                    foreach ($friends as $f => $friend) {
                        #$friend['identity'] = 'https://www.facebook.com/profile.php?id=' . $friend['id'];
                        $friend['identity'] = @$friend['link'];
                        $friend['_name'] = @$friend['name'];
                        $friend['avatar'] = @$friend['picture']['data']['url'];
                        $friend['sex'] = @mb_strtolower($friend['gender']) == 'мужской' ? 2 : 1;
                        $friends[$f] = $friend;
                        $existing_friends_names[] = $friend['_name'];
                        $friends_uids[] = $friend['identity'];
                    }
                    #Helper::ta($friends_uids);
                    $existing_friends = $friends;

                    if (count($friends_uids)) {
                        $existing_friends_temp = DicFieldVal::where('key', 'identity')
                            ->whereIn('value', $friends_uids)
                            ->get()
                        ;
                        #Helper::ta($existing_friends_temp);

                        /**
                         * Здесь может понадобится доп. проверка на принадлежность записей словарю users
                         */

                        $existing_friends_list = Dic::makeLists($existing_friends_temp, null, 'dicval_id', 'value');
                        #Helper::ta($existing_friends_list);
                    }
                }

                /**
                 * Сопоставляем установивших приложение друзей и ID профиля в системе
                 */
                if (count($existing_friends)) {
                    $friends = $existing_friends;
                    foreach ($friends as $f => $friend) {
                        $profile_id = @$existing_friends_list[$friend['identity']];
                        if (!$profile_id)
                            continue;
                        $friend['profile_id'] = $profile_id;
                        $friends[$f] = $friend;
                    }
                    $existing_friends = $friends;
                    #Helper::tad($existing_friends);
                }


                /**
                 * Все
                 */
                $friends = @(array)$user->friends['taggable_friends'];
                foreach ($friends as $f => $friend) {
                    #$friend['identity'] = 'https://www.facebook.com/profile.php?id=' . $friend['id'];
                    $friend['_name'] = $friend['name'];
                    $friend['avatar'] = @$friend['picture']['data']['url'];

                    if (in_array($friend['_name'], $existing_friends_names)) {
                        unset($friends[$f]);
                        continue;
                    }
                    $friends[$f] = $friend;
                }
                $non_existing_friends = $friends;

                break;

            case "email":
            default:
                #echo "Это Арбуз";
                break;
        }

        $user->existing_friends = $existing_friends;
        $user->non_existing_friends = $non_existing_friends;

        return $user;
    }

    public function getUserProfile() {

        $this->check_auth();

        $user = $this->user;
        $msg = false;
        $new_user = false;

        if (@$_SESSION['new_user']) {
            $msg = @$_SESSION['new_user'];
            $new_user = true;
            unset($_SESSION['new_user']);
        }

        return View::make(Helper::layout('profile'), compact('user', 'msg', 'new_user'));
    }


    public function postSubscribe($user_id) {

        $this->check_auth();
        $user = $this->user;

        if (!$user)
            return Redirect::back();

        $temp = Dic::valuesBySlug('subscribes', function($query) use ($user_id) {
            $query->where('name', $this->user->id);
            $query->filter_by_field('author_id', '=', $user_id);
        });

        if (isset($temp) && is_object($temp) && $temp->count()) {

            ##

        } else {

            DicVal::inject('subscribes', [
                'slug' => NULL,
                'name' => $user->id,
                'fields' => array(
                    'author_id' => $user_id,
                ),
            ]);
        }

        return Redirect::back();
    }

    public function postUnubscribe($user_id) {

        $this->check_auth();
        $user = $this->user;

        if (!$user)
            return Redirect::back();

        $temp = Dic::valuesBySlug('subscribes', function($query) use ($user_id) {
            $query->where('name', $this->user->id);
            $query->filter_by_field('author_id', '=', $user_id);
        });
        if (isset($temp) && is_object($temp) && $temp->count()) {
            foreach ($temp as $tmp) {

                $tmp->remove_field('author_id');
                $tmp->delete();
            }
        }

        return Redirect::back();
    }


    public function getCities() {

        $default_city_name = 'Москва';
        $default_city = null;

        $current_city = Input::get('city') ?: $default_city_name;

        $cities = Dic::valuesBySlug('cities');
        if (isset($cities) && is_object($cities) && $cities->count()) {
            foreach($cities as $c => $city) {
                $city = $city->extract(true);

                if (!is_object($default_city) && $city->name == $default_city_name)
                    $default_city = $city;

                if (!is_object($current_city) && $current_city == $city->name)
                    $current_city = $city;

                $cities[$c] = $city;
            }
        }
        #Helper::tad($cities);
        #if (!is_object($current_city))
        #    $current_city = $default_city;


        $current_city_name = is_object($current_city) ? $current_city->name : $current_city;

        if (is_object($current_city)) {

            $current_city_name_filter = [$current_city->name];

            if (isset($current_city->aliases) && $current_city->aliases != '') {

                $temp = explode("\n", $current_city->aliases);
                foreach ($temp as $tmp) {
                    $tmp = trim($tmp);
                    if (!$tmp)
                        continue;

                    $current_city_name_filter[] = $tmp;
                }
            }

        } else {

            $current_city_name_filter = [$current_city];
        }


        $users_ids = [];
        $users = Dic::valuesBySlug('users', function($query) use ($current_city_name_filter) {
            #$query->filter_by_field('city', '=', $current_city_name);
            $query->filter_by_field('city', 'IN', $current_city_name_filter);
        });
        if (isset($users) && is_object($users) && $users->count()) {
            $temp = new Collection();
            foreach($users as $u => $user) {
                $user = $user->extract(true);
                $user = $this->extract_user($user);
                $temp[$user->id] = $user;
                $users_ids[] = $user->id;
            }
            $users = $temp;
        }
        #Helper::tad($users);

        $current_city_name = is_object($current_city) ? $current_city->name : $current_city;
        $current_city_dp = is_object($current_city) ? $current_city->dp : 'г.' . $current_city;

        $promises = new Collection();

        if (count($users_ids)) {

            $promises = Dic::valuesBySlug('promises', function($query) use ($users_ids) {
                $query->filter_by_field('user_id', 'IN', $users_ids);
                #$query->filter_by_field('only_for_me', '!=', '1'); ## не работает, будем делать костыль
            });
            if (isset($promises) && is_object($promises) && $promises->count()) {
                $temp = new Collection();
                foreach($promises as $p => $promise) {
                    $promise = $promise->extract(true);
                    if ($promise->only_for_me) {
                        #unset($promises[$p]);
                        continue;
                    }
                    $temp[] = $promise;
                }
                $promises = $temp;
            }
        }
        #Helper::ta($promises);
        #Helper::smartQueries(1);
        #die;

        return View::make(Helper::layout('cities'), compact('cities', 'current_city', 'current_city_name', 'current_city_dp', 'users', 'promises'));
    }


    public function getServiceCities() {

        $data = DicFieldVal::where('key', 'city')
            ->select([DB::raw('value AS city'), DB::raw('COUNT(*) AS count')])
            ->groupBy('value')
            ->orderBy(DB::raw('COUNT(*)'), 'DESC')
            ->get()
        ;

        Helper::error404();
        #Helper::tad($data);

        echo '<table border="1" cellspacing="0" cellpadding="5">
<thead><th>Город</th><th>Количество</th></thead>';
        foreach ($data as $dat) {
            echo '<tr><td>' . $dat->city . '</td><td>' . $dat->count . '</td></tr>';
        }
        echo '</table>';
    }


    public function postUserUpdateProfile() {

        $this->check_auth();

        $user = $this->user;

        $name = Input::get('name');
        $email = Input::get('email');
        $bdate = Input::get('bdate');
        $city = Input::get('city');

        $notifications = Input::get('notifications');
        #Helper::dd($notifications);

        if ($name) {
            #$user->name = $name;
            #Helper::tad($user);

            $dicval = DicVal::where('id', $user->id)->first();
            $dicval->name = $name;
            $dicval->save();
        }

        if ($email) {
            $user->update_field('email', $email);
        }

        if (@$bdate) {
            $user->update_field('bdate', $bdate);
        }

        if ($city) {
            $user->update_field('city', $city);
        }

        $user->update_field('notifications', json_encode($notifications));

        if (@$_SESSION['promise_text'] && @$_SESSION['redirect_to_new_promise']) {
            unset($_SESSION['redirect_to_new_promise']);
            return Redirect::route('app.new_promise');
        }

        return Redirect::route('app.me');
    }


    public function postUserUpdateAvatar() {

        $this->check_auth();

        #Helper::dd(Input::all());

        $json_request = array('status' => FALSE, 'responseText' => '');

        if (Input::hasFile('avatar')) {

            $file = Input::file('avatar');
            $path = 'uploads/avatar/';
            $destinationPath = public_path($path);
            $fileName = md5(time() . '.splat.' . rand(99999, 999999)) . '.' . $file->getClientOriginalExtension();
            $result = $file->move($destinationPath, $fileName);
            #Helper::dd($result);

            $new_avatar_path = '/' . $path . $fileName;

            $avatar = DicFieldVal::firstOrNew(array(
                'dicval_id' => $this->user->id,
                'key' => 'avatar',
            ));
            if ($avatar->value != '') {

                $old_avatar = public_path($avatar->value);
                if (@$old_avatar && @file_exists($old_avatar)) {
                    unlink($old_avatar);
                }
            }
            $avatar->value = $new_avatar_path;
            $avatar->save();

            $json_request['new_avatar'] = $new_avatar_path;
            $json_request['status'] = TRUE;
        }

        return Response::json($json_request, 200);
    }


    public function getNewPromise() {

        $this->check_auth();

        $user = $this->user;
        $user = $this->processFriends($user);
        #echo '<!--'; Helper::ta($user); echo '-->';
        $promises = $this->promises;

        return View::make(Helper::layout('new_promise'), compact('user', 'promises'));
    }


    public function postAddPromise() {

        $this->check_auth();

        #Helper::ta(Input::all());

        $promise_text = Input::get('promise_text');
        $limit_time = Input::get('limit_time');
        $limit_date = Input::get('limit_date');
        $only_for_me = Input::get('only_for_me');
        $style_id = Input::get('style_id');

        #if (!$promise_text || !$time_limit || $time_limit < 1)
        #    App::abort(404);

        /**
         * Старый формат
         */
        #$date_finish = (new \Carbon\Carbon())->now()->addDays($limit_date)->format('Y-m-d');
        $finish = (new \Carbon\Carbon())->createFromFormat('d.m.Y', $limit_date)->format('Y-m-d') . ' ' . $limit_time . ':00';

        #Helper::d($date_finish);

        /**
         * Обещание дано друзьям
         */
        $promise_friends_ids = '';
        $promise_friends_ids_array = Input::get('friends_ids');
        if (is_array($promise_friends_ids_array) && count($promise_friends_ids_array))
            $promise_friends_ids = implode(',', $promise_friends_ids_array);

        /**
         * Добавляем обещание
         */
        $promise = DicVal::inject(
            'promises',
            array(
                'slug' => NULL,
                'name' => mb_substr($promise_text, 0, 64) . (mb_strlen($promise_text) > 64 ? '...' : ''),
                'fields' => array(
                    'user_id' => $this->user->id,
                    'time_limit' => $finish,
                    'style_id' => $style_id,
                    'only_for_me' => $only_for_me ? 1 : NULL,
                    'finished_at' => ''
                ),
                'textfields' => array(
                    'promise_text' => $promise_text,
                    'promise_friends_ids' => $promise_friends_ids,
                    #'promise_friends_emails' => $promise_friends_emails, ## updated below
                ),
            )
        );

        $promise_friends_emails = [];
        $temp = Input::get('friends_emails');
        $temp = strtr($temp, [' ' => ',']);
        $temp_array = explode(',', $temp);
        if (count($temp_array)) {
            foreach ($temp_array as $t => $tmp) {
                $tmp = trim($tmp);
                if (!filter_var($tmp, FILTER_VALIDATE_EMAIL))
                    continue;
                $promise_friends_emails[$tmp] = 1;

                /**
                 * Отправляем на почту письмо с оповещением
                 */
                #/*
                $data = array(
                    'promise' => $promise,
                    'user' => $this->user,
                );
                Mail::send('emails.promise_from_friend', $data, function ($message) use ($promise, $tmp) {
                    $from_email = Config::get('mail.from.address');
                    $from_name = Config::get('mail.from.name');
                    $message->from($from_email, $from_name);
                    $message->subject('Вам дали обещание!');
                    $message->to($tmp);
                });
                #*/
            }
            $emails = array_keys($promise_friends_emails);
            if (count($emails)) {
                $promise_friends_emails = implode(',', $emails);
                $promise->update_textfield('promise_friends_emails', $promise_friends_emails);
            }
        }

        /**
         * Генерим картинку с текстом обещания для шеринга
         */
        $result = $this->genPromiseImage($promise->id, 'Я обещаю ' . trim($promise_text), $style_id, $this->user->avatar);
        $img_path = $result['path'];

        /**
         * Отправляем пост в ВК
         */
        if (isset($this->user) && is_object($this->user) && $this->user->auth_method == 'vkontakte' && is_array($promise_friends_ids_array) && count($promise_friends_ids_array) && 0) {

            $vk = new \VK\VK(Config::get('site.vk.app_id'), Config::get('site.vk.api_secret'), Config::get('site.vk.access_token'));
            $user1 = preg_replace('~[^\d]~', '', $this->user->identity);
            $user1 = '@id' . $user1;

            foreach ($promise_friends_ids_array as $promise_friend_id) {

                $user2 = '@id' . $promise_friend_id;
                $message = $user1 . ' оставил персональное обещание для ' . $user2 . ':' . "\n\n" . '«' . $promise_text . '»';

                $result = $vk->api('wall.post', [
                    'owner_id' => Config::get('site.vk.owner_id'),
                    'message' => $message,
                ]);
            }
        }

        /**
         * Отсылаем уведомление на почту
         */
        if (@$this->user->notifications['promise_status'] && filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {

            $data = array(
                'promise' => $promise,
                'img_path' => $img_path,
            );
            Mail::send('emails.promise_added', $data, function ($message) use ($promise) {
                $from_email = Config::get('mail.from.address');
                $from_name = Config::get('mail.from.name');
                $message->from($from_email, $from_name);
                $message->subject('Добавлено новое обещание');
                $message->to($this->user->email);
            });
        }

        /**
         * Очищаем сохраненный текст обещания в сессии
         */
        unset($_SESSION['promise_text']);

        /**
         * Ищем обещания, близкие по духу
         */
        $similar_promises = new Collection();
        $similar_promises_users = new Collection();
        $sphinx_match_mode = \Sphinx\SphinxClient::SPH_MATCH_ANY;
        $results['similar_promises'] = SphinxSearch::search($promise_text, 'splat_promises_index')
            ->setMatchMode($sphinx_match_mode)
            ->limit(30)
            ->query()
        ;
        $results_counts['similar_promises'] = @count($results['similar_promises']['matches']);
        #Helper::ta($results);

        if ($results_counts['similar_promises'] > 0) {

            $ids = array_keys($results['similar_promises']['matches']);
            $similar_promises = Dic::valuesBySlugAndIds('promises', $ids, true);
            if (isset($similar_promises) && is_object($similar_promises) && $similar_promises->count()) {
                $temp = new Collection();
                $similar_promises_users_ids = [];
                foreach ($similar_promises as $t => $tmp) {

                    $tmp = $tmp->extract(true);
                    if ($tmp->user_id == $this->user->id) {
                        continue;
                    }

                    $temp[$tmp->id] = $tmp;
                    $similar_promises_users_ids[] = $tmp->user_id;

                    if (count($temp) >= 3) {
                        break;
                    }
                }
                $similar_promises = $temp;

                if (count($similar_promises_users_ids)) {
                    $similar_promises_users = Dic::valuesBySlugAndIds('users', $similar_promises_users_ids, true);

                    if (isset($similar_promises_users) && is_object($similar_promises_users) && $similar_promises_users->count()) {
                        $temp = new Collection();
                        foreach ($similar_promises_users as $t => $tmp) {
                            $temp[$tmp->id] = $tmp->extract(true);
                        }
                        $similar_promises_users = $temp;
                    }
                }
            }
        }
        #Helper::ta($similar_promises);
        #Helper::tad($similar_promises_users);

        return Redirect::route('app.me', array(
                #'new_promise' => 1
            ))
            ->with('new_promise_id', $promise->id)
            ->with('similar_promises', $similar_promises)
            ->with('similar_promises_users', $similar_promises_users)
            ;
    }


    public function getPromise($id) {

        /*
        Helper::d('$_SESSION');
        Helper::d($_SESSION);

        Helper::d('$_COOKIE');
        Helper::d($_COOKIE);

        Helper::d('$user');
        $user = $this->user;
        Helper::tad($user);
        */

        #$this->check_auth();

        $user = $this->user;
        $promise = Dic::valueBySlugAndId('promises', $id);
        #Helper::tad($promise);

        if (!is_object($promise) || !$promise->id)
            App::abort(404);

        $promise->extract(1);
        #Helper::tad($promise);

        if ($promise->only_for_me && (!is_object($user) || $user->id != $promise->user_id) && Input::get('private') != md5(date('Y-m-d') . '_' . $promise->id))
            App::abort(404);

        /**
         * Если обещание давал авторизованный юзер...
         */
        if (is_object($user) && $user->id == $promise->user_id) {

            $promise_user = $user;

            /**
             * Если обещание не было помечено как проваленное и нет даты фактического выполнения
             */
            if (!$promise->promise_fail && !$promise->finished_at) {

                /**
                 * Тут еще нужна проверка - не закончилось ли время выполнения обещания?
                 */
                $promise_full_failed_time = (new \Carbon\Carbon())->createFromFormat('Y-m-d H:i:s', $promise->time_limit)->addHours(48)->format('Y-m-d H:i:s');
                $failed_finish_period =
                    !$promise->finished_at && !$promise->promise_fail
                    && date('Y-m-d H:i:s') > $promise->time_limit
                    && date('Y-m-d H:i:s') < $promise_full_failed_time
                ;
                #$can_finish = date('Y-m-d H:i:s') < $promise_full_failed_time;
                $can_finish = true; ## 25.08.2015 - Андрей Самойлов: менять статус можно всегда


                if (Input::get('fail')) {

                    $promise->update_field('promise_fail', 1);

                    if (@$this->user->notifications['promise_status'] && filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {

                        $data = array('promise' => $promise,);
                        Mail::send('emails.promise_fail', $data, function ($message) use ($promise) {
                            $from_email = Config::get('mail.from.address');
                            $from_name = Config::get('mail.from.name');
                            $message->from($from_email, $from_name);
                            $message->subject('Не удалось выполнить обещание');
                            $message->to($this->user->email);
                        });
                    }

                    return Redirect::route('app.promise', $id);

                } elseif (Input::get('finished') && $can_finish) {

                    $promise->update_field('finished_at', date('Y-m-d H:i:s'));

                    if (@$this->user->notifications['promise_status'] && filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {

                        $data = array('promise' => $promise,);
                        Mail::send('emails.promise_success', $data, function ($message) use ($promise) {
                            $from_email = Config::get('mail.from.address');
                            $from_name = Config::get('mail.from.name');
                            $message->from($from_email, $from_name);
                            $message->subject('Вы выполнили обещание!');
                            $message->to($this->user->email);
                        });
                    }

                    return Redirect::route('app.promise', $id);

                }

            }

            if (Input::get('delete')) {

                /**
                 * Вот тут не хватает API для удаления объектов
                 */
                #$promise->full_delete();
                $promise->delete();
                return Redirect::route('app.me');
            }

        } else {

            $promise_user = Dic::valueBySlugAndId('users', $promise->user_id);
            $promise_user->extract(1);
        }


        /**
         * Удаление комментария
         */
        if (Input::get('do') == 'delete_comment' && NULL !== ($comment_id = Input::get('id'))) {

            $comment = Dic::valueBySlugAndId('comments', $comment_id, true);
            #Helper::tad($comment);
            if (
                $comment->user_id == $promise_user->id
                || (is_object($user) && $user->id == $promise_user->id)
                || (is_object($user) && $user->id == $comment->user_id)
            ) {
                $comment->delete();
            }
            return Redirect::route('app.promise', $promise->id);
        }


        $comments = Dic::valuesBySlug('comments', function($query) use ($promise) {

            $tbl_alias_promise_id = $query->join_field('promise_id', 'promise_id', function($join, $value) use ($promise) {
                $join->where($value, '=', $promise->id);
            });
        });


        $users = NULL;

        if (count($comments)) {

            $comments = DicVal::extracts($comments, null, 1);

            $users_ids = Dic::makeLists($comments, NULL, 'user_id');

            if (count($users_ids)) {
                $users = Dic::valuesBySlugAndIds('users', $users_ids);
                $users = DicVal::extracts($users);
                $users = Dic::modifyKeys($users, 'id');
            }
        }


        #Helper::ta($comments);
        #Helper::ta($users_ids);
        #Helper::tad($users);
        #Helper::tad($promise);

        /**
         * Похожие обещания
         */
        $similar_promises = new Collection();
        $similar_promises_users = new Collection();
        $sphinx_match_mode = \Sphinx\SphinxClient::SPH_MATCH_ANY;
        $results['similar_promises'] = SphinxSearch::search($promise->promise_text, 'splat_promises_index')
            ->setMatchMode($sphinx_match_mode)
            ->limit(30)
            ->query()
        ;
        $results_counts['similar_promises'] = @count($results['similar_promises']['matches']);
        #Helper::ta($results);

        if ($results_counts['similar_promises'] > 0) {

            $ids = array_keys($results['similar_promises']['matches']);
            $similar_promises = Dic::valuesBySlugAndIds('promises', $ids, true);
            $similar_promises = DicVal::extracts($similar_promises, null, true, true);
            #echo '<!--'; Helper::ta($similar_promises); echo '-->';
            if (isset($similar_promises) && is_object($similar_promises) && $similar_promises->count()) {
                $temp = new Collection();
                $similar_promises_users_ids = [];
                foreach ($similar_promises as $t => $tmp) {

                    #$tmp = $tmp->extract(true);
                    if (
                        (is_object($this->user) && $tmp->user_id == $this->user->id)
                        || $tmp->only_for_me
                    ) {
                        continue;
                    }
                    #echo '<!--'; Helper::ta($tmp); echo '-->';

                    $temp[$tmp->id] = $tmp;
                    $similar_promises_users_ids[] = $tmp->user_id;

                    if (count($temp) >= 4) {
                        break;
                    }
                }
                $similar_promises = $temp;

                if (count($similar_promises_users_ids)) {
                    $similar_promises_users = Dic::valuesBySlugAndIds('users', $similar_promises_users_ids, true);

                    if (isset($similar_promises_users) && is_object($similar_promises_users) && $similar_promises_users->count()) {
                        $temp = new Collection();
                        foreach ($similar_promises_users as $t => $tmp) {
                            $temp[$tmp->id] = $tmp->extract(true);
                        }
                        $similar_promises_users = $temp;
                    }
                }
            }
        }
        #Helper::ta($similar_promises);
        #Helper::tad($similar_promises_users);

        return View::make(Helper::layout('promise'), compact('user', 'promise_user', 'promise', 'comments', 'users', 'similar_promises', 'similar_promises_users'));
    }



    public function postAddComment() {

        $this->check_auth();

        $promise_id = Input::get('promise_id');
        $user_id = $this->user->id;
        $comment_text = Input::get('comment_text');

        $promise = Dic::valueBySlugAndId('promises', $promise_id, true);

        if (!is_object($promise))
            App::abort(404);

        if ($comment_text) {

            $comment = DicVal::inject(
                'comments',
                array(
                    'slug' => NULL,
                    'name' => '',
                    'fields' => array(
                        'promise_id' => $promise_id,
                        'user_id' => $user_id,
                    ),
                    'textfields' => array(
                        'comment_text' => $comment_text,
                    ),
                )
            );

            if ($this->user->id != $promise->user_id) {

                $comment_user = Dic::valueBySlugAndId('users', $promise->user_id, true);

                if (@$this->user->notifications['new_comment'] && filter_var($comment_user->email, FILTER_VALIDATE_EMAIL)) {

                    $data = array('promise' => $promise, 'comment' => $comment, 'comment_user' => $comment_user,);
                    Mail::send('emails.comment_added', $data, function ($message) use ($promise, $comment_user) {
                        $from_email = Config::get('mail.from.address');
                        $from_name = Config::get('mail.from.name');
                        $message->from($from_email, $from_name);
                        $message->subject('Добавлен комментарий к Вашему обещанию');
                        $message->to($comment_user->email);
                    });
                }
            }
        }

        return Redirect::route('app.promise', $promise_id);
    }


    public function postUserAuth() {

        #Helper::dd(Input::all());

        $data = Input::get('data');

        /**
         * Если с авторизацией передан текст обещания - сохраняем его в сессию,
         * чтобы после авторизации сразу перейти на страницу дачи обещания.
         */
        $promise_text = Input::get('promise_text');
        if ($promise_text != '' && $promise_text != 'undefined') {
            $_SESSION['promise_text'] = $promise_text;
            $_SESSION['redirect_to_new_promise'] = 1;
        }

        ##Helper::dd($data);
        ##Helper::dd($token);

        if ($data !== NULL) {

            return $this->checkUserData($data);

        #} elseif ($token !== NULL) {
        #    $this->checkUserToken($token);
        }

    }

    private function checkUserData($data, $internal_request = false) {

        $user_id = NULL;

        $json_request = array('status' => FALSE, 'responseText' => '');

        if (is_array($data) && isset($data['identity']) && is_string($data['identity'])) {

            $users_dic = Dic::where('slug', 'users')->first();

            #$user_token = @$data['user_token'];
            #if (!$user_token)
                $user_token = md5(md5(time() . '_' . rand(999999, 9999999)));

            if (is_object($users_dic) && $users_dic->id) {

                $temp = DicFieldVal::firstOrNew(array(
                    'key' => 'identity',
                    'value' => $data['identity']
                ));

                #Helper::ta($temp);

                $user_record = NULL;
                if ($temp->dicval_id) {

                    /**
                     * Идентификатор юзера найден в базе - пытаемся получить его
                     */
                    $array = array(
                        'id' => $temp->dicval_id,
                        'dic_id' => $users_dic->id
                    );

                    $user_record = DicVal::firstOrNew($array);
                    if ($user_record->id) {

                        /**
                         * Если пользователь авторизуется через почту/пароль - проверим последний
                         */
                        if ($data['auth_method'] == 'native') {

                            $user_record->load('fields');
                            $user_record->extract(1);

                            $password = md5('splat.' . $data['password']);

                            #Helper::d($data);
                            #Helper::ta($user_record);
                            #Helper::dd($password);

                            if ($user_record->password != $password) {
                                Redirect(URL::route('app.mainpage'));
                            }
                        }

                        unset($data['password']);

                        /**
                         * Обновляем данные пользователя в БД
                         */
                        $array = array(
                            'slug' => NULL,
                            'fields' => array(
                                'user_token' => $user_token,
                                'auth_method' => @$data['auth_method'],
                                'user_last_action_time' => time(),
                            ),
                            'textfields' => array(
                                'full_social_info' => json_encode($data),
                            ),
                        );
                        if ($data['auth_method'] != 'native') {
                            #$array['name'] = @$data['first_name'] . ' ' . @$data['last_name'];
                            #$array['bdate'] = @$data['bdate'];
                        }

                        $user_record = DicVal::refresh(
                            'users',
                            $user_record->id,
                            $array
                        );

                        #Helper::tad($user_record);

                        #$user_record->load('fields', 'textfields');
                        $user_record->extract(1);

                        #Helper::ta($user_record);

                        #$_SESSION['user_token'] = $user_record->user_token;
                        #setcookie('user_token', $user_record->user_token, time()+60*60+24+365, '/');
                        $this->setUserToken($user_record->user_token);

                        $json_request['responseText'] = 'Ok';
                        $json_request['new_user'] = false;
                        $json_request['user'] = ($user_record->toArray());
                        $json_request['status'] = TRUE;
                    }
                }

                if (!is_object($user_record)) {

                    /**
                     * Пользователь авторизуется в первый раз - добавим его
                     */
                    $array = array(
                        'slug' => NULL,
                        'name' => @$data['first_name'] . ' ' . @$data['last_name'],
                        'fields' => array(
                            'auth_method' => @$data['auth_method'],
                            'identity' => @$data['identity'],
                            'email' => @$data['email'],
                            'bdate' => @$data['bdate'],
                            'avatar' => @$data['avatar'],
                            #'user_token' => md5(md5(time() . '_' . rand(999999, 9999999))),
                            'user_token' => $user_token,
                            'user_last_action_time' => time(),
                        ),
                    );

                    if ($data['auth_method'] == 'native') {
                        $array['fields']['password'] = md5('splat.' . $data['password']);
                        $new_password = $data['password'];
                    }

                    unset($data['password']);

                    $array['textfields']['full_social_info'] = json_encode($data);

                    $user_record = DicVal::inject(
                        'users',
                        $array
                    );

                    $user_record->extract(1);

                    #Helper::tad($user_record);

                    #$_SESSION['user_token'] = $user_record->user_token;
                    $this->setUserToken($user_record->user_token);

                    $_SESSION['new_user'] = @$user_record->auth_method;

                    /**
                     * Если новый пользователь зарегистрировался через email/пароль - отправим ему на почту данные для входа
                     */
                    if ($data['auth_method'] == 'native' && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

                        $data['password'] = $new_password;

                        Mail::send('emails.user-register', $data, function ($message) use ($data) {

                            /*
                            $from_email = Dic::valueBySlugs('options', 'from_email');
                            $from_email = $from_email->name != '' ? $from_email->name : 'support@grapheme.ru';
                            $from_name = Dic::valueBySlugs('options', 'from_name');
                            $from_name = $from_name->name != '' ? $from_name->name : 'No-reply';
                            */
                            $from_email = Config::get('mail.from.address');
                            $from_name = Config::get('mail.from.name');

                            $message->from($from_email, $from_name);
                            $message->subject('Успешная регистрация');

                            $message->to($data['email']);
                        });
                    }

                    $json_request['responseText'] = 'Ok';
                    $json_request['new_user'] = true;
                    $json_request['user'] = ($user_record->toArray());
                    $json_request['status'] = TRUE;
                }

            }

        }

        #die;

        if ($internal_request)
            return $json_request;
        else
            return Response::json($json_request, 200);
    }


    public function postUserUpdateFriends() {

        #Helper::dd(Input::all());
        #Helper::dd(Input::get('friends'));

        $user_id = Input::get('user_id');
        $user_friends = Input::get('friends');

        $friends = DicTextFieldVal::firstOrNew(array(
            'dicval_id' => $user_id,
            'key' => 'friends'
        ));
        $friends->value = json_encode($user_friends);
        $friends->save();

        #Helper::d($user_friends);
        #Helper::d(json_encode($user_friends));
        #Helper::d($friends->value);

        return 1;
    }



    private function auth() {

        /*
        if (
            0
            || (isset($_COOKIE['user_token']) && (!isset($_SESSION['user_token']) || !$_SESSION['user_token']))
            || ((!isset($_COOKIE['user_token']) || !$_COOKIE['user_token']) && isset($_SESSION['user_token']))
            || (isset($_COOKIE['user_token']) && isset($_SESSION['user_token']) && $_COOKIE['user_token'] != $_SESSION['user_token'])
        ) {

            $this->userLogout(1);
            return NULL;

        }
        */

        if (!@$_SESSION['user_token'])
            return NULL;

        $user = NULL;

        $temp = DicFieldVal::firstOrNew(array(
            'key' => 'user_token',
            'value' => @$_SESSION['user_token']
        ));

        if ($temp->id) {

            $temp->load('dicval.fields', 'dicval.textfields');

            if (is_object($temp->dicval)) {

                $user = $temp->dicval;

                $user->extract(1);
                #$user->extract();

                #Helper::ta($user);
                #Helper::ta(json_decode(json_decode($user->friends, 1), 1));

                $user->full_social_info = json_decode($user->full_social_info, 1);
                $user->friends = json_decode($user->friends, 1);
                $user->notifications = json_decode($user->notifications, 1);

                #Helper::tad($user);


                $this->setUserToken($user->user_token);

                $user = $this->extract_user($user);

                #echo $stamp->format('d.m.Y');

                #Helper::ta($user);
            }
        }

        if (!is_object($temp) || !is_object($temp->dicval)) {

            $this->userLogout(1);
        }

        #Helper::tad($temp);

        return $user;
    }


    private function extract_user($user) {

        if (is_string($user->full_social_info))
            $user->full_social_info = json_decode($user->full_social_info, 1);

        $now = (new \Carbon\Carbon())->now();
        #echo $now->format('d.m.Y') . "<br/>";
        /**
         * Определение страны, города, пола и возраста
         */
        switch ($user->auth_method) {

            case "vkontakte":
                if (isset($user->full_social_info['country']) && isset($user->full_social_info['country']['title'])) {
                    $user->country = $user->full_social_info['country']['title'];
                }
                #if (isset($user->full_social_info['city']) && isset($user->full_social_info['city']['title'])) {
                #    $user->city = $user->full_social_info['city']['title'];
                #}
                if (isset($user->full_social_info['sex']) && $user->full_social_info['sex']) {
                    $user->sex = $user->full_social_info['sex'];
                }
                if (isset($user->bdate) && $user->bdate) {
                    if (preg_match('~\d{1,2}\.\d{1,2}\.\d{4}~is', $user->bdate)) {
                        $stamp = (new \Carbon\Carbon())->createFromFormat('d.m.Y', $user->bdate);
                        $user->years_old = $stamp->diffInYears($now);
                    }
                } elseif (isset($user->full_social_info['bdate']) && $user->full_social_info['bdate']) {
                    if (preg_match('~[12]{1}\d{3}\-\d{1,2}\-\d{1,2}~is', $user->full_social_info['bdate'])) {
                        $stamp = (new \Carbon\Carbon())->createFromFormat('Y-m-d', $user->full_social_info['bdate']);
                        $user->years_old = $stamp->diffInYears($now);
                    }
                }
                break;

            case "odnoklassniki":
                if (isset($user->full_social_info['gender']) && $user->full_social_info['gender']) {
                    $user->sex = $user->full_social_info['gender'] == 'male' ? 2 : 1;
                }
                if (isset($user->full_social_info['location']['countryName']) && isset($user->full_social_info['location']['countryName'])) {
                    $user->country = $user->full_social_info['location']['countryName'];
                }
                #if (isset($user->full_social_info['location']['city']) && isset($user->full_social_info['location']['city'])) {
                #    $user->city = $user->full_social_info['location']['city'];
                #}
                /*
                if (isset($user->full_social_info['age']) && $user->full_social_info['age']) {
                    $user->years_old = $user->full_social_info['age'];
                }
                */
                if (isset($user->bdate) && $user->bdate) {
                    if (preg_match('~\d{1,2}\.\d{1,2}\.\d{4}~is', $user->bdate)) {
                        $stamp = (new \Carbon\Carbon())->createFromFormat('d.m.Y', $user->bdate);
                        $user->years_old = $stamp->diffInYears($now);
                    }
                }
                break;

            case "facebook":
                if (isset($user->full_social_info['gender']) && $user->full_social_info['gender']) {
                    $user->sex = $user->full_social_info['gender'] == 'мужской' ? 2 : 1;
                }
                #if (isset($user->full_social_info['hometown']) && isset($user->full_social_info['hometown']['name'])) {
                #    $user->city = $user->full_social_info['hometown']['name'];
                #}
                if (isset($user->full_social_info['birthday']) && $user->full_social_info['birthday']) {
                    if (preg_match('~\d{2}\/\d{2}\/\d{4}~is', $user->full_social_info['birthday'])) {
                        $stamp = (new \Carbon\Carbon())->createFromFormat('m/d/Y', $user->full_social_info['birthday']);
                        $user->years_old = $stamp->diffInYears($now);
                    }
                }
                break;
        }

        return $user;
    }


    private function get_promises($user = NULL, $hide_private_promises = false) {

        if (!$user)
            $user = $this->user;

        $promises = NULL;

        if (is_object($user)) {

            $promises = Dic::valuesBySlug('promises', function($query) use ($user, $hide_private_promises) {

                $table = $user->getTable();
                $query->orderBy('created_at', 'DESC');

                ## Подключаем доп. поле с помощью JOIN (т.е. неподходящие под условия записи не будут добавлены к выборке)
                $tbl_alias_user_id = $query->join_field('user_id', 'user_id', function($join, $value) use ($user) {
                    $join->where($value, '=', $user->id);
                });

                if ($hide_private_promises) {

                    $tbl_alias_only_for_me = $query->leftJoin_field('only_for_me', 'only_for_me', function ($join, $value) use ($user) {
                        #$join->where($value, '=', NULL);
                    });

                    $query->where($tbl_alias_only_for_me.'.value', NULL);
                }

            });

            /*
            if ($hide_private_promises) {
                Helper::smartQueries(1);
                Helper::tad($promises);
                die;
            }
            #*/

            #Helper::tad($promises);

            /**
             * Посчитаем кол-во комментариев к каждому обещанию
             */
            #$comments_counts = array();
            if (count($promises)) {
                $promises = DicVal::extracts($promises, null, 1);

                $promises_ids = Dic::makeLists($promises, null, 'id');
                #Helper::d($promises_ids);

                $comments_counts = Dic::valuesBySlug('comments', function($query) use ($promises_ids) {

                    /**
                     * Подключаем значения promise_id
                     */
                    $tbl_alias_1 = $query->join_field('promise_id', 'promise_id', function ($join, $value) use ($promises_ids) {
                        #$join->where($value, '=', NULL);
                        #$join->whereIn($value, $promises_ids);
                    });
                    $query->whereIn($tbl_alias_1.'.value', $promises_ids);

                    $query->addSelect(DB::raw('COUNT(*) AS count'));
                    $query->groupBy('promise_id');
                });
                #Helper::smartQueries(1);

                $comments_counts = Dic::makeLists($comments_counts, null, 'count', 'promise_id');
                #Helper::tad($comments_counts);

                if (count($comments_counts)) {
                    foreach ($comments_counts as $promise_id => $comments_count) {
                        if (isset($promises[$promise_id])) {
                            $obj = $promises[$promise_id];
                            $obj->comments_count = $comments_count;
                            $promises[$promise_id] = $obj;
                        }
                    }
                }


            }

            #Helper::tad($promises);
        }

        return $promises;
    }


    /**
     * Получаем ачивки пользователя
     * @param $promises
     *
     * @return array
     */
    private function get_achievements($promises) {

        /**
         * Нужно посчитать количество выполненных и проваленных обещаний подряд и суммарно
         */
        $achievements = [];
        $max_success = 0;
        $max_fail = 0;
        $max_success_tmp = 0;
        $max_fail_tmp = 0;
        $total_success = 0;
        $total_fail = 0;
        foreach ($promises as $promise) {

            $status = $this->promise_status($promise);
            if ($status === true) {

                /**
                 * Обещание ВЫПОЛНЕНО
                 */
                ++$total_success;
                ++$max_success_tmp;
                if ($max_fail_tmp > $max_fail) {
                    $max_fail = $max_fail_tmp;
                }
                $max_fail_tmp = 0;

            } elseif ($status === false) {

                /**
                 * Обещание ПРОВАЛЕНО
                 */
                ++$total_fail;
                ++$max_fail_tmp;
                if ($max_success_tmp > $max_success) {
                    $max_success = $max_success_tmp;
                }
                $max_success_tmp = 0;
            }
        }
        $temp = compact('max_success', 'max_fail', 'total_success', 'total_fail');

        #echo "<!--\n" . print_r($temp, true) . "-->\n\n";


        #$all_ach = Config::get('site.achievements')
        $all_ach = Dic::valuesBySlug('achievements', function($query) {
            $query->orderBy('lft', 'ASC');
        });
        if (isset($all_ach) && is_object($all_ach) && $all_ach->count()) {
            foreach ($all_ach as $a => $ach) {
                $all_ach[$a] = $ach->extract(1);
            }
            $all_ach = DicLib::loadImages($all_ach, ['image']);
            #echo "<!--\n" . Helper::ta($all_ach, true) . "-->\n\n";

            /**
             * Перебираем все имеющиеся ачивки
             */
            foreach ($all_ach as $ach_key => $ach_data) {

                $ach_data2 = clone $ach_data;
                $ach_data = $ach_data->toArray();

                /**
                 * Определяем нужный счетчик, который будет использоваться для проверки есть ачивка или нет
                 */
                $count = 0;
                if ($ach_data['status'] == 'fail') {
                    if ($ach_data['mode'] == 'total') {
                        $count = $total_fail;
                    } elseif ($ach_data['mode'] == 'row') {
                        $count = $max_fail;
                    }
                } elseif ($ach_data['status'] == 'success') {
                    if ($ach_data['mode'] == 'total') {
                        $count = $total_success;
                    } elseif ($ach_data['mode'] == 'row') {
                        $count = $max_success;
                    }
                }

                #echo "<!--\nach: " . $ach_key . "\ncount: " . $count . "\n" . print_r($ach_data, true) . "\n-->\n\n";

                /**
                 * Если кол-во равно или больше указанного - добавляем ачивку
                 */
                if ($count >= $ach_data['count']) {

                    #$achievements[] = $ach_key;
                    $achievements[] = $ach_data2;
                }
            }
        }

        return $achievements;
    }


    /**
     * Определяем статус обещания
     * @param $promise
     *
     * @return bool|null
     */
    private function promise_status($promise) {

        $promise_status = null; ## В ПРОЦЕССЕ
        if ($promise->time_limit < date('Y-m-d H:i:s') && !$promise->finished_at)
            $promise_status = false; ## ПРОВАЛЕНО
        elseif ($promise->finished_at)
            $promise_status = true; ## ВЫПОЛНЕНО

        return $promise_status;
    }


    public function getOkOauth() {

        $HOST = $_SERVER['HTTP_HOST'];
        $AUTH['client_id'] = '1110811904';
        $AUTH['client_secret'] = '3AA5F4157946E5DED5F7544B';
        $AUTH['application_key'] = 'CBAGKGDDEBABABABA';

        if (!isset($_GET['code']) || !$_GET['code']) {

            echo "Не удается выполнить вход. Повторите попытку позднее (0).";
            die;

            #header('Location: http://www.odnoklassniki.ru/oauth/authorize?client_id=' . $AUTH['client_id'] . '&scope=VALUABLE ACCESS&response_type=code&redirect_uri=' . urlencode($HOST . 'auth.php?name=odnoklassniki'));
        }

        /**
         * Если с авторизацией передан текст обещания - сохраняем его в сессию,
         * чтобы после авторизации сразу перейти на страницу дачи обещания.
         */
        /*
        $promise_text = Input::get('promise_text');
        if ($promise_text != '') {
            $_SESSION['promise_text'] = $promise_text;
            $_SESSION['redirect_to_new_promise'] = 1;
        }
        */

        $postfields = 'code=' . $_GET['code'] .
            '&client_id=' . $AUTH['client_id'] .
            '&client_secret=' . $AUTH['client_secret'] .
            '&redirect_uri=' . URL::route('app.ok-oauth') . #'?promise_text=' . urlencode($promise_text) .
            '&grant_type=authorization_code'
        ;

        $curl = curl_init('https://api.odnoklassniki.ru/oauth/token.do');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);

        $auth = json_decode($s, true);
        #Helper::d($auth);

        if (!@$auth['access_token']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (1).";
            echo "<!--";
            Helper::d($postfields);
            Helper::d($auth);
            echo "-->";
            die;
        }

        /**
         * OK теперь отдают е-мейл (нужно было запрашивать у Ozhiganov Valery <valery.ozhiganov@corp.mail.ru>)
         */
        $curl = curl_init(
            'http://api.odnoklassniki.ru/fb.do?' .
            'access_token=' . $auth['access_token'] .
            '&application_key=' . $AUTH['application_key'] .
            '&fields=uid,first_name,last_name,location,gender,birthday,pic_3,email' .
            '&method=users.getCurrentUser' .
            '&sig=' . md5(
                'application_key=' . $AUTH['application_key'] .
                'fields=uid,first_name,last_name,location,gender,birthday,pic_3,email' .
                'method=users.getCurrentUser' .
                md5($auth['access_token'] . $AUTH['client_secret'])
            )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);
        $user = json_decode($s, true);
        #Helper::d($user);

        if (!@$user['uid']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (2).";
            echo "<!--\n";
            Helper::d($user);
            echo "-->\n";
            die;
        }

        $user['identity'] = 'http://ok.ru/profile/' . $user['uid'];
        if (@$user['birthday']) {
            $birthday = (new \Carbon\Carbon())->createFromFormat('Y-m-d', $user['birthday']);
            $user['bdate'] = $birthday->format('d.m.Y');
        }
        #$user['avatar'] = @$user['pic_3'];
        $user['avatar'] = ''; ## https://basecamp.com/1763145/projects/7571992/todos/202287061
        $user['city'] = @$user['location']['city'];
        $user['auth_method'] = 'odnoklassniki';

        $check = $this->checkUserData($user, true);
        #Helper::d($check);

        if (!@$check['user']['user_token']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (3).";
            die;
        }


        $friends_get_url = 'http://api.odnoklassniki.ru/fb.do?access_token=' . $auth['access_token']
            . '&application_key=' . $AUTH['application_key']
            . '&method=friends.get'
            #. '&uid=' . $user['uid']
            . '&sig=' . md5(
                'application_key=' . $AUTH['application_key']
                . 'method=friends.get'
                #. 'uid=' . $user['uid']
                . md5($auth['access_token'] . $AUTH['client_secret']));

        $curl = curl_init($friends_get_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $friends = curl_exec($curl);
        curl_close($curl);
        $friends = json_decode($friends, true);

        /**
         * + VALUABLE_ACCESS
         * http://apiok.ru/wiki/pages/viewpage.action?pageId=83034588
         * http://apiok.ru/wiki/pages/viewpage.action?pageId=81822097
         */
        #Helper::d($friends);


        if (count($friends)) {

            $friends_info_get_url = 'http://api.odnoklassniki.ru/fb.do?access_token=' . $auth['access_token']
                . '&application_key=' . $AUTH['application_key']
                . '&fields=uid,first_name,last_name,current_location,gender,pic_3'
                . '&method=users.getInfo'
                . '&uids=' . implode(',', $friends)
                . '&sig=' . md5(
                    'application_key=' . $AUTH['application_key']
                    . 'fields=uid,first_name,last_name,current_location,gender,pic_3'
                    . 'method=users.getInfo'
                    . 'uids=' . implode(',', $friends)
                    . md5($auth['access_token'] . $AUTH['client_secret']));

            $curl = curl_init($friends_info_get_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $user_friends = curl_exec($curl);
            curl_close($curl);
            $user_friends = json_decode($user_friends, true);

            #Helper::dd($user_friends);

            $friends = DicTextFieldVal::firstOrNew(array(
                'dicval_id' => $check['user']['id'],
                'key' => 'friends'
            ));
            $friends->value = json_encode($user_friends);
            $friends->save();
        }


        #setcookie("user_token", $check['user']['user_token'], time()+60*60+24+365, "/");


        echo "
        Авторизация прошла успешно, теперь это окно можно закрыть.
        <script>
        //opener.location = '" . URL::route('app.me', array('promise_text' => Input::get('promise_text'))) . "';
        opener.gotome();;
        window.close();
        </script>
        ";

        die;

        #header('Location: /'); // редиректим после авторизации на главную страницу

    }

    public function getVkOauth() {

        $code = Input::get('code');

        if (!$code) {
            echo "Не удается выполнить вход. Повторите попытку позднее (0).";
            die;
        }

        /**
         * Если с авторизацией передан текст обещания - сохраняем его в сессию,
         * чтобы после авторизации сразу перейти на страницу дачи обещания.
         */
        /*
        $promise_text = Input::get('promise_text');
        if ($promise_text != '') {
            $_SESSION['promise_text'] = $promise_text;
        }
        */

        $HOST = $_SERVER['HTTP_HOST'];

        $AUTH['app_id'] = '4659025';
        $AUTH['app_secret'] = 'kBoFXZ2zNmXuKZTu8IGA';

        $curl = curl_init('https://oauth.vk.com/access_token');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,
            'client_id=' . $AUTH['app_id'] .
            '&client_secret=' . $AUTH['app_secret'] .
            '&code=' . $code .
            '&redirect_uri=' . URL::route('app.vk-oauth')
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);

        $auth = json_decode($s, true);
        #Helper::d($auth);


        if (!@$auth['access_token'] || !@$auth['user_id']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (1).";
            echo "<!--";
            Helper::d($auth);
            echo "-->";
            die;
        }

        $url = 'https://api.vk.com/method/users.get?user_ids=' . @$auth['user_id'] . '&fields=email,sex,bdate,city,country,photo_200,domain&v=5.27&lang=ru';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);
        $user = json_decode($s, true);
        $user = $user['response'][0];

        $user['uid'] = @$user['id'];
        $user['avatar'] = @$user['photo_200'];
        $user['city'] = @$user['city']['title'];

        #Helper::d($url);
        #Helper::dd($user);

        if (!@$user['uid']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (2).";
            die;
        }

        /**
         * ВК отдает почту.
         * ВК может как отдавать дату рождения, так и не отдавать. Причем может отдавать только день и месяц (без ведущего нуля)
         * Приводим дату рождения к нужному формату
         */
        if (isset($user['bdate']) && strpos(@$user['bdate'], '.')) {
            $bdate = explode('.', $user['bdate']);
            $birthday = ((int)$bdate[0]<10 ? '0'.$bdate[0] : $bdate[0]) . '.' . ((int)$bdate[1]<10 ? '0'.$bdate[1] : $bdate[1]);
            if (isset($bdate[2]) && $bdate[2] != '')
                $birthday .= '.' . $bdate[2];
            else
                $birthday .= '.0000';
            $user['bdate'] = $birthday;
        }

        $user['identity'] = 'http://vk.com/id' . $user['uid'];
        $user['email'] = @$auth['email'];
        $user['auth_method'] = 'vkontakte';
        $user['user_token'] = $auth['access_token'];


        $check = $this->checkUserData($user, true);
        #Helper::d($check);

        if (!@$check['user']['user_token']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (3).";
            die;
        }


        #setcookie("user_token", $check['user']['user_token'], time()+60*60+24+365, "/");
        #setcookie("access_token", $auth['access_token'], time()+60*60*24*365, "/");
        #setcookie("user_token", $auth['access_token'], time()+60*60*24*365, "/");


        $curl = curl_init('https://api.vk.com/method/friends.get?user_id=' . @$auth['user_id'] . '&fields=sex,bdate,city,country,photo_200,domain&v=5.27&order=hints&lang=ru');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        #curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Language: ru-RU;q=1.0'));
        curl_close($curl);
        $user_friends = json_decode($s, true);
        $user_friends = @$user_friends['response']['items'];


        #Helper::dd($friends);


        $friends = DicTextFieldVal::firstOrNew(array(
            'dicval_id' => $check['user']['id'],
            'key' => 'friends'
        ));
        $friends->value = json_encode($user_friends);
        $friends->save();


        echo "
        Авторизация прошла успешно, теперь это окно можно закрыть.
        <script>
        //opener.location = '" . URL::route('app.me', array('promise_text' => Input::get('promise_text'))) . "';
        opener.gotome();;
        window.close();
        </script>
        ";

        die;

        #header('Location: /'); // редиректим после авторизации на главную страницу

    }


    public function getFbOauth() {

        $code = Input::get('code');

        if (!$code) {
            echo "Не удается выполнить вход. Повторите попытку позднее (0).";
            die;
        }

        /**
         * Если с авторизацией передан текст обещания - сохраняем его в сессию,
         * чтобы после авторизации сразу перейти на страницу дачи обещания.
         */
        /*
        $promise_text = Input::get('promise_text');
        if ($promise_text != '') {
            $_SESSION['promise_text'] = $promise_text;
        }
        */

        $AUTH['client_id'] = '1010986995584773';
        $AUTH['client_secret'] = '3997207bd2372a15b1fd87e461b242a2';

        /**
         * Получаем токен
         */
        $url = 'https://graph.facebook.com/oauth/access_token?'
            . 'client_id=' . $AUTH['client_id']
            . '&redirect_uri=' . URL::route('app.fb-oauth')
            . '&client_secret=' . $AUTH['client_secret']
            . '&code=' . $code
        ;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);

        preg_match("~^access_token=([^\&]+?)\&expires.+?$~is", $s, $matches);
        $access_token = @$matches[1] ?: NULL;

        /*
        Helper::d($url);
        Helper::d($s);
        Helper::d($matches);
        Helper::dd($access_token);
        */

        if (!@$access_token) {
            echo "Не удается выполнить вход. Повторите попытку позднее (1).";
            die;
        }

        /**
         * Получаем инфо о юзере
         */
        $curl = curl_init('https://graph.facebook.com/v2.2/me/?fields=id,name,birthday,gender,hometown,installed,verified,first_name,last_name,picture,link&locale=ru_RU&access_token=' . $access_token);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);
        $user = json_decode($s, true);

        /**
         * FB не отдает почту.
         * FB отдает дату рождения, но день и месяц поменяны местами
         * Приводим дату рождения к нужному формату
         */
        if (isset($user['birthday']) && strpos($user['birthday'], '/')) {
            $bdate = explode('/', $user['birthday']);
            $birthday = $bdate[1] . '.' . $bdate[0];
            if (isset($bdate[2]) && $bdate[2] != '')
                $birthday .= '.' . $bdate[2];
            else
                $birthday .= '.0000';
            $user['bdate'] = $birthday;
            #$user['bdate'] = @$user['birthday'];
        }

        $user['uid'] = @$user['id'];
        #Helper::dd($user);

        if (!@$user['uid']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (2).";
            die;
        }

        /**
         * Получаем большую картинку юзера - только для Facebook
         */
        $curl = curl_init('https://graph.facebook.com/v2.2/me/picture?redirect=false&type=large&access_token=' . $access_token);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);
        $avatar = json_decode($s, true);

        #Helper::dd($avatar);

        $user['picture'] = @$avatar;
        $user['avatar'] = @$avatar['data']['url'];
        $user['city'] = @$user['hometown']['name'];
        $user['identity'] = @$user['link'];
        $user['auth_method'] = 'facebook';

        $check = $this->checkUserData($user, true);
        #Helper::dd($check);

        if (!@$check['user']['user_token']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (3).";
            echo "<!--";
            echo '!$check[user][user_token]' . "\n";
            Helper::d($check);
            echo "-->";
            die;
        }

        /**
         * Получаем друзей юзера - friends & taggable_friends
         */
        $user_friends = array();

        /**
         * taggable_friends
         */
        $curl = curl_init('https://graph.facebook.com/v2.2/me/taggable_friends?locale=ru_RU&access_token=' . $access_token);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);
        $friends = json_decode($s, true);
        #Helper::dd($friends);

        $friends = @$friends['data'];
        $user_friends['taggable_friends'] = $friends;
        #Helper::dd($user_friends);

        /**
         * friends
         */
        $curl = curl_init('https://graph.facebook.com/v2.2/me/friends?fields=name,birthday,gender,hometown,first_name,last_name,picture,link&locale=ru_RU&access_token=' . $access_token);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);
        $friends = json_decode($s, true);
        #Helper::dd($friends);

        $friends = @$friends['data'];
        $user_friends['friends'] = $friends;
        #Helper::dd($user_friends);

        /**
         * Сохраняем друзей юзера
         */
        $friends = DicTextFieldVal::firstOrNew(array(
            'dicval_id' => $check['user']['id'],
            'key' => 'friends'
        ));
        $friends->value = json_encode($user_friends);
        $friends->save();


        #setcookie("user_token", $check['user']['user_token'], time()+60*60+24+365, "/");


        echo "
        Авторизация прошла успешно, теперь это окно можно закрыть.
        <script>
        //opener.location = '" . URL::route('app.me', array('promise_text' => Input::get('promise_text'))) . "';
        opener.gotome();;
        window.close();
        </script>
        ";

        die;

        #header('Location: /'); // редиректим после авторизации на главную страницу
    }



    public function getProfileByID($id) {

        #Helper::dd($id);

        if (isset($this->user) && is_object($this->user) && $this->user->id && $this->user->id == $id && !Input::get('debug')) {
            return Redirect::route('app.me');
        }

        $user = Dic::valueBySlugAndId('users', $id);
        #Helper::ta($user);

        /**
         * Если юзер не найден
         */
        if (!is_object($user) || !$user->id) {

            App::abort(404);
            #return View::make(Helper::layout('index'), compact('user', 'promises'));
        }

        $user->extract(1);

        $now = (new \Carbon\Carbon())->now();
        if (isset($user->bdate) && $user->bdate) {
            if (preg_match('~\d{2}\.\d{2}\.\d{4}~is', $user->bdate)) {
                $stamp = (new \Carbon\Carbon())->createFromFormat('d.m.Y', $user->bdate);
                $user->years_old = $stamp->diffInYears($now);
            }
        }

        /**
         * Получаем обещания юзера (только публичные)
         */
        $promises = $this->get_promises($user, true);

        /**
         * Получаем ачивки пользователя
         */
        $achievements = $this->get_achievements($promises);

        $subscribed = null;
        if ($this->user) {

            $subscribed = false;

            $temp = Dic::valuesBySlug('subscribes', function($query) use ($user) {
                $query->where('name', $this->user->id);
                $query->filter_by_field('author_id', '=', $user->id);
            });
            #Helper::smartQueries(1);
            #Helper::tad($temp);
            if (isset($temp) && is_object($temp) && $temp->count()) {
                $subscribed = true;
            }
        }

        /**
         * Показываем страницу профиля
         */
        return View::make(Helper::layout('profile_id'), compact('user', 'promises', 'achievements', 'subscribed'));
    }


    public function getSendInvite() {

        $this->check_auth();

        #$user = base64_decode($data);

        $user = Input::all();

        #$user_name = $data;

        #Helper::dd($data);
        return View::make(Helper::layout('send_invite'), compact('user'));
    }


    public function postSendInviteMessage() {

        /**
         * В зависимости от того, какой будет механика отправки запроса (аякс или native)...
         */
        #Helper::dd("Send msg...");

        $this->check_auth();

        $data = Input::all();

        if (!$data['email'])
            App::abort(404);

        $json_request = array('status' => FALSE, 'responseText' => '');

        $data['user'] = $this->user;

        #/*
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            Mail::send('emails.send-invite', $data, function ($message) use ($data) {

                $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                $message->subject($this->user->name . ' - Мои Обещания');

                #$email = Config::get('mail.feedback.address');

                $message->to($data['email']);
            });
        }
        #*/

        $json_request['status'] = TRUE;
        return Response::json($json_request, 200);
    }

    public function postEmailPassAuth() {

        #Helper::d(Input::all());

        /**
         * Если с авторизацией передан текст обещания - сохраняем его в сессию,
         * чтобы после авторизации сразу перейти на страницу дачи обещания.
         */
        $promise_text = Input::get('promise_text');
        if ($promise_text != '') {
            $_SESSION['promise_text'] = $promise_text;
        }

        $email = Input::get('email');
        $pass = Input::get('pass');

        if (!$email || !$pass) {
            App::abort(404);
        }

        $user['identity'] = $email;
        $user['email'] = $email;
        $user['password'] = $pass;
        $user['auth_method'] = 'native';

        $check = $this->checkUserData($user, true);
        #Helper::d($check);

        if (!@$check['user']['user_token']) {
            return Redirect::route('app.mainpage');
        }


        #setcookie("user_token", $check['user']['user_token'], time()+60*60+24+365, "/");


        if (NULL !== ($promise_text = Input::get('promise_text'))) {
            $_SESSION['promise_text'] = $promise_text;
            $_SESSION['redirect_to_new_promise'] = 1;
        }

        /**
         * Если есть пометка о том, что юзер новый - убираем ее и переадресовываем на страницу редактирования профиля
         */
        if (@$_SESSION['new_user']) {
            return Redirect::route('app.profile');
        }

        /**
         * Если в сессии есть непустой текст обещания (введен перед авторизацией) -
         * перенаправляем пользователя на страницу дачи обещания.
         */
        if (@$_SESSION['promise_text'] && @$_SESSION['redirect_to_new_promise']) {
            unset($_SESSION['redirect_to_new_promise']);
            if ($_SESSION['promise_text'] == 'undefined') {
                unset($_SESSION['promise_text']);
            }
            return Redirect::route('app.new_promise');
        }

        return Redirect::route('app.me');
    }


    public function getRestorePassword() {

        return View::make(Helper::layout('restore_password'), compact('user'));
    }

    public function postDoRestorePassword() {


        $json_request = array('status' => FALSE, 'responseText' => '');

        $email = Input::get('email');

        $user = Dic::valuesBySlug('users', function($query) use ($email) {

            $query->join_field('identity', 'identity', function($join, $value) use ($email) {
                $join->where($value, '=', $email);
            });
        });
        $user = @$user[0];

        #Helper::tad($user);

        if (!is_object($user) || !@$user->id) {

            if (Request::ajax()) {
                #$json_request['status'] = TRUE;
                $json_request['responseText'] = 'Пользователь не найден';
                return Response::json($json_request, 200);
            }

            return Redirect::route('app.restore_password')
                ->with('msg', 'Пользователь не найден')
                ;
        }

        #Helper::smartQueries(1);
        #Helper::tad($user);

        $user->extract(1);

        $token = md5('splat.' . $user->id . '.' . time());
        $user->update_field('restore_password_token', $token);


        if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {

            Mail::send('emails.restore_password_link_send', array('token' => $token), function ($message) use ($user) {

                /*
                $from_email = Dic::valueBySlugs('options', 'from_email');
                $from_email = $from_email->name != '' ? $from_email->name : 'support@grapheme.ru';
                $from_name = Dic::valueBySlugs('options', 'from_name');
                $from_name = $from_name->name != '' ? $from_name->name : 'No-reply';
                */

                $from_email = Config::get('mail.from.address');
                $from_name = Config::get('mail.from.name');

                $message->from($from_email, $from_name);
                $message->subject('Запрос на сброс пароля');

                $message->to($user->email);
            });
        }

        if (Request::ajax()) {
            $json_request['status'] = TRUE;
            $json_request['responseText'] = 'На Ваш адрес электронной почты отправлена ссылка для сброса пароля.';
            return Response::json($json_request, 200);
        }

        return View::make(Helper::layout('link_to_refresh_password_send'), compact('user'));
    }


    public function getRestorePasswordOpenLink() {

        $token = Input::get('token');

        $user = Dic::valuesBySlug('users', function($query) use ($token) {

            $query->join_field('restore_password_token', 'restore_password_token', function($join, $value) use ($token) {
                $join->where($value, '=', $token);
            });
        });
        $user = @$user[0];

        if (!is_object($user) || !@$user->id) {
            return View::make(Helper::layout('restore_password_user_not_found_by_token'), compact('user'));
        }

        #Helper::smartQueries(1);
        #Helper::tad($user);

        $user->extract(1);

        #Helper::tad($user);

        return View::make(Helper::layout('restore_password_set_new_password'), compact('user', 'token'));
    }

    public function postRestorePasswordSetNewPassword() {

        $password = Input::get('password');
        $token = Input::get('token');

        $user = Dic::valuesBySlug('users', function($query) use ($token) {

            $query->join_field('restore_password_token', 'restore_password_token', function($join, $value) use ($token) {
                $join->where($value, '=', $token);
            });
        });
        $user = @$user[0];

        if (!is_object($user) || !@$user->id) {
            return View::make(Helper::layout('restore_password_user_not_found_by_token'), compact('user'));
        }

        #Helper::smartQueries(1);
        #Helper::tad($user);

        $user->extract(1);
        #Helper::tad($user);


        $new_password_hash = md5('splat.' . $password);
        $user->update_field('password', $new_password_hash);
        $user->remove_field('restore_password_token');


        $this->postUserLogout();


        if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {

            Mail::send('emails.restore_password_success', array('password' => $password, 'user' => $user), function ($message) use ($user) {

                /*
                $from_email = Dic::valueBySlugs('options', 'from_email');
                $from_email = $from_email->name != '' ? $from_email->name : 'support@grapheme.ru';
                $from_name = Dic::valueBySlugs('options', 'from_name');
                $from_name = $from_name->name != '' ? $from_name->name : 'No-reply';
                */

                $from_email = Config::get('mail.from.address');
                $from_name = Config::get('mail.from.name');

                $message->from($from_email, $from_name);
                $message->subject('Пароль успешно изменен');

                $message->to($user->email);
            });
        }

        return View::make(Helper::layout('restore_password_success'), compact('user', 'token'));
    }

    private function check_auth($redirect = false) {

        $user = $this->user;
        if (!is_object($user) || !$user->id) {
            if ($redirect) {
                Redirect($redirect);
            } else {
                #App::abort(404);
                Redirect(URL::route('app.mainpage'));
            }
        }

        return true;
    }

    public function getMainPageCounter() {

        $finished_promises = DicFieldVal::where('key', 'finished_at')->where('value', '>', 0)->count();

        if ($finished_promises < 1800)
            $finished_promises += 1800;

        return $finished_promises;
    }


    public function postVkApiPostUpload() {

        $json_request = array('status' => FALSE, 'responseText' => '');

        $postfields = array(
            #'photo' => 'http://mypromises.ru/promise_card.jpg',
            #'photo' => file_get_contents(public_path('promise_card.jpg')),
            'photo' => '@' . public_path('promise_card.jpg'),
        );

        #Helper::dd($postfields);

        $url = Input::get('url');

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, 1);
        @curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);
        $answer = json_decode($s, true);

        $json_request['status'] = true;
        $json_request['answer'] = $answer;

        return Response::json($json_request, 200);
    }


    private function setUserToken($token, $time = 31536000) {

        #setcookie('user_token', $token, time()+$time, '/');
        $_SESSION['user_token'] = $token;
        return '1';
    }


    public function postUserLogout() {

        return $this->userLogout();
    }

    public function userLogout($log = false) {

        if ($log) {

            $log_line = ''
                . '_COOKIE[user_token] = ' . @$_COOKIE['user_token'] . "\n\n"
                . '_SESSION[user_token] = ' . @$_SESSION['user_token'] . "\n\n"
                . '_COOKIE\'s ' . "\n" . @print_r($_COOKIE, 1) . "\n\n"
                . '_SESSION\'s ' . "\n" . @print_r($_SESSION, 1) . "\n\n"
            ;

            file_put_contents(storage_path('logs/' . time() . '_' . rand(999999, 9999999)), $log_line);
        }

        setcookie('user_token', '', 0, '/');
        unset($_SESSION['user_token']);
        return '1';
    }


    public function getAboutPage() {

        return View::make(Helper::layout('about'), compact('token'));
    }


    public function getSitemap() {

        return View::make(Helper::layout('sitemap'), compact('token'));
    }


    public function getTestGenImage() {

        $promise_id = 1;
        $promise_text = 'Я обещаю скинуть 5кг или научусь любить себя с ними';
        $promise_type = 'blue';
        $avatar_path = public_path('uploads/avatar/ZZ0A4B96A6s.jpg');
        $dest_url = $this->genPromiseImage($promise_id, $promise_text, $promise_type, $avatar_path);
        $dest_url = $dest_url['url'];

        return '<img src="' . $dest_url . '" />';
    }

    private function genPromiseImage($promise_id, $promise_text, $promise_type, $avatar_path) {

        #$promise_text = 'Я обещаю скинуть 5кг или научусь любить себя с ними';
        $font_size = 30;
        $font_color = '#ffffff';

        ## Способ выравнивания текста
        #$align = "left";
        $align = "center";
        #$align = "right";

        ## Вывод отладочной информации при форматировании текста вместо изображения
        $debug_text_format = 0;

        $font_path = public_path('uploads/webfont.ttf');

        #$avatar_path = public_path('uploads/avatar/ZZ0A4B96A6s.jpg');
        #$avatar_path = 'http://cs408619.vk.me/v408619847/4806/ZZ0A4B96A6s.jpg';
        $avatar_path = trim($avatar_path);
        if (!$avatar_path || $avatar_path == '')
            $avatar_path = public_path('theme/images/man.png');
        elseif (mb_substr($avatar_path, 0, 4) != 'http')
            $avatar_path = public_path($avatar_path);
        elseif (!@file_get_contents($avatar_path))
            $avatar_path = public_path('theme/images/man.png');

        if (!isset($promise_type) || !$promise_type)
            $promise_type = 'blue';
        $source_path = public_path('uploads/card_' . $promise_type . '.jpg');

        $dest_url = 'uploads/cards/' . @(int)$promise_id . '.jpg';
        $dest_path = public_path($dest_url);
        $dest_url = '/' . $dest_url;

        /**
         * Подготавливаем аватар
         */
        $av_diameter = 140; // диаметр аватара
        $av_top_offset = 50; // отступ сверху
        $av_bottom_offset = 50; // отступ снизу

        /**
         * Создаем автар
         */
        $av_img = ImageManipulation::make($avatar_path);
        $av_width  = $av_img->width();
        $av_height = $av_img->height();
        /**
         * Ресайз аватара по меньшей стороне
         * Кроп середины аватара
         */
        if ($av_width >= $av_height) {

            ## Альбом
            $av_img->resize(null, $av_diameter, function ($constraint) {
                $constraint->aspectRatio();
            });
            $new_av_width = $av_img->width();
            $av_img->crop($av_diameter, $av_diameter, ceil(($new_av_width-$av_diameter)/2), 0);

        } else {

            ## Портрет
            $av_img->resize($av_diameter, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $new_av_height = $av_img->height();
            $av_img->crop($av_diameter, $av_diameter, 0, ceil(($new_av_height-$av_diameter)/2));
        }

        /**
         * Скругляем аватар - используем маску с альфаканалом
         */
        $circle = ImageManipulation::canvas($av_diameter, $av_diameter);
        $circle->circle($av_diameter, $av_diameter/2, $av_diameter/2, function ($draw) {
            $draw->background('#0000ff');
        });
        $av_img->mask($circle, true);

        /**
         * Карточка обещания - создаем из источника, узнаем размеры
         */
        $img = ImageManipulation::make($source_path);
        $img_width  = $img->width();
        $img_height = $img->height();
        #Helper::d($img_width . " x " . $img_height);

        /**
         * Вставляем аватар
         */
        $img->insert($av_img, 'top', 0, $av_top_offset);
        $av_img->destroy();

        /**
         * Функция-замыкание, для вывода текста
         */
        $img_text_closure = function($font) use ($font_path, $font_size, $font_color) {
            $font->file($font_path);
            $font->size($font_size);
            $font->color($font_color);
            $font->align('center');
            $font->valign('top');
            //$font->angle(45);
        };

        /**
         * Подготавливаем текст - делаем переносы, чтобы текст поместился в отведенные ему рамки
         */
        ## Поправочный коэффициент, непонятно почему его приходится вводить..
        ## Видимо imagettfbbox считает ширину получаемого блока с ошибкой.
        $text_format_coeff = 1.0;
        $width_text = $img_width * $text_format_coeff;
        #$width_text = 1000;

        if ($debug_text_format) {
            Helper::d('Real image size: ' . $img_width . " x " . $img_height);
            Helper::d('Width limit = ' . $width_text . ' (' . $img_width . ' * ' . $text_format_coeff . ')');
        }

        $arr = explode(' ', $promise_text);
        $ret = '';
        // Перебираем наш массив слов
        foreach($arr as $word) {

            // Временная строка, добавляем в нее слово
            $tmp_string = trim($ret . ' ' . $word);

            // Получение параметров рамки обрамляющей текст, т.е. размер временной строки
            $textbox = imagettfbbox($font_size, 0, $font_path, $tmp_string);

            if ($debug_text_format)
                Helper::d($textbox[2] . ' >= ' . $width_text . ' ? ' . ($textbox[2] >= $width_text ? 'yes' : 'no') . '<br/>' . $tmp_string);

            // Если временная строка не укладывается в нужные нам границы, то делаем перенос строки, иначе добавляем еще одно слово
            if($textbox[2] >= $width_text)
                $ret .= ($ret == "" ? "" : "\n") . $word;
            else
                $ret .= ($ret == "" ? "" : " ") . $word;
        }

        if ($debug_text_format)
            Helper::dd($ret);

        $formatted_promise_text = $ret;



        ## Выравнивание
        if($align=="left") {

            // Накладываем возращенный многострочный текст на изображение, отступим сверху и слева по 50px
            #imagettftext($im, $font_size ,0 , 50, 50, $black, $font, $ret);
            $img->text($formatted_promise_text, $img_width/2, $img_height/2, $img_text_closure);

        } else {

            // Разбиваем снова на массив строк уже подготовленный текст
            $arr = explode("\n", $formatted_promise_text);

            // Расчетная высота смещения новой строки
            $height_tmp = $av_top_offset + $av_diameter + $av_bottom_offset; # высота аватара + отступ (50px)

            //Выводить будем построчно с нужным смещением относительно левой границы
            foreach($arr as $str) {
                // Размер строки
                $testbox = imagettfbbox($font_size, 0, $font_path, $str);

                /*
                // Рассчитываем смещение
                if($align == 'center')
                    $left_x = round(($width_text - ($testbox[2] - $testbox[0]))/2);
                else
                    $left_x = round($width_text - ($testbox[2] - $testbox[0]));
                */

                // Накладываем текст на картинку с учетом смещений
                #imagettftext($im, $font_size, 0, 50 + $left_x, 50 + $height_tmp, $black, $font_path, $str); // 50 - это отступы от края
                $img->text($str, $img_width/2, $height_tmp, function($font) use ($font_path, $font_size, $font_color) {
                    $font->file($font_path);
                    $font->size($font_size);
                    $font->color($font_color);
                    $font->align('center');
                    $font->valign('top');
                    //$font->angle(45);
                });

                // Смещение высоты для следующей строки
                $height_tmp = $height_tmp + $font_size * 1.5;
            }
        }

        /**
         * Вставляем текст
         */
        #$img->text($formatted_promise_text, $img_width/2, $img_height/2, $img_text_closure);
        $img->save($dest_path);
        $img->destroy();

        #return '<img src="' . $dest_url . '" />';
        return [
            'url'   => $dest_url,
            'path'  => $dest_path,
        ];
    }


    public function getStatistics() {

        $date_start = Input::get('date_start');
        $date_stop = Input::get('date_stop');

        $period = 7;

        if ($date_start && $date_stop && $date_start <= $date_stop) {

            $start = (new \Carbon\Carbon())->createFromFormat('Y-m-d H:i:s', $date_start . ' ' . date('H:i:s'));
            $stop = (new \Carbon\Carbon())->createFromFormat('Y-m-d H:i:s', $date_stop . ' ' . date('H:i:s'));

        } else {

            $start = (new \Carbon\Carbon())->now()->subDays($period);
            $stop = (new \Carbon\Carbon())->now();
        }

        #Helper::ta($start->format('Y-m-d') . ' - ' . $stop->format('Y-m-d'));

        $days = array();
        /*
        for ($i = $period; $i > 0; $i--) {
            $days[] = $start->subDay(1)->format('Y-m-d');
        }
        */
        $start2 = clone $start;
        do {
            $days[] = $start2->format('Y-m-d');
            $start2->addDay(1);
        } while($start2->format('Y-m-d') <= $stop->format('Y-m-d'));
        rsort($days);
        #Helper::tad($days);

        $total_users = Dic::valuesBySlug('users');
        $total_users = count($total_users);

        $total_promises = Dic::valuesBySlug('promises');
        $total_promises = count($total_promises);

        #Helper::ta($start->format('Y-m-d H:i:s'));
        #Helper::tad($stop->format('Y-m-d H:i:s'));

        $users = Dic::valuesBySlug('users', function($query) use ($start, $stop) {
            #$query->where('created_at', '>=', date('Y-m-d H:i:s', time()-60*60*24*$period));
            $query->where('created_at', '>=', $start->format('Y-m-d H:i:s'));
            $query->where('created_at', '<=', $stop->format('Y-m-d H:i:s'));
            #$query->select('id', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") AS day, COUNT(*) AS count'));
            $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") AS day, COUNT(*) AS count'));
            $query->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'));
            $query->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), 'DESC');
        });
        $users = DicVal::extracts($users, null, true, false);
        $users = Dic::modifyKeys($users, 'day');
        #Helper::smartQueries(1);
        #Helper::ta($users);

        $users_full = false;
        if (count($users)) {

            $users_full = Dic::valuesBySlug('users', function($query) use ($period) {
                $query->where('created_at', '>=', date('Y-m-d H:i:s', time()-60*60*24*$period));
                $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") AS day'));
                $query->orderBy('created_at', 'DESC');
            });
            $users_full = DicVal::extracts($users_full, null, true, true);
        }
        #Helper::ta($users_full);


        $promises = Dic::valuesBySlug('promises', function($query) use ($start, $stop) {
            #$query->where('created_at', '>=', date('Y-m-d H:i:s', time()-60*60*24*$period));
            $query->where('created_at', '>=', $start->format('Y-m-d H:i:s'));
            $query->where('created_at', '<=', $stop->format('Y-m-d H:i:s'));
            #$query->select('id', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") AS day, COUNT(*) AS count'));
            $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") AS day, COUNT(*) AS count'));
            $query->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'));
            $query->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), 'DESC');
        });
        $promises = DicVal::extracts($promises, null, true, false);
        $promises = Dic::modifyKeys($promises, 'day');
        #Helper::smartQueries(1);
        #Helper::tad($promises);



        $expired_promises = Dic::valuesBySlug('promises', function($query) {

            $query->join_field('time_limit', null, function($join, $value) {
                $join->where($value, '>=', (new \Carbon\Carbon())->now()->format('Y-m-d H:i:s'));
                $join->where($value, '<=', (new \Carbon\Carbon())->now()->addDays(7)->format('Y-m-d H:i:s'));
            });

            #$query->where('created_at', '>=', $start->format('Y-m-d H:i:s'));
            #$query->where('created_at', '<=', $stop->format('Y-m-d H:i:s'));
        });
        $expired_promises = DicVal::extracts($expired_promises, null, true, true);
        #$expired_promises = Dic::modifyKeys($expired_promises, 'id');

        $expired_promises_users = new Collection();
        $expired_promises_users_ids = Dic::makeLists($expired_promises, null, 'user_id');
        if (count($expired_promises_users_ids)) {
            $expired_promises_users = Dic::valuesBySlugAndIds('users', $expired_promises_users_ids);
            $expired_promises_users = DicVal::extracts($expired_promises_users, null, true, true);
        }

        #Helper::smartQueries(1);
        #Helper::tad($expired_promises);

        return View::make(Helper::layout('statistics'), compact('period', 'date_start', 'date_stop', 'start', 'stop', 'days', 'total_users', 'total_promises', 'users', 'users_full', 'promises', 'expired_promises', 'expired_promises_users'));
    }

    public function getStatisticsPromises() {

        $date = Input::get('date');
        #Helper::tad($date);

        $promises = Dic::valuesBySlug('promises', function($query) use ($date) {
            $query->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '=', $date);
        });
        $promises = DicVal::extracts($promises, null, true, true);
        #$promises = Dic::modifyKeys($promises, 'day');

        $user_ids = Dic::makeLists($promises, null, 'user_id');
        $users = Dic::valuesBySlugAndIds('users', $user_ids);
        $users = DicVal::extracts($users, null, true, true);
        #Helper::ta($users);

        $promises = DicLib::groupByField($promises, 'user_id');
        #Helper::smartQueries(1);
        #Helper::ta($promises);


        return View::make(Helper::layout('statistics_promises'), compact('date', 'promises', 'users'));
    }

    public function getStatisticsPromisesAll() {

        $limit = NULL;
        $days_limit = Input::get('days') ?: NULL;
        if ($days_limit)
            $limit = (new \Carbon\Carbon())->now()->subDays($days_limit, $limit);

        $promises = Dic::valuesBySlug('promises', function($query) use ($days_limit, $limit) {

            #$query->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '=', $date);
            $query->orderBy('created_at', 'DESC');
            #$query->take(50);

            if ($days_limit) {
                $query->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '>', $limit->format('Y-m-d'));
            }
        });
        $promises = DicVal::extracts($promises, null, true, true);
        #$promises = Dic::modifyKeys($promises, 'day');
        #Helper::ta($promises);

        $user_ids = Dic::makeLists($promises, null, 'user_id');
        $users = Dic::valuesBySlugAndIds('users', $user_ids);
        $users = DicVal::extracts($users, null, true, true);
        #Helper::ta($users);

        #$promises = DicLib::groupByField($promises, 'user_id');
        #Helper::tad($promises);
        #Helper::smartQueries(1);


        if (Input::get('format') == 'csv') {

            $lines = [];

            foreach ($promises as $promise) {

                $user = @$users[$promise->user_id];
                if (!$user || !is_object($user))
                    continue;

                $user = $this->extract_user($user);
                #Helper::ta($user);
                #processFriends($user)

                $city = $user->city ?: '';
                $gender = '';
                if ($user->sex == 1)
                    $gender = 'Ж';
                elseif ($user->sex == 2)
                    $gender = 'М';

                $promise_status = 'В ПРОЦЕССЕ';
                if ($promise->time_limit < date('Y-m-d H:i:s') && !$promise->finished_at)
                    $promise_status = 'ПРОВАЛЕНО';
                elseif ($promise->finished_at)
                    $promise_status = 'ВЫПОЛНЕНО';


                $line = [
                    @++$m,
                    $promise->created_at->format('d.m.Y'),
                    trim($promise->promise_text),
                    URL::route('app.promise', $promise->id),
                    trim($city),
                    trim($gender),
                    trim($user->name),
                    URL::route('app.profile_id', $user->id),
                    $user->auth_method,
                    $user->identity,
                    $promise->time_limit,
                    $promise_status,
                    ($promise->only_for_me ? 'П' : '')
                ];

                #$content = implode(';', $line) . (Input::get('br') ? "<br/>\n" : "\r\n");

                $comma = (Input::get('comma') == ',' || Input::get('comma') == ';') ? Input::get('comma') : ',';

                /**
                 * Оборачивать значения в кавычки или нет
                 */
                if (Input::get('quotes') == 1)
                    $content = '"' . implode('"' . $comma . '"', $line) . '"';
                else
                    $content = implode($comma, $line);

                $lines[] = $content;
            }

            $full_content = implode("\n", $lines);

            header("Content-Type: application/octet-stream; charset=utf-8");
            header("Content-Disposition: attachment; filename=report_" . date('Y-m-d') . ".csv");
            header("Content-Length: " . mb_strlen($full_content));

            /**
             * Добавляем BOM, чтобы Excel понимал, что файл в кодировке UTF-8
             */
            if (Input::get('bom') == 1)
                echo pack('CCC', 0xef, 0xbb, 0xbf);

            echo $full_content;

        } else {


            #/*
            echo "<table border='1' cellspacing='0' cellpadding='5'>";
            foreach ($promises as $promise) {

                $user = @$users[$promise->user_id];
                if (!$user || !is_object($user))
                    continue;

                $user = $this->extract_user($user);
                #Helper::ta($user);
                #processFriends($user)

                $city = $user->city ?: '&nbsp;';
                $gender = '&nbsp;';
                if ($user->sex == 1)
                    $gender = 'Ж';
                elseif ($user->sex == 2)
                    $gender = 'М';

                $promise_status = '<font color="#bbb">В ПРОЦЕССЕ</font>';
                if ($promise->time_limit < date('Y-m-d H:i:s') && !$promise->finished_at)
                    $promise_status = '<font color="#a00">ПРОВАЛЕНО</font>';
                elseif ($promise->finished_at)
                    $promise_status = '<font color="#080">ВЫПОЛНЕНО</font>';


                echo "<tr style='" . ($promise->only_for_me ? 'background-color:#fdd' : '') . "'>
    <td nowrap>" . @++$m . "</td>
    <td nowrap>" . $promise->created_at->format('d.m.Y') . "</td>
    <td><a href='" . URL::route('app.promise', $promise->id) . "' target='_blank'>" . $promise->promise_text . "</a></td>
    <td align='center'>" . $city . "</td>
    <td nowrap>" . $gender . "</td>
    <td>
        <a href='" . URL::route('app.profile_id', $user->id) . "' target='_blank'>" . $user->name . "</a>
        " . ($user->auth_method != 'native' ? "<a href='" . $user->identity . "' target='_blank'>" . $user->auth_method . "</a>" : '') . "
    </td>
    <td nowrap>" . $promise->time_limit . "</td>
    <td nowrap align='center'>" . $promise_status . "</td>
</tr>\n";
            }
            echo "</table>";
            #*/


        }

        return '';

    }


    /**
     * Проверка валидности номера
     */
    public function postPhoneCheckPhone() {

        $user_id = Input::get('user_id');
        $phone = Input::get('phone');

        $json_request = array('status' => FALSE, 'responseText' => '');

        $user = NULL;
        if ($user_id)
            $user = Dic::valueBySlugAndId('users', $user_id, 'all', 1, 1);

        if ($user_id && is_object($user)) {

            #dd($user);

            $json_request['status'] = TRUE;

            if ($user->phone_number == $phone && $user->phone_confirmed == 1) {

                $json_request['state'] = 'valid';

            } else {

                $json_request['state'] = 'new';

                if ($user->phone_number != $phone) {

                    $user->update_field('phone_number', $phone);
                }
            }

        } else {

            $json_request['responseText'] = 'Пользователь не найден';
        }

        #Helper::tad($user);

        return Response::json($json_request, 200);
    }


    /**
     * Отправляем СМС для подтверждения номера
     */
    public function postPhoneSendSms() {

        $user_id = Input::get('user_id');
        $phone = Input::get('phone');

        $json_request = array('status' => FALSE, 'responseText' => '');

        $user = NULL;
        if ($user_id)
            $user = Dic::valueBySlugAndId('users', $user_id, 'all', 1, 1);

        if ($user_id && is_object($user)) {

            /**
             * Если номер уже подтвержден - не будем отправлять смс. Нечего бюджет транжирить.
             */
            if ($user->phone_number == $phone && $user->phone_confirmed == 1) {

                $json_request['status'] = TRUE;
                $json_request['responseText'] = 'Номер телефона уже подтвержден';

            } else {

                /**
                 * Генерим и сохраняем код подтверждения для пользователя
                 */
                $confirm_code = rand(10000, 99999);
                $user->update_field('phone_confirm_code', $confirm_code);

                /**
                 * Отправляем СМС с кодом пользователю
                 */
                #$client = new Services_Twilio(Config::get('twilio.sid'), Config::get('twilio.token'));

                #/*
                try {
                    /*
                    $sms = $client->account->messages->sendMessage(
                        // Step 6: Change the 'From' number below to be a valid Twilio number
                        // that you've purchased, or the (deprecated) Sandbox number
                        "845-535-4123",
                        // the number we are sending to - Any phone number
                        $user->phone_number,
                        // the sms body
                        "MyPromises.ru code: " . $confirm_code
                    );
                    */

                    SmsAero::sendSms(preg_replace('~[^\d]~is', '', $user->phone_number), "MyPromises.ru confirmation code: " . $confirm_code);

                    $json_request['status'] = TRUE;
                    $json_request['responseText'] = 'СМС отправлено';

                } catch (Services_Twilio_RestException $e) {

                    $json_request['responseText'] = 'Ошибка отправки СМС: ' . '#' . $e->getCode() . ', ' . $e->getMessage();
                }
                #*/
                /*
                try {
                    $sms = $client->account->messages->create([
                        "From" => "845-535-4123",
                        "To" => $user->phone_number,
                        "Body" => "MyPromises.ru code: " . $confirm_code,
                    ]);
                } catch (Services_Twilio_RestException $e) {
                    echo $e->getMessage();
                }
                #*/
            }

            /*
            phone_number
            phone_confirmed
            phone_confirm_code
            */
        }

        return Response::json($json_request, 200);
    }


    /**
     * Проверка проверочного кода
     */
    public function postPhoneCheckCode() {

        $user_id = Input::get('user_id');
        $code = Input::get('code');

        $json_request = array('status' => FALSE, 'responseText' => '');

        $user = NULL;
        if ($user_id)
            $user = Dic::valueBySlugAndId('users', $user_id, 'all', 1, 1);

        if ($user_id && is_object($user)) {

            #dd($user);

            $json_request['status'] = TRUE;

            if ($user->phone_confirm_code == $code) {

                $user->update_field('phone_confirm_code', '');
                $user->update_field('phone_confirmed', '1');
                $json_request['state'] = 'valid';

            } else {

                $json_request['state'] = 'invalid';
                $json_request['responseText'] = 'Неверный код';
            }

        } else {

            $json_request['responseText'] = 'Пользователь не найден';
        }

        #Helper::tad($user);

        return Response::json($json_request, 200);
    }


    public function getHiw() {

        $user = $this->user;
        #Helper::tad($user);

        return View::make(Helper::layout('hiw'), compact('user'));
    }

}