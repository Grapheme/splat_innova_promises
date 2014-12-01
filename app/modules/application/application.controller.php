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

            Route::get('/promise/{id}', array('as' => 'app.promise', 'uses' => __CLASS__.'@getPromise'));

            Route::any('/update_profile', array('as' => 'app.update_profile', 'uses' => __CLASS__.'@postUserUpdateProfile'));
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
         * Получаем обещания юзера
         */
        $promises = $this->promises;

        /**
         * Определим, какие друзья пользователя уже зареганы в системе
         */
        $existing_friends = array();
        if (count($user->friends)) {

            $friends_uids = array();
            foreach ($user->friends as $friend) {
                $friend_uid = 'http://vk.com/id' . $friend['uid'];
                $friends_uids[] = $friend_uid;
            }
            $friends_uids[] = 'http://vk.com/id1889847';

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
        return View::make(Helper::layout('index_user'), compact('user', 'promises', 'existing_friends_list'));
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
                    'finished_at' => ''
                ),
                'textfields' => array(
                    'promise_text' => $promise_text,
                ),
            )
        );

        unset($_SESSION['promise_text']);

        return Redirect::route('app.mainpage');
    }


    public function getPromise($id) {

        $user = $this->user;

        if (!is_object($user))
            App::abort(404);

        $promise = Dic::valueBySlugAndId('promises', $id);
        #Helper::tad($promise);

        if (is_object($promise)) {
            $promise->extract(1);
        }

        if ($promise->user_id != $user->id) {
            App::abort(404);
        }


        /**
         * Тут еще нужна проверка - не закончилось ли время выполнения обещания?
         */
        if (Input::get('fail')) {

            if (!$promise->promise_fail && !$promise->finished_at)
                $promise->update_field('promise_fail', 1);

        } elseif (Input::get('finished')) {

            if (!$promise->promise_fail && !$promise->finished_at)
                $promise->update_field('finished_at', date('Y-m-d'));
        }


        #Helper::tad($promise);

        return View::make(Helper::layout('promise'), compact('user', 'promise'));
    }


    public function postUserAuth() {

        #Helper::dd(Input::all());

        $data = Input::get('data');
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

                        $user_record->load('fields', 'textfields');
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
                                'identity' => $data['identity'],
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
                    $_SESSION['new_user'] = @$data['network'];

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
                    $user->friends = json_decode($user->friends, 1);

                    #Helper::tad($user);
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


    private function get_promises() {

        $user = $this->user;

        $promises = NULL;

        if (is_object($user)) {

            $promises = Dic::valuesBySlug('promises', function($query) use ($user) {

                $table = $user->getTable();
                $query->orderBy('created_at', 'DESC');

                #/*
                ## Подключаем доп. поле с помощью JOIN (т.е. неподходящие под условия записи не будут добавлены к выборке)
                $tbl_alias_user_id = $query->join_field('user_id', 'user_id', function($join, $value) use ($user) {
                    ## Подключаем только новости, у которых дата публикации меньше или совпадает с текущей датой,
                    ## и дата публикации которых меньше или совпадает с датой текущей новости.
                    $join->where($value, '=', $user->id);
                    #$join->where($value, '<=', $new->published_at);
                });
                #*/
            });

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

        if (isset($_GET['code'])) {

            $curl = curl_init('https://api.odnoklassniki.ru/oauth/token.do');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,
                'code=' . $_GET['code'] .
                '&client_id=' . $AUTH['client_id'] .
                '&client_secret=' . $AUTH['client_secret'] .
                '&redirect_uri=' . URL::route('app.ok-oauth') .
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

        } else {

            echo "Не удается выполнить вход. Повторите попытку позднее (0).";
            die;

            #header('Location: http://www.odnoklassniki.ru/oauth/authorize?client_id=' . $AUTH['client_id'] . '&scope=VALUABLE ACCESS&response_type=code&redirect_uri=' . urlencode($HOST . 'auth.php?name=odnoklassniki'));
        }

    }

    public function getVkOauth() {

        $code = Input::get('code');

        if (!$code) {
            echo "Не удается выполнить вход. Повторите попытку позднее (0).";
            die;
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
            '&redirect_uri=' . URL::route('app.vk-oauth')
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_close($curl);

        $auth = json_decode($s, true);

        Helper::d($auth);

        if (!@$auth['access_token'] || !@$auth['user_id']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (1).";
            die;
        }

        $curl = curl_init('https://api.vk.com/method/users.get?user_ids=' . @$auth['user_id'] . '&fields=sex,bdate,city,country,photo_200,domain&v=5.27');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $s = curl_exec($curl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Language: ru-RU;q=0.5'));
        curl_close($curl);
        $user = json_decode($s, true);
        $user = $user['response'][0];

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

        Helper::d($user);

        die;

        if (!@$user['uid']) {
            echo "Не удается выполнить вход. Повторите попытку позднее (2).";
            die;
        }

        $user['identity'] = 'http://ok.ru/profile/' . $user['uid'];
        $user['bdate'] = @$user['birthday'];

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

}