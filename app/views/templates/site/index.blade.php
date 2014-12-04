@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <form action="#" method="POST" id="promise_form">
        Я обещаю, что...<br/>
        <textarea class="promise_text"></textarea><br/>
    </form>

    <br/>
    <br/>

    Войдите с помощью соц. сети:

    <hr/>

        <!--
          Below we include the Login Button social plugin. This button uses
          the JavaScript SDK to present a graphical Login button that triggers
          the FB.login() function when clicked.
        -->
        <div id="fb-root"></div>
        <fb:login-button scope="public_profile,email,user_birthday,user_photos,user_friends,user_about_me,user_hometown" onlogin="checkLoginState();">
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
        <a class="odkl-oauth-lnk_____ ok-oauth-link" href="#" data-domain="{{ domain }}">Войти через Одноклассники</a>

    <hr/>

        <a href="#" class="vk-oauth-link">Авторизоваться ВК</a>

    <hr/>

    или адреса электронной почты:<br/>

    <form action="{{ URL::route('app.email-pass-auth') }}" method="POST" id="auth_form">
        <input type="hidden" name="promise_text" value=""><br/>
        почта <input type="text" name="email" class="user-auth-email"><br/>
        пароль <input type="password" name="pass" class="user-auth-pass"><br/>
        <button type="submit" class="user-auth-send">Войти</button>
        <a href="{{ URL::route('app.restore_password') }}">Забыли пароль?</a>
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