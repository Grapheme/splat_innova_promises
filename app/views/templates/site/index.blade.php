@extends(Helper::layout())


@section('style')
    <script>
    var fb_app_id = {{ $fb_app_id  }};
    var fb_friends_limit = {{ $fb_friends_limit }};
    </script>
@stop


@section('content')

    <form action="#" method="POST" id="auth_form">

        Я обещаю, что...<br/>
        <textarea class="promise_text"></textarea><br/>
        <input type="button" value="Дать обещание">

        <br/>
        <br/>

        <!--
        Войдите с помощью ВКонтакте (uLogin):
        <script src="//ulogin.ru/js/ulogin.js"></script><div id="uLogin_c0a8a519" data-uloginid="c0a8a519"></div>
        -->

        Войдите с помощью соц. сети:

        <hr/>

            <!--
              Below we include the Login Button social plugin. This button uses
              the JavaScript SDK to present a graphical Login button that triggers
              the FB.login() function when clicked.
            -->
            <div id="fb-root"></div>
            <fb:login-button scope="public_profile,email,user_birthday,user_photos,user_friends" onlogin="checkLoginState();">
            </fb:login-button>
            <div id="status"></div>
            <div id="result_friends"></div>

        <hr/>

            <!--
            http://ok.ru/game/1110811904
            http://api.mail.ru/docs/guides/ok_sites/
            SERVER AUTH: http://apiok.ru/wiki/pages/viewpage.action?pageId=81822109
            OAUTH 2.0:   http://apiok.ru/wiki/display/api/Authorization+OAuth+2.0
            API REQUEST: http://apiok.ru/wiki/pages/viewpage.action?pageId=46137373
            -->
            <link href="http://www.odnoklassniki.ru/oauth/resources.do?type=css" rel="stylesheet" />
            <script src="http://www.odnoklassniki.ru/oauth/resources.do?type=js" type="text/javascript" charset="utf-8"></script>
            <a class="odkl-oauth-lnk" href="" onclick="ODKL.Oauth2(this, 1110811904, 'VALUABLE_ACCESS;SET_STATUS;PHOTO_CONTENT', '{{ domain }}/ok-oauth' ); return false;"></a>

        <hr/>

            <a href="#" class="vk-oauth-link">Авторизоваться ВК</a>

        <hr/>

        или адреса электронной почты:<br/>

        почта <input type="text" name="email"><br/>
        пароль <input type="password" name="pass">

    </form>

    <hr/>

    DEBUG:
    {{ Helper::d(@$_SESSION) }}
    {{ Helper::d(@$_COOKIE) }}
    {{ Helper::ta_(@$promises) }}

    <hr/>


@stop


@section('scripts')

@stop