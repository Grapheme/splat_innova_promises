@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

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

    @endif

      <div class="main-screen">
        <div class="main-fotorama">
          <div class="js-main-fotorama"><img src="{{ Config::get('site.theme_path') }}/images/main_slider/slider-1.jpg" alt=""><img src="{{ Config::get('site.theme_path') }}/images/main_slider/slider-2.jpg" alt="">
          </div>
        </div>
        <div class="main-content wrapper">
          <div class="title">Пообещать и сдержать слово много стоит.</div>
          <div class="desc">Обещания имеют огромную силу. Они вселяют надежду, помогают достичь цели и изменить себя. Но всё это происходит лишь тогда, когда они перестают быть просто словами и тогда превращаются в дела.</div>
          <div class="input-cont">
            <input placeholder="Я обещаю, что..." class="main-input js-promise-input promise_text">
            <div class="hint">Совет: Давайте только те обещания, которые можете выполнить.</div>
            <a data-box="auth" class="js-open-box js-promise-btn us-btn make-new-promise-btn">Дать обещание</a>
          </div>
        </div>
      </div>
      <div class="promises-cont">
        <div class="promises-fotorama">
          <div class="js-promises-fotorama"><img src="{{ Config::get('site.theme_path') }}/images/promises/back0.png"><img src="{{ Config::get('site.theme_path') }}/images/promises/back1.png"><img src="{{ Config::get('site.theme_path') }}/images/promises/back2.png"><img src="{{ Config::get('site.theme_path') }}/images/promises/back3.png"><img src="{{ Config::get('site.theme_path') }}/images/promises/back4.png">
          </div>
        </div>
        <div class="promises-amount">
          <div class="amount-cont">
            уже <b>
            {{ trans_choice(':count человек|:count человека|:count человек', $total_promises, array(), 'ru') }}
            </b> дали свои обещания</div>
        </div>
        <ul class="promises-cloud js-promises">
          <li style="color: #3e9327; font-size: 20px;">С НОВОГО БРОШУ КУРИТЬ</li>
          <li style="color: #07cbcc;">ЛЕТОМ СЬЕЗЖУ С РОДИТЕЛЯМИ НА РЫБАЛКУ</li>
          <li style="color: #bbbbc3; font-size: 45px;">ОСТАВЛЮ ВСЕ КАК и ЕСТЬ!</li>
          <li style="color: #fee000; font-size: 30px;">НАВЕЩУ РОДИТЕЛЕЙ</li>
          <li style="color: #3e9327;">КУПЛЮ СЕБЕ НОВЫЙ АЙФОН</li>
          <li style="color: #56565b; font-size: 25px;">НЕ ОБЕЩАТЬ</li>
          <li style="color: #07cbcc; font-size: 20px;">ПОХУДЕЮ НА 20 КИЛОГРАММ</li>
        </ul>
      </div>

@stop


@section('scripts')
@stop