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

            <div class="wrapper">
              <div class="us-text">Вы еще не давали обещаний.</div>
            </div>

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

    <?
    $default_avatar = '/theme/images/man.png';
    if (isset($user->sex) && $user->sex == 1)
        $default_avatar = '/theme/images/woman.png';
    ?>
      <div class="profile-page">
        <div class="wrapper">
          <div class="profile-card">
            <div style="background-image: url({{ $user->avatar ?: $default_avatar }});" class="profile-photo"></div>
            <div class="profile-info">
              <div class="info-cont">
                <div class="name"><span>{{ $user->name }}</span><a href="{{ URL::route('app.profile') }}" class="us-link">Редактировать</a></div>
                @if ($user->years_old)
                <div class="age">
                    {{ trans_choice(':count год|:count года|:count лет', $user->years_old, array(), 'ru') }}
                </div>
                @endif
              </div>
            </div>
            <div class="btn-cont"><a href="{{ URL::route('app.new_promise') }}" class="us-btn">Дать обещание</a></div>
          </div>
          <div class="promises-title us-title">Мои обещания</div>
        </div>


        @if (isset($promises) && is_object($promises) && count($promises))

            <ul class="promises-list">
            @foreach ($promises as $promise)
            <?
            if (!$promise->style_id) {
                $styles = array('green', 'aqua', 'yellow', 'blue', 'pink');
                $promise->style_id = $styles[array_rand($styles)];
            }
            ?>
              <li class="promise-item type-{{ $promise->style_id }}" data-finish="{{ $promise->time_limit }}">
                <a href="{{ URL::route('app.promise', $promise->id) }}" class="fullsizelink"></a>
                <div class="promise-content">
                  <div class="title">
                    {{ $promise->name }}
                  </div>
                  <div class="bottom-block">
                    <div class="top-floor">
                      <div class="eye{{ ( $promise->only_for_me ? ' eye-cross' : '') }}"></div>
                    </div>
                    <div class="bottom-floor">
                      <!--
                      <div class="views">15</div>
                      -->
                      <div class="comments">{{ (int)$promise->comments_count }}</div>
                      <div class="time">02:01:23</div>
                    </div>
                  </div>
                </div>
              </li>

            @endforeach
            </ul>
        @else

            <div class="wrapper">
              <div class="us-text">Вы еще не давали обещаний.</div>
            </div>

        @endif

        @if (0)
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
                <p>Мы тоже хотим вам пообещать<br><a href="#" class="js-open-box" data-box="promo">кое-что</a></p>
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
        @endif


        <?
        $friends_count = @count($user->existing_friends) + @count($user->non_existing_friends);
        ?>
        <div class="friends">
          <div class="wrapper">
            <div class="us-title">Мои друзья <sup>{{ $friends_count }}</sup></div>
          </div>

          <ul class="friends-list">

            <?
            $i = 0;
            ?>

            @if (count($user->existing_friends))

                @foreach ($user->existing_friends as $friend)
                    <?
                    ++$i;
                    $default_avatar = '/theme/images/man.png';
                    if (isset($friend['sex']) && $friend['sex'] == 1)
                        $default_avatar = '/theme/images/woman.png';
                    ?>
                    <li class="friend-item registered-user{{ $i > 12 ? ' hidden' : '' }}">

                        @if (@$friend['profile_id'])

                            <a href="{{ URL::route('app.profile_id', $friend['profile_id']) }}" style="background-image: url({{ @$friend['avatar'] ?: $default_avatar }});" class="profile-photo clean-a"></a>
                            <a href="{{ URL::route('app.profile_id', $friend['profile_id']) }}" class="name clean-a">{{ @$friend['_name'] }}</a>
                        
                        @else

                            <div style="background-image: url({{ @$friend['avatar'] ?: $default_avatar }});" class="profile-photo clean-a"></div>
                            <div class="name clean-a">{{ @$friend['_name'] }}</div>

                        @endif

                    </li>
                @endforeach

            @endif

            @if (count($user->non_existing_friends))

                @foreach ($user->non_existing_friends as $friend)
                    <?
                    ++$i;
                    $default_avatar = '/theme/images/man.png';
                    if (isset($friend['sex']) && $friend['sex'] == 1)
                        $default_avatar = '/theme/images/woman.png';
                    ?>
                    <li class="friend-item registered-user{{ $i > 12 ? ' hidden' : '' }}">

                            <a href="{{ URL::route('app.send_invite', array('name' => $friend['_name'], 'avatar' => @$friend['avatar'])) }}" style="background-image: url({{ @$friend['avatar'] ?: $default_avatar }});" class="profile-photo clean-a"></a>
                            <a href="{{ URL::route('app.send_invite', array('name' => $friend['_name'], 'avatar' => @$friend['avatar'])) }}" class="name clean-a">{{ @$friend['_name'] }}</a>

                    </li>
                @endforeach

            @endif

              @if ($friends_count > 12)
                <div style="float:none; clear:both;"></div>
                <div class="wrapper">
                  <a href="#" class="show-more-friends" data-limit="12">Показать еще 12 друзей</a>
                </div>
              @endif

          </ul>



        </div>


      </div>


@stop


@section('scripts')

@stop