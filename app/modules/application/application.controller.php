<?php

class ApplicationController extends BaseController {

    public static $name = 'application';
    public static $group = 'application';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        Route::group(array(), function() {

            Route::get('/', array('as' => 'app.mainpage', 'uses' => __CLASS__.'@getAppMainPage'));
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
	}

    public function getAppMainPage() {

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


        return View::make(Helper::layout('index'), compact('user'));
    }


    public function postUserAuth() {

        #Helper::dd(Input::all());

        $data = Input::get('data');
        #$token = Input::get('token');

        ##Helper::dd($data);
        ##Helper::dd($token);

        if ($data !== NULL) {

            return $this->checkUserData($data);

        #} elseif ($token !== NULL) {
        #    $this->checkUserToken($token);
        }

    }

    private function checkUserData($data) {

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

                    $json_request['responseText'] = 'Ok';
                    $json_request['new_user'] = true;
                    $json_request['user'] = ($user_record->toArray());
                    $json_request['status'] = TRUE;
                }

            }

        }

        #die;

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

}