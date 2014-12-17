@extends(Helper::layout())


@section('style')
    @parent
@stop


@section('koe-chto')
    <li class="promise-item type-promo">
        <div class="promise-content">
            <div class="logo"></div>
            <div class="text">
                <p>Каждый раз, выполняя обещания,<br> вы становитесь чуточку лучше.</p>
                <p>Мы тоже хотим вам пообещать<br><a href="#" class="js-open-box" data-box="promo">кое-что</a></p>
            </div>
        </div>
    </li>
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


        @if (isset($active_promises) && count($active_promises))

            <div class="wrapper">
                <div class="little-title">Активные</div>
            </div>

            <ul class="promises-list">
            <?
            $p = 0;
            ?>
            @foreach ($active_promises as $promise)
            <?
                ++$p;
                if (!$promise->style_id) {
                    $styles = array('green', 'aqua', 'yellow', 'blue', 'pink');
                    $promise->style_id = $styles[array_rand($styles)];
                }
            ?>

                @include(Helper::layout('promise_inc'), array('promise_type' => 'active'))

                @if ($p == 2)
                    @yield('koe-chto')
                @endif

            @endforeach

            @if ($p == 1)
                @yield('koe-chto')
            @endif

            </ul>

        @endif



        @if (isset($inactive_promises) && count($inactive_promises))

            <div class="wrapper">
                <div class="little-title">Неактивные</div>
            </div>

            <ul class="promises-list">
                <?
                $p = 0;
                ?>
                @foreach ($inactive_promises as $promise)
                <?
                    ++$p;
                    if (!$promise->style_id) {
                        $styles = array('green', 'aqua', 'yellow', 'blue', 'pink');
                        $promise->style_id = $styles[array_rand($styles)];
                    }
                ?>

                    @include(Helper::layout('promise_inc'), array('promise_type' => 'inactive'))

                    @if ($p == 2 && !@count($active_promises))
                        @yield('koe-chto')
                    @endif

                @endforeach

                @if ($p == 1 && !@count($active_promises))
                    @yield('koe-chto')
                @endif

            </ul>
        @endif


        @if (!@count($active_promises) && !@count($inactive_promises))
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
                  <div class="eye" data-tooltip="Обещание видно всем пользователям."></div>
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
                  <div class="eye" data-tooltip="Обещание видно всем пользователям."></div>
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
                  <div class="eye" data-tooltip="Обещание видно всем пользователям."></div>
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
                  <div class="eye" data-tooltip="Обещание видно всем пользователям."></div>
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

                            <a href="{{ URL::route('app.send_invite', array('name' => $friend['_name'], 'avatar' => @$friend['avatar'], 'uid' => @$friend['id'])) }}" data-style="background-image: url({{ @$friend['avatar'] ?: $default_avatar }});" class="profile-photo clean-a"></a>
                            <a href="{{ URL::route('app.send_invite', array('name' => $friend['_name'], 'avatar' => @$friend['avatar'], 'uid' => @$friend['id'])) }}" class="name clean-a">{{ @$friend['_name'] }}</a>

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

    @if (Input::get('new_promise') && $auth_user->auth_method == 'vkontakte' && 0)

        <script>
            //alert(0);
            var vk = {
                data: {},
                api: "//vk.com/js/api/openapi.js",
                appID: 4659025,
                init: function(){
                    //alert(1);
                    //$.js(vk.api);

                    window.vkAsyncInit = function(){
                        //alert("2'");
                        VK.init({apiId: vk.appID});
                        sendPostToWall();
                    }

                    $.getScript(vk.api,function(){
                        // nothing..
                    });

                    function sendPostToWall(){
                        //alert(3);
                        VK.Api.call('wall.post', {
                            owner_id: '{{ @$auth_user->full_social_info['id'] }}',
                            message: "Я только что дал обещание на mypromises.ru\r\nКаждый, кто читает эту запись, имеет право потребовать у меня отчет о выполнении обещания."
                        }, function(r) {
                            //console.log(r);
                            //alert('OK!');
                            //$(".js-inv-btn-cont2").slideUp();
                            //$("#send-invite-success").slideDown();
                        });
                    }
                }
            }

            $(document).ready(vk.init);
        </script>

        @if (0)
        <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
        <script type="text/javascript">
            VK.init({
                apiId: 4659025
            });
        </script>
        <script>
            $(document).ready(function(){
                VK.Api.call('wall.post', {
                    owner_id: '{{ @$auth_user->full_social_info['id'] }}',
                    message: "Я только что дал обещание на mypromises.ru\r\nКаждый, кто читает эту запись, имеет право потребовать у меня отчет о выполнении обещания."
                }, function(r) {
                    //console.log(r);
                    //alert('OK!');
                    //$(".js-inv-btn-cont2").slideUp();
                    //$("#send-invite-success").slideDown();
                });
            });
        </script>
        @endif

    @endif
@stop