@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <form action="#" method="POST" id="auth_form">

        Я обещаю, что...<br/>
        <textarea class="promise_text"></textarea><br/>
        <input type="button" value="Дать обещание">

        <br/>
        <br/>

        Войдите с помощью соц.сетей:
        <script src="//ulogin.ru/js/ulogin.js"></script><div id="uLogin_c0a8a519" data-uloginid="c0a8a519"></div>

        или адреса электронной почты:<br/>

        почта <input type="text" name="email"><br/>
        пароль <input type="password" name="pass">

    </form>

    <hr/>

    DEBUG:
    {{ Helper::d(@$_SESSION) }}
    {{ Helper::d(@$_COOKIE) }}
    {{ Helper::ta_(@$promises) }}

    <div id="fb-root"></div>

@stop


@section('scripts')

@stop