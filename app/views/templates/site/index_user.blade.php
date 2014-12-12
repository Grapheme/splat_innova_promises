@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

        <br/>

        <big><a href="{{ $user->identity }}" target="_blank">{{ $user->name }}</a></big>
        @if ($user->years_old)
            [ {{ $user->years_old }} ]
        @endif
        @if ($user->city)
            {{ $user->city }}
        @endif
        @if ($user->country)
            {{ $user->country }}
        @endif
        <a href="{{ URL::route('app.profile') }}">Редактировать</a>
        <a href="#" class="logout">Выйти</a>

        <br/>

        Контактов: {{ $count_user_friends }}<br/>
        Обещаний: {{ @count($promises) }}<br/>

        @if (isset($promises) && is_object($promises) && count($promises))

            Мои обещания:

            <ul>
            @foreach ($promises as $promise)
                {{ Helper::ta_($promise) }}
                <li><a href="{{ URL::route('app.promise', $promise->id) }}">{{ $promise->name }}</a></li>
            @endforeach
            </ul>
        @else

            Вы еще не давали обещаний.

        @endif

        <br/>

        <a href="{{ URL::route('app.new_promise') }}">Дать обещание</a>

        <br/><br/>

        @if (count($user->friends) || 1)

            Мои друзья:<br/>

            @if (count($user->existing_friends))
                Уже в системе<sup>{{ count($user->existing_friends) }}</sup>:
                <ul>
                @foreach ($user->existing_friends as $friend)
                    <li>
                        @if (@$friend['profile_id'])
                            <a href="{{ URL::route('app.profile_id', $friend['profile_id']) }}">
                        @endif

                            {{ @$friend['_name'] }}

                        @if (@$friend['profile_id'])
                            </a>
                        @endif
                    </li>
                @endforeach
                </ul>
            @endif

            @if (count($user->non_existing_friends))
                Можно пригласить<sup>{{ count($user->non_existing_friends) }}</sup>:
                <ul>
                    @foreach ($user->non_existing_friends as $friend)
                        <li>
                            <a href="{{ URL::route('app.send_invite', @base64_encode($friend['_name'])) }}">{{ @$friend['_name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif

        @endif

    <hr/>

    DEBUG:
    {{ Helper::d(@$_SESSION) }}
    {{ Helper::d(@$_COOKIE) }}
    {{ Helper::ta(@$user) }}
    {{ Helper::ta_(@$promises) }}

    <div id="fb-root"></div>

    @endif


      <div class="profile-page">
        <div class="wrapper">
          <div class="profile-card">
            <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
            <div class="profile-info">
              <div class="info-cont">
                <div class="name"><span>{{ $user->name }}</span><a href="{{ URL::route('app.profile') }}" class="us-link">Редактировать</a></div>
                <div class="age">
                    {{ $user->years_old }} лет
                </div>
              </div>
            </div>
            <div class="btn-cont"><a href="{{ URL::route('app.new_promise') }}" class="us-btn">Дать обещание</a></div>
          </div>
          <div class="promises-title us-title">Мои обещания</div>
        </div>


        @if (isset($promises) && is_object($promises) && count($promises))

            Мои обещания:

            <ul class="promises-list">
            @foreach ($promises as $promise)
            <?
            if (!$promise->style_id)
                $promise->style_id = 'green';
            ?>
              <li class="promise-item type-{{ $promise->style_id }}">
                <div class="promise-content">
                  <div class="title">
                    <a href="{{ URL::route('app.promise', $promise->id) }}">
                        {{ $promise->name }}
                    </a>
                  </div>
                  <div class="bottom-block">
                    <div class="top-floor">
                      <div class="eye{{ ( $promise->only_for_me ? ' eye-cross' : '') }}"></div>
                    </div>
                    <div class="bottom-floor">
                      <!--
                      <div class="views">15</div>
                      -->
                      <div class="comments">{{ $promise->comments_count }}</div>
                      <div class="time">02:01:23</div>
                    </div>
                  </div>
                </div>
              </li>

            @endforeach
            </ul>
        @else

            Вы еще не давали обещаний.

        @endif


        <ul class="promises-list">
          <li class="promise-item type-green">
            <div class="promise-content">
              <div class="title">ЛЕТОМ СЬЕЗЖУ С РОДИТЕЛЯМИ НА РЫБАЛКУ</div>
              <div class="bottom-block">
                <div class="top-floor">
                  <div class="eye"></div>
                </div>
                <div class="bottom-floor">
                  <div class="views">15</div>
                  <div class="comments">2</div>
                  <div class="time">02:01:23</div>
                </div>
              </div>
            </div>
          </li>
          <li class="promise-item type-aqua">
            <div class="promise-content">
              <div class="title">ЛЕТОМ СЬЕЗЖУ С РОДИТЕЛЯМИ НА РЫБАЛКУ</div>
              <div class="bottom-block">
                <div class="top-floor">
                  <div class="eye eye-cross"></div>
                </div>
                <div class="bottom-floor">
                  <div class="views">15</div>
                  <div class="comments">2</div>
                  <div class="time">02:01:23</div>
                </div>
              </div>
            </div>
          </li>
          <li class="promise-item type-promo">
            <div class="promise-content">
              <div class="logo"></div>
              <div class="text">
                <p>Каждый раз, выполняя обещания,<br> вы становитесь чуточку лучше.</p>
                <p>Мы тоже хотим вам пообещать<br><a href="#">кое-что</a></p>
              </div>
            </div>
          </li>
          <li class="promise-item type-yellow">
            <div class="promise-content">
              <div class="title">ЛЕТОМ СЬЕЗЖУ С РОДИТЕЛЯМИ НА РЫБАЛКУ</div>
              <div class="bottom-block">
                <div class="top-floor">
                  <div class="eye"></div>
                </div>
                <div class="bottom-floor">
                  <div class="views">15</div>
                  <div class="comments">2</div>
                </div>
              </div>
            </div>
          </li>
          <li class="promise-item type-blue">
            <div class="promise-content">
              <div class="title">ЛЕТОМ СЬЕЗЖУ С РОДИТЕЛЯМИ НА РЫБАЛКУ</div>
              <div class="bottom-block">
                <div class="top-floor">
                  <div class="eye"></div>
                </div>
                <div class="bottom-floor">
                  <div class="views">15</div>
                  <div class="comments">2</div>
                  <div class="smile"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="promise-item type-pink">
            <div class="promise-content">
              <div class="title">ЛЕТОМ СЬЕЗЖУ С РОДИТЕЛЯМИ НА РЫБАЛКУ</div>
              <div class="bottom-block">
                <div class="top-floor">
                  <div class="eye"></div>
                </div>
                <div class="bottom-floor">
                  <div class="views">15</div>
                  <div class="comments">2</div>
                  <div class="unsmile"></div>
                </div>
              </div>
            </div>
          </li>
        </ul>


        <div class="friends">
          <div class="wrapper">
            <div class="us-title">Мои друзья <sup>8</sup></div>
          </div>
          <ul class="friends-list">
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
            <li class="friend-item">
              <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
              <div class="name">Анастасия Коротец</div>
            </li>
          </ul>
        </div>
      </div>


@stop


@section('scripts')

@stop