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
          <div class="js-main-fotorama">
            <img src="{{ Config::get('site.theme_path') }}/images/main_slider/slider-1.jpg" alt="">
            <img src="{{ Config::get('site.theme_path') }}/images/main_slider/slider-2.jpg" alt="">
            <img src="{{ Config::get('site.theme_path') }}/images/main_slider/slider-3.jpg" alt="">
            <img src="{{ Config::get('site.theme_path') }}/images/main_slider/slider-4.jpg" alt="">
            <img src="{{ Config::get('site.theme_path') }}/images/main_slider/slider-5.jpg" alt="">
          </div>
        </div>
        <div class="main-content wrapper">
          <div class="title">Пообещать и сдержать слово много стоит</div>
          <div class="desc">Обещания имеют огромную силу. Они способны изменить мир. Выполняя свои<br/>обещания, мы становимся сильнее, обретаем себя и уверенность в том, <br/>что нам все по зубам.</div>
          <!-- <div class="input-cont">
            <input placeholder="Я обещаю, что..." class="main-input js-promise-input promise_text">
            <div class="hint">Совет: Давайте только те обещания, которые можете выполнить.</div>
            <a data-box="auth" class="js-open-box js-promise-btn us-btn make-new-promise-btn">Дать обещание</a>
          </div> -->
          <div class="input-cont js-promise-placeholder">
            <div class="index-promise-input">
              <div class="promise-placeholder">Я обещаю <span>...</span></div>
              <input class="main-input js-promise-input promise-text">
            </div>
            <div class="hint">Совет: Давайте только те обещания, которые сможете выполнить.</div>
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
            Выполнено <b>
            {{ trans_choice(':count обещание|:count обещания|:count обещаний', $finished_promises, array(), 'ru') }}
            </b>
          </div>
        </div>
        <ul class="promises-cloud js-promises">
          <li style="color: #84c80f; font-size: 20px;">Встречу Новый Год с семьей</li>
          <li style="color: #07cbcc; font-size: 26px;">Начну бегать по утрам</li>
          <li style="color: #d9aabe; font-size: 45px;">Буду радоваться мелочам</li>
          <li style="color: #84c80f; font-size: 20px;">Поеду в город моей мечты</li>
          <li style="color: #f8e115; font-size: 30px;">Прыгну с парашютом</li>
          <li>Буду чаще видеться с семьей</li>
          <li style="color: #07cbcc;">Брошу курить с понедельника</li>
          <li style="color: #b7b7b9;">Не буду думать о работе на выходных</li>
          <li style="color: #84c80f; font-size: 20px;">Читать по книге в месяц</li>
          <li style="color: #84c80f; font-size: 20px;">Не буду есть фастфуд</li>
          <li>Ложиться спать не позже 12</li>
          <li style="color: #d9aabe; font-size: 45px;">Запишусь в спортзал</li>
          <li style="color: #f8e115; font-size: 30px;">Выучу английский язык</li>
          <li style="color: #07cbcc;">Скину 5кг или научусь любить себя с ними</li>
          <li style="color: #b7b7b9;">Буду откладывать средства в течение 6 месяцев</li>
        </ul>
      </div>

@stop


@section('scripts')
@stop