<?php

class ApplicationController extends BaseController {

    public static $name = 'application';
    public static $group = 'application';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        Route::group(array(), function() {

            Route::get('/ok-oauth', array('as' => 'app.ok-oauth', 'uses' => __CLASS__.'@getOkOauth'));
            Route::get('/vk-oauth', array('as' => 'app.vk-oauth', 'uses' => __CLASS__.'@getVkOauth'));

            Route::get('/', array('as' => 'app.mainpage', 'uses' => __CLASS__.'@getAppMainPage'));
            Route::get('/profile', array('as' => 'app.profile', 'uses' => __CLASS__.'@getUserProfile'));
            Route::get('/new_promise', array('as' => 'app.new_promise', 'uses' => __CLASS__.'@getNewPromise'));

            Route::get('/profile/{id}', array('as' => 'app.profile_id', 'uses' => __CLASS__.'@getProfileByID'));
            Route::get('/invite/{data}', array('as' => 'app.send_invite', 'uses' => __CLASS__.'@getSendInvite'));

            Route::get('/promise/{id}', array('as' => 'app.promise', 'uses' => __CLASS__.'@getPromise'));

            Route::any('/update_profile', array('as' => 'app.update_profile', 'uses' => __CLASS__.'@postUserUpdateProfile'));
            Route::any('/send_invite_message', array('as' => 'app.send_invite_message', 'uses' => __CLASS__.'@postSendInviteMessage'));
            Route::any('/add_promise', array('as' => 'app.add_promise', 'uses' => __CLASS__.'@postAddPromise'));

            Route::post('/user-auth', array('as' => 'app.user-auth', 'uses' => __CLASS__.'@postUserAuth'));
            Route::post('/user-update-friends', array('as' => 'app.user-update-friends', 'uses' => __CLASS__.'@postUserUpdateFriends'));

            #Route::any('/ajax/feedback', array('as' => 'ajax.feedback', 'uses' => __CLASS__.'@postFeedback'));
            #Route::any('/ajax/search', array('as' => 'ajax.search', 'uses' => __CLASS__.'@postSearch'));
        });
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

        define('domain', 'http://splat.dev.grapheme.ru');

        $this->user = $this->auth();
        $this->promises = $this->get_promises();
    }


    public function getAppMainPage() {

        $user = $this->user;

        /**
         * Если юзер не авторизован - показываем стандартную главную страницу
         */
        if (!is_object($user) || !$user->id)
            return View::make(Helper::layout('index'), compact('user', 'promises'));

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
        if (@$_SESSION['promise_text']) {
            return Redirect::route('app.new_promise');
        }

        /**
         * Получаем обещания юзера
         */
        $promises = $this->promises;

        /**
         * Определим, какие друзья пользователя уже зареганы в системе
         */
        $existing_friends = array();
        $non_existing_friends = array();

        #Helper::d('Count user friends: ' . count($user->friends));

        $count_user_friends = 0;

        if (count($user->friends)) {

            $user = $this->processFriends($user);
            #Helper::tad($user);

            $count_user_friends = @count($user->existing_friends) + @count($user->non_existing_friends);

            $friends_uids = array();
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

        /**
         * Показываем главную страницу юзера
         */
        return View::make(Helper::layout('index_user'), compact('user', 'promises', 'existing_friends_list', 'count_user_friends'));
    }


    private function processFriends($user) {

        if (!isset($user->friends) || !$user->friends || !count($user->friends))
            return $user;

        $existing_friends = new Collection();
        $non_existing_friends = new Collection();

        #Helper::ta($user);

        switch ($user->auth_method) {

            case "vkontakte":

                #echo "Это Яблоко";

                /**
                 * Ключи массива друзей => полный адрес их страницы
                 */
                $array = $user->friends;
                $friends_uids = array();
                foreach ($array as $f => $friend) {
                    $friend['_name'] = $friend['first_name'] . ' ' . @$friend['last_name'];
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

            case "odnoklassniki":
                #echo "Это Груша";
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
                foreach ($friends as $f => $friend) {
                    $friend['identity'] = 'https://www.facebook.com/profile.php?id=' . $friend['id'];
                    $friend['_name'] = $friend['name'];
                    $friends[$f] = $friend;
                    $existing_friends_names[] = $friend['_name'];
                    $friends_uids[] = $friend['identity'];
                }
                $existing_friends = $friends;
                #Helper::ta($friends_uids);



                #$dic = Dic::where('slug', 'users')->first();
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

                /**
                 * Сопоставляем установивших приложение друзей и ID профиля в системе
                 */
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



                /**
                 * Все
                 */
                $friends = @(array)$user->friends['taggable_friends'];
                foreach ($friends as $f => $friend) {
                    #$friend['identity'] = 'https://www.facebook.com/profile.php?id=' . $friend['id'];
                    $friend['_name'] = $friend['name'];

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

        $user = $this->user;

        if (!is_object($user))
            App::abort(404);

        $msg = false;

        if (@$_SESSION['new_user']) {
            $msg = @$_SESSION['new_user'];
            unset($_SESSION['new_user']);
        }

        return View::make(Helper::layout('profile'), compact('user', 'msg'));
    }


    public function postUserUpdateProfile() {

        $user = $this->user;

        if (!is_object($user))
            App::abort(404);

        $name = Input::get('name');
        $email = Input::get('email');
        $bdate = Input::get('bdate');


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

        if ($bdate) {
            $user->update_field('bdate', $bdate);
        }

        if (@$_SESSION['promise_text']) {
            return Redirect::route('app.new_promise');
        }

        return Redirect::route('app.mainpage');
    }


    public function getNewPromise() {

        $user = $this->user;

        if (!is_object($user))
            App::abort(404);

        $promises = $this->promises;

        return View::make(Helper::layout('new_promise'), compact('user', 'promises'));
    }


    public function postAddPromise() {

        if (!is_object($this->user))
            App::abort(404);

        #Helper::ta(Input::all());

        $promise_text = Input::get('promise_text');
        $time_limit = Input::get('time_limit');
        $only_for_me = Input::get('only_for_me');

        if (!$promise_text || !$time_limit || $time_limit < 1)
            App::abort(404);

        $date_finish = (new \Carbon\Carbon())->now()->addDays($time_limit)->format('Y-m-d');

        #Helper::d($date_finish);

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
                    'date_finish' => $date_finish,
                    'only_for_me' => $only_for_me ? 1 : NULL,
                    'finished_at' => ''
                ),
                'textfields' => array(
                    'promise_text' => $promise_text,
                ),
            )
        );

        /**
         * Очищаем сохраненный текст обещания в сессии
         */
        unset($_SESSION['promise_text']);

        return Redirect::route('app.mainpage');
    }


    public function getPromise($id) {

        $user = $this->user;

        if (!is_object($user))
            App::abort(404);

        $promise = Dic::valueBySlugAndId('promises', $id);
        #Helper::tad($promise);

        if (!is_object($promise) || !$promise->id)
            App::abort(404);

        $promise->extract(1);

        #if ($promise->user_id != $user->id) {
        #    App::abort(404);
        #}


        /**
         * Тут еще нужна проверка - не закончилось ли время выполнения обещания?
         */
        if ($promise->user_id == $user->id) {

            if (Input::get('fail')) {

                if (!$promise->promise_fail && !$promise->finished_at) {
                    $promise->update_field('promise_fail', 1);
                }

            } elseif (Input::get('finished')) {

                if (!$promise->promise_fail && !$promise->finished_at) {
                    $promise->update_field('finished_at', date('Y-m-d'));
                }
            }
        }

        $comments = Dic::valuesBySlug('comments', function($query) use ($promise) {

            $tbl_alias_promise_id = $query->join_field('promise_id', 'promise_id', function($join, $value) use ($promise) {
                $join->where($value, '=', $promise->id);
            });
            $tbl_alias_user_id = $query->join_field('user_id', 'user_id', function($join, $value) use ($promise) {
                $join->where($value, '=', $promise->user_id);
            });

        });

        Helper::smartQueries(1);

        Helper::tad($comments);

        #Helper::tad($promise);

        return View::make(Helper::layout('promise'), compact('user', 'promise'));
    }


    public function postUserAuth() {

        #Helper::dd(Input::all());

        $data = Input::get('data');

        /**
         * Если с авторизацией передан текст обещания - сохраняем его в сессию,
         * чтобы после авторизации сразу перейти на страницу дачи обещания.
         */
        $promise_text = Input::get('promise_text');
        if ($promise_text != '') {
            $_SESSION['promise_text'] = $promise_text;
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
                    $user_record = DicVal::firstOrNew(array(
                        'id' => $temp->dicval_id,
                        'dic_id' => $users_dic->id
                    ));
                    if ($user_record->id) {

                        /**
                         * Обновляем данные пользователя в БД
                         */
                        $user_record = DicVal::refresh(
                            'users',
                            $user_record->id,
                            array(
                                'slug' => NULL,
                                'name' => @$data['first_name'] . ' ' . @$data['last_name'],
                                'fields' => array(
                                    'auth_method' => @$data['auth_method'],
                                    #'identity' => @$data['identity'],
                                    'bdate' => @$data['bdate'],
                                    #'user_token' => md5(md5(time() . '_' . rand(999999, 9999999))),
                                    'user_last_action_time' => time(),
                                ),
                                'textfields' => array(
                                    'full_social_info' => json_encode($data),
                                ),
                            )
                        );

                        #Helper::tad($user_record);

                        #$user_record->load('fields', 'textfields');
                        $user_record->extract(1);

                        #Helper::ta($user_record);

                        $_SESSION['user_token'] = $user_record->user_token;

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
                    $user_record = DicVal::inject(
                        'users',
                        array(
                            'slug' => NULL,
                            'name' => @$data['first_name'] . ' ' . @$data['last_name'],
                            'fields' => array(
                                'auth_method' => @$data['auth_method'],
                                'identity' => @$data['identity'],
                                'email' => @$data['email'],
                                'bdate' => @$data['bdate'],
                                'user_token' => md5(md5(time() . '_' . rand(999999, 9999999))),
                                'user_last_action_time' => time(),
                            ),
                            'textfields' => array(
                                'full_social_info' => json_encode($data),
                            ),
                        )
                    );

                    $user_record->extract(1);

                    #Helper::tad($user_record);

                    $_SESSION['user_token'] = $user_record->user_token;
                    $_SESSION['new_user'] = @$user_record->auth_method;

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

        $user = NULL;

        if (
            !isset($_COOKIE['user_token']) || !isset($_SESSION['user_token'])
            || $_COOKIE['user_token'] == '' || $_SESSION['user_token'] == ''
            || $_COOKIE['user_token'] != $_SESSION['user_token']
        ) {

            unset($_COOKIE['user_token']);
            unset($_SESSION['user_token']);

        } else {

            $temp = DicFieldVal::firstOrNew(array(
                'key' => 'user_token',
                'value' => $_SESSION['user_token']
            ));

            if ($temp->id) {

                $temp->load('dicval.fields', 'dicval.textfields');
                if (is_object($temp->dicval)) {
                    $user = $temp->dicval;

                    $user->extract(1);
                    #$user->extract();

                    #Helper::tad($user);

                    $user->full_social_info = json_decode($user->full_social_info, 1);
                    $user->friends = json_decode($user->friends, 1);

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
                            if (isset($user->full_social_info['city']) && isset($user->full_social_info['city']['title'])) {
                                $user->city = $user->full_social_info['city']['title'];
                            }
                            if (isset($user->full_social_info['sex']) && $user->full_social_info['sex']) {
                                $user->sex = $user->full_social_info['sex'];
                            }
                            if (isset($user->bdate) && $user->bdate) {
                                if (preg_match('~\d{4}\-\d{1,2}\-\d{1,2}~is', $user->bdate)) {
                                    $stamp = (new \Carbon\Carbon())->createFromFormat('Y-m-d', $user->bdate);
                                    $user->years_old = $stamp->diffInYears($now);
                                }
                            } elseif (isset($user->full_social_info['bdate']) && $user->full_social_info['bdate']) {
                                if (preg_match('~\d{4}\-\d{1,2}\-\d{1,2}~is', $user->full_social_info['bdate'])) {
                                    $stamp = (new \Carbon\Carbon())->createFromFormat('Y-m-d', $user->full_social_info['bdate']);
                                    $user->years_old = $stamp->diffInYears($now);
                                }
                            }
                            break;

                        case "odnoklassniki":
                            break;

                        case "facebook":
                            if (isset($user->full_social_info['gender']) && $user->full_social_info['gender']) {
                                $user->sex = $user->full_social_info['gender'] == 'мужской' ? 2 : 1;
                            }
                            if (isset($user->full_social_info['hometown']) && isset($user->full_social_info['hometown']['name'])) {
                                $user->city = $user->full_social_info['hometown']['name'];
                            }
                            if (isset($user->full_social_info['birthday']) && $user->full_social_info['birthday']) {
                                if (preg_match('~\d{2}\/\d{2}\/\d{4}~is', $user->full_social_info['birthday'])) {
                                    $stamp = (new \Carbon\Carbon())->createFromFormat('m/d/Y', $user->full_social_info['birthday']);
                                    $user->years_old = $stamp->diffInYears($now);
                                }
                            }
                            break;
                    }

                    #echo $stamp->format('d.m.Y');

                    #Helper::ta($user);
                }
            }

            if (!is_object($temp) || !is_object($temp->dicval)) {

                unset($_COOKIE['user_token']);
                unset($_SESSION['user_token']);
            }

            #Helper::tad($temp);
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

            if (count($promises)) {
                $promises = DicVal::extracts($promises, 1);
            }

            #Helper::tad($promises);
        }

        return $promises;
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
        $promise_text = Input::get('promise_text');
        if ($promise_text != '') {
            $_SESSION['promise_text'] = $promise_text;
        }

        $curl = curl_init('https://api.odnoklassniki.ru/oauth/token.do');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,
            'code=' . $_GET['code'] .
            '&client_id=' . $AUTH['client_id'] .
            '&client_secret=' . $AUTH['client_secret'] .
            '&redirect_uri=' . URL::route('app.ok-oauth') . '?promise_text=' . $promise_text .
            '&grant_type=authorization_code'
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);


        $auth = json_decode($s, true);


        #Helper::d($auth);

        if (!@$auth['access_token']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (1).";
            die;
        }

        $curl = curl_init('http://api.odnoklassniki.ru/fb.do?access_token=' . $auth['access_token'] . '&application_key=' . $AUTH['application_key'] . '&method=users.getCurrentUser&sig=' . md5('application_key=' . $AUTH['application_key'] . 'method=users.getCurrentUser' . md5($auth['access_token'] . $AUTH['client_secret'])));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);
        $user = json_decode($s, true);

        /*
        Массив $user содержит следующие поля:
        uid - уникальный номер пользователя
        first_name - имя пользователя
        last_name - фамилия пользователя
        birthday - дата рождения пользователя
        gender - пол пользователя
        pic_1 - маленькое фото
        pic_2 - большое фото
        */

        /*
        ...
        Записываем полученные данные в базу, устанавливаем cookies
        ...
        */

        #Helper::d($user);

        if (!@$user['uid']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (2).";
            die;
        }

        $user['identity'] = 'http://ok.ru/profile/' . $user['uid'];
        $user['bdate'] = @$user['birthday'];
        $user['auth_method'] = 'odnoklassniki';

        $check = $this->checkUserData($user, true);
        #Helper::d($check);

        if (!@$check['user']['user_token']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (3).";
            die;
        }




        $friends_get_url = 'http://api.odnoklassniki.ru/fb.do?access_token=' . $auth['access_token']
            . '&method=friends.get&application_key='
            . $AUTH['application_key']
            . '&sig=' . md5('application_key=' . $AUTH['application_key'] . 'method=friends.get' . md5($auth['access_token'] . $AUTH['client_secret']));

        $curl = curl_init($friends_get_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $friends = curl_exec($curl);
        curl_close($curl);
        #$user = json_decode($s, true);

        /**
         * VALUABLE_ACCESS
         * http://apiok.ru/wiki/pages/viewpage.action?pageId=83034588
         * http://apiok.ru/wiki/pages/viewpage.action?pageId=81822097
         */
        Helper::dd($friends);




        setcookie("user_token", $check['user']['user_token'], time()+60*60+24+365, "/");

        echo "
        Авторизация прошла успешно, теперь это окно можно закрыть.
        <script>
        opener.location = '' + opener.location;
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
        $promise_text = Input::get('promise_text');
        if ($promise_text != '') {
            $_SESSION['promise_text'] = $promise_text;
        }

        $HOST = $_SERVER['HTTP_HOST'];

        $AUTH['app_id'] = '4659025';
        $AUTH['app_secret'] = 'kBoFXZ2zNmXuKZTu8IGA';

        $curl = curl_init('https://oauth.vk.com/access_token');

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,
            'client_id=' . $AUTH['app_id'] .
            '&client_secret=' . $AUTH['app_secret'] .
            '&code=' . $code .
            '&redirect_uri=' . URL::route('app.vk-oauth') . '?promise_text=' . $promise_text
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);

        $auth = json_decode($s, true);

        #Helper::d($auth);

        if (!@$auth['access_token'] || !@$auth['user_id']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (1).";
            die;
        }

        $curl = curl_init('https://api.vk.com/method/users.get?user_ids=' . @$auth['user_id'] . '&fields=sex,bdate,city,country,photo_200,domain&v=5.27&lang=ru');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        #curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Language: ru-RU;q=1.0'));
        curl_close($curl);
        $user = json_decode($s, true);
        $user = $user['response'][0];

        $user['uid'] = @$user['id'];

        /*
        Массив $user содержит следующие поля:
        uid - уникальный номер пользователя
        first_name - имя пользователя
        last_name - фамилия пользователя
        birthday - дата рождения пользователя
        gender - пол пользователя
        pic_1 - маленькое фото
        pic_2 - большое фото
        */

        /*
        ...
        Записываем полученные данные в базу, устанавливаем cookies
        ...
        */

        #Helper::d($user);

        if (!@$user['uid']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (2).";
            die;
        }

        $user['identity'] = 'http://vk.com/id' . $user['uid'];
        $user['bdate'] = @$user['birthday'];
        $user['email'] = @$auth['email'];
        $user['auth_method'] = 'vkontakte';

        $check = $this->checkUserData($user, true);
        #Helper::d($check);

        if (!@$check['user']['user_token']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (3).";
            die;
        }


        $curl = curl_init('https://api.vk.com/method/friends.get?user_id=' . @$auth['user_id'] . '&fields=sex,bdate,city,country,photo_200,domain&v=5.27&lang=ru');
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



        setcookie("user_token", $check['user']['user_token'], time()+60*60+24+365, "/");

        echo "
        Авторизация прошла успешно, теперь это окно можно закрыть.
        <script>
        opener.location = '' + opener.location;
        window.close();
        </script>
        ";

        die;

        #header('Location: /'); // редиректим после авторизации на главную страницу

    }



    public function getProfileByID($id) {

        #Helper::dd($id);

        if (isset($this->user) && is_object($this->user) && $this->user->id && $this->user->id == $id && !Input::get('debug')) {
            return Redirect::route('app.mainpage');
        }

        $user = Dic::valueBySlugAndId('users', $id);

        /**
         * Если юзер не авторизован - показываем стандартную главную страницу
         */
        if (!is_object($user) || !$user->id) {

            App::abort(404);
            #return View::make(Helper::layout('index'), compact('user', 'promises'));
        }

        /**
         * Получаем обещания юзера
         */
        $promises = $this->get_promises($user, true);

        /**
         * Показываем страницу профиля
         */
        return View::make(Helper::layout('profile_id'), compact('user', 'promises'));
    }


    public function getSendInvite($data) {

        $data = base64_decode($data);

        $user_name = $data;

        #Helper::dd($data);
        return View::make(Helper::layout('send_invite'), compact('user_name'));
    }


    public function postSendInviteMessage() {

        /**
         * В зависимости от того, какой будет механика отправки запроса (аякс или native)...
         */

        Helper::dd("Send msg...");
    }

}