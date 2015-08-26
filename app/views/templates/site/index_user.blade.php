@extends(Helper::layout())
<?
$ach_list = [];
if (isset($achievements) && count($achievements)) {
    foreach ($achievements as $achievement) {
        $ach_list[] = [
            'name' => $achievement->name,
            'desc' => $achievement->desc,
            'icon' => isset($achievement->image) && is_object($achievement->image) ? $achievement->image->full() : '',
        ];
    }
}
?>


@section('style')
    @parent
@stop


@section('koe-chto')
    <li class="promise-item type-promo">
        <div class="promise-content">
            <div class="logo"></div>
            <div class="text">
                <p>КАЖДЫЙ РАЗ, ВЫПОЛНЯЯ ОБЕЩАНИЯ,<br>ВЫ СТАНОВИТЕСЬ СИЛЬНЕЕ.</p>
                <p>МЫ ТОЖЕ ХОТИМ <a href="#" class="js-open-box" data-box="promo" onclick="ga('send', 'event', 'brand', 'profile');">ДАТЬ ВАМ ОБЕЩАНИЕ</a></p>
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

        <a href="{{ URL::route('app.new_promise') }}" onclick="ga('send', 'event', 'new_promise', 'profile'); yaCounter27511935.reachGoal('butpromisesme'); return true;">Дать обещание</a>

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
                @if ($user->years_old && 0)
                <div class="age">
                    {{ trans_choice(':count год|:count года|:count лет', $user->years_old, array(), 'ru') }}
                </div>
                @endif
                @if ($user->city)
                    {{ $user->city }}
                @endif
              </div>
            </div>
            <div class="btn-cont"><a href="{{ URL::route('app.new_promise') }}" onclick = "yaCounter27511935.reachGoal('butpromisesme'); return true;" class="us-btn">Дать обещание</a></div>
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


        @if ($auth_user->auth_method == 'native')

              <div class="wrapper">
                  <div class="inv-form">
                      <p class="text">Пригласите вашего друга и расскажите ему о том, почему так важно сдерживать данные обещания.</p>
                      <div class="inv-btn js-inv-btn-cont2"><a href="#" class="us-btn js-inv-btn2 invite-friend-show-form">Пригласить друга</a></div>
                      <div id="send-invite-success" style="display:none">
                          Приглашение успешно отправлено.
                      </div>
                      <div style="display: none;" class="form js-inv-form2">
                          <form action="{{ URL::route('app.send_invite_message') }}" method="POST" id="invite-form">
                              <input name="email" placeholder="E-mail друга" class="us-input">
                              <div class="input-cont">
                                <input type="hidden" name="name" value="{{ @$user['name'] }}">
                              </div>
                              <div class="input-cont">
                                <button class="us-btn" onclick="ga('send', 'event', 'invite', 'email');">Пригласить</button>
                              </div>
                          </form>
                      </div>
                  </div>

              </div>

          @else

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

                            <a href="{{ URL::route('app.send_invite', array('name' => @$friend['_name'], 'avatar' => @$friend['avatar'], 'uid' => @$friend['id'])) }}" data-style="background-image: url({{ @$friend['avatar'] ?: $default_avatar }});" class="profile-photo clean-a"></a>
                            <a href="{{ URL::route('app.send_invite', array('name' => @$friend['_name'], 'avatar' => @$friend['avatar'], 'uid' => @$friend['id'])) }}" class="name clean-a">{{ @$friend['_name'] }}</a>

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
        @endif

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


    <script>
        $(".js-inv-btn2").on("click",function(){
            return $(".js-inv-btn-cont2").slideUp(), $(".js-inv-form2").slideDown(function(){
                $(this).find("input").trigger("focus")
            }),!1
        });

        $("#invite-form").validate({
            rules: {
                'email': { required: true, email: true },
            },
            messages: {
                'email': "",
            },
            errorClass: "inp-error",
            submitHandler: function(form) {
                //console.log(form);
                sendInviteForm(form);
                return false;
            }
        });

        function sendInviteForm(form) {

            //console.log(form);
            var options = { target: null, type: $(form).attr('method'), dataType: 'json' };

            options.beforeSubmit = function(formData, jqForm, options){
                $(form).find('button').addClass('loading').attr('disabled', 'disabled');
                $(form).find('.error-msg').text('');
                //$('.error').text('').hide();
            }

            options.success = function(response, status, xhr, jqForm){
                //console.log(response);
                //$('.success').hide().removeClass('hidden').slideDown();
                //$(form).slideUp();

                if (response.status) {
                    /*
                     $(form).find('button').addClass('success').text('Отправлено');
                     $(form).find('.popup-body').slideUp(function(){
                     setTimeout(function(){ $('.popup .js-popup-close').trigger('click'); }, 3000);
                     });
                     */
                    $(form).slideUp();
                    $("#send-invite-success").slideDown();

                } else {
                    //$('.response').text(response.responseText).show();
                }

            }

            options.error = function(xhr, textStatus, errorThrown){
                console.log(xhr);
                $(form).find('button').removeAttr('disabled');
                $(form).find('.error-msg').text('Ошибка при отправке, попробуйте позднее');
            }

            options.complete = function(data, textStatus, jqXHR){
                $(form).find('button').removeClass('loading').removeAttribute('disabled');
            }

            $(form).ajaxSubmit(options);
        }

    </script>

    <script>
        var __SITE__ = {};
        __SITE__.achievements = {{ json_encode($ach_list, JSON_UNESCAPED_UNICODE) }};
    </script>

@stop