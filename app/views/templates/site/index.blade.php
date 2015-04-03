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
          <div>
          	  <div class="slide-title js-slide-title" data-promise-text="поиграть в снежки этой зимой">Я обещаю поиграть в снежки этой зимой</div>
              <div class="slide-title js-slide-title" data-promise-text="съездить с близкими в горы">Я обещаю съездить с близкими в горы <!--до конца зимы--></div>
              <div class="slide-title js-slide-title" data-promise-text="улыбнуться всем прохожим сегодня">Я обещаю улыбнуться всем прохожим сегодня<!--по дороге на работу--></div>
              <div class="slide-title js-slide-title" data-promise-text="читать по одной книге в месяц">Я обещаю читать по одной книге в месяц</div> 
              <div class="slide-title js-slide-title" data-promise-text="привести себя в форму к весне">Я обещаю привести себя в форму к весне</div> 
          </div>
          <h1 class="title">Пообещать и сдержать слово многого стоит</h1>
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
            <div class="hint">Давайте только те обещания, которые сможете выполнить</div>
            <a data-box="auth" onclick="yaCounter27511935.reachGoal('butpromises'); return true;" class="js-open-box js-promise-btn us-btn make-new-promise-btn">Дать обещание</a>
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
                  <span class="mainpage_counter">
                      {{ $finished_promises }}
                  </span>
                  {{ trans_choice('обещание|обещания|обещаний', $finished_promises, array(), 'ru') }}
              </b>
          </div>
        </div>
        <div>
          <!-- <div class="promises-amount">
            <div class="amount-cont">уже <b>4 738</b> человек дали свои обещания</div>
          </div> -->
          <div class="indexpr-wrapper">

              @if (isset($mainpage_promises) && is_object($mainpage_promises) && $mainpage_promises->count())

                  <ul class="promises-index">

                      @foreach ($mainpage_promises as $promise)
                          <?
                          $puser = isset($users[$promise->user_id]) ? $users[$promise->user_id] : NULL;
                          if (!$puser)
                              continue;
                          $city_promises_count = @(int)$cities_promises_counts[mb_strtolower(trim($puser->city))];
                          $promise_comments_count = @(int)$promises_comments_count[$promise->id];
                          ?>

                          @if ($promise->promise_of_the_week)

                              <li class="promise-item innova-block" style="cursor:pointer;" onclick="window.location.href='http://mypromises.ru/promise/{{ $promise->id }}'">
                                  <div class="flipper">
                                      <div class="promise-cont">
                                          <div class="info-cont">
                                              <div class="innova-choice">Выбор</div>
                                              <a href="http://mypromises.ru/promise/{{ $promise->id }}" class="pr-title">{{ $promise->name }}</a>
                                              <div class="user-info"><a style="background-image: url({{ $puser->avatar }})" class="user-photo"></a>
                                                  <div class="user-text">
                                                      <div class="name"><a>{{ $puser->name }}</a></div>
                                                      <div class="city"><a>{{ $puser->city }}</a></div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="promise-cont promise-hover">
                                          <div class="info-cont">
                                              <div class="innova-choice">Выбор</div>
                                              <div class="innova-text">
                                                  <p>Команда SPLAT обещает, что каждую неделю мы будем выбирать одно выполненное обещание и награждать того,<br>кто сдержал свое слово призом-сюрпризом. </p>
                                                  <a href="#" class="js-open-box innova-link" data-box="promo" onclick="ga('send', 'event', 'brand', 'profile');">Читать далее</a>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </li>

                          @else

                              <li class="promise-item js-parent">
                                  <div class="flipper">
                                      <div class="promise-cont type-{{ $promise->style_id }}">
                                          <div class="info-cont">
                                              <a class="comments-amount">{{ trans_choice(':count комментарий|:count комментария|:count комментариев', $promise_comments_count, array(), 'ru') }}</a>
                                              <div class="pr-title js-promise-text">{{ mb_strtoupper($promise->name) }}</div>
                                              <div class="user-info"><a href="#" style="background-image: url({{ $puser->avatar }})" class="user-photo"></a>
                                                  <div class="user-text">
                                                      <div class="name">{{ $puser->name }}</div>
                                                      <div class="city">{{ $puser->city }}</div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="promise-cont promise-hover type-{{ $promise->style_id }}">
                                          <div class="info-cont">
                                              <div class="promise-stat pr-loc">
                                                  @if ($city_promises_count)
                                                      <div class="stat-title">{{ trans_choice(':count Обещание|:count Обещания|:count Обещаний', $city_promises_count, array(), 'ru') }}</div>
                                                      <div class="stat-desc">{{ $puser->city }}</div>
                                                  @endif
                                              </div>
                                              <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                                          </div>
                                      </div>
                                  </div>
                              </li>
                          @endif

                      @endforeach

                  </ul>


              @endif

          @if (0)
            <ul class="promises-index">
              <li class="promise-item innova-block">
                <div class="promise-cont type-undefined">
                  <div class="info-cont">
                    <div class="innova-choice">Выбор</div>
	                  <a href="http://mypromises.ru/promise/5066" class="pr-title">НАУЧИТЬСЯ ИГРАТЬ НА ГАРМОШКЕ)</a>
	                  <div class="user-info"><a style="background-image: url(http://cs624729.vk.me/v624729190/21a02/I8JSziad_c8.jpg)" class="user-photo"></a>
	                    <div class="user-text">
	                      <div class="name"><a>Николай Barabanov</a></div>
	                      <div class="city"><a>д.Гусевица</a></div>
	                    </div>
	                 </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-blue">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">ВЫЙТИ ЗАМУЖ В ЭТОМ ГОДУ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/b0c82b4fbbcc66aef2b56083809596a2.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Кристина</div>
                          <div class="city">Киев</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-blue">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Киева</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-blue">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">БЫТЬ ЛУЧШИМ ОТЦОМ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/e9409610fb556cf414e6dc6997bd2cea.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Артем</div>
                          <div class="city">Москва</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-blue">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Москвы</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-blue">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">НАУЧИТЬСЯ ТАНЦЕВАТЬ САЛЬСУ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/d98cd811d0ff77f1349dc4e76168689a.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Ксения</div>
                          <div class="city">Питер</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-blue">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Питера</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-green">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">НЕ РАССТРАИВАТЬСЯ ПО ПУСТЯКАМ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://cs624627.vk.me/v624627062/225/lKcpY5Jh2jY.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Юлия Гафарова</div>
                          <div class="city">Уфа</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-green">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Уфы</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-blue">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">ЗАНЯТЬ ПРИЗОВОЕ МЕСТО НА ВОКАЛЬНОМ КОНКУРСЕ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/64b4ea9f026a25675e7f17b9df9a8f23.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Анна</div>
                          <div class="city">Владимир</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-blue">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Владимира</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-blue">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">БЫТЬ СЧАСТЛИВОЙ КАЖДУЮ МИНУТУ 2015 ГОДА</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://cs607919.vk.me/v607919721/61cb/ZuNjvJqdZ14.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Виктория Михайлова</div>
                          <div class="city">Ростов-на-Дону</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-blue">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Ростова-на-Дону</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-green">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">СТАТЬ ХОРОШИМ ВРАЧОМ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://cs621226.vk.me/v621226487/8722/n4fAxxaN1Ig.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Никита Артемов</div>
                          <div class="city">Заринск</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-green">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Заринска</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-blue">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">ВЛЮБИТЬСЯ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/3356e062b0b4be1b8ef9604ab12ea7b2.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Карина</div>
                          <div class="city">Сальск</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-blue">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Сальска</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-green">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">НАУЧИТЬСЯ ИГРАТЬ НА ГИТАРЕ "SMOKE ON THE WATER"</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://cs411121.vk.me/v411121773/9d1a/SIxpfGvfpT0.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Павел Ханов</div>
                          <div class="city">Екатеринбург</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-green">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Екатеринбурга</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-aqua">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">ПРИХОДИТЬ НА РАБОТУ В ХОРОШЕМ НАСТРОЕНИИ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/bf0107c3df32ad80e336171fe425f5dd.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Владимир Манычев</div>
                          <div class="city">Москва</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-aqua">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Москвы</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="promise-item js-parent">
                <div class="flipper">
                  <div class="promise-cont type-blue">
                    <div class="info-cont"><a class="comments-amount">0 комментариев</a>
                      <div class="pr-title js-promise-text">УСТРОИТЬ ОГРОМНЫЙ ПРАЗДНИК НА ДЕНЬ РОЖДЕНИЯ ДОЧКИ</div>
                      <div class="user-info"><a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/49cf97b4e4171eaead6babef89003fbc.jpg)" class="user-photo"></a>
                        <div class="user-text">
                          <div class="name">Юлианна Никулина</div>
                          <div class="city">Москва</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="promise-cont promise-hover type-blue">
                    <div class="info-cont">
                      <div class="promise-stat pr-loc">
                        <div class="stat-title">45 Обещаний</div>
                        <div class="stat-desc">из Москвы</div>
                      </div>
                      <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          @endif
          </div>
        </div>
        <!-- <ul class="promises-cloud js-promises">
          <li style="color: #07cbcc;">Начну бегать по утрам</li>
          <li style="color: #d9aabe; font-size: 45px;">Буду радоваться мелочам</li>
          <li style="color: #84c80f; font-size: 20px;">Обещаю говорить только правду в течение месяца</li>
          <li style="color: #f8e115; font-size: 30px;">Прыгну с парашютом</li>
          <li>Буду чаще играть с сыном</li>
          <li style="color: #07cbcc;">Брошу курить с понедельника</li>
          <li style="color: #84c80f; font-size: 20px;">Читать по книге в месяц</li>
          <li style="color: #84c80f; font-size: 20px;">Не буду есть фастфуд</li>
          <li style="color: #f8e115; font-size: 30px;">Выучу английский язык</li>
          <li>Ложиться спать не позже 12</li>
          <li style="color: #d9aabe; font-size: 45px;">Запишусь в спортзал</li>
          <li style="color: #07cbcc;">Скину 5кг или научусь любить себя с ними</li>
          <li style="color: #b7b7b9;">Сделать пожертвование в детский дом</li>
        </ul>
        <div class="wrapper" style="cursor:pointer;" onclick="location.href='http://mypromises.ru/promise/2240';">
          <div data-tooltip="Команда SPLAT обещает, что каждую неделю мы будем выбирать одно выполненное обещание<br>и награждать того,<br>кто сдержал свое слово призом-сюрпризом." data-tooltip-center="on" class="promise-week">
            <div class="week-inline left-word">Выбор</div>
            <div class="week-inline logo"></div>
            <div style="background-image: url(http://cs623324.vk.me/v623324593/16339/dIRyMEhIpJg.jpg);" class="week-inline profile-photo"></div>
            <div class="week-inline promise-info">
              <div class="title">ВЫШИТЬ ЛОШАДЕЙ УЖЕ НАКОНЕЦ-ТО)))</div>
              <div class="name">Дуня Мельникова, Евпатория</div>
            </div>
          </div>
        </div> -->
      </div>

@stop


@section('scripts')
    <script>
        $(function(){

            var count = 502;
            var update_mainpage_counter = function() {

                $.ajax({
                    url: '{{ URL::route('app.mainpage_counter') }}',
                    type: 'GET'
                    //dataType: 'json',
                    //data: { data: data, promise_text: promise_text }
                })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            //alert('ERROR');
                            console.log(textStatus);
                        })
                        .done(function(response) {
                            count = response;
                            //alert("SUCCESS");
                            console.log(count);
                            $('.mainpage_counter').text(count);
                        })
                ;
            }
            setInterval(update_mainpage_counter, 10000);

        });
    </script>
@stop