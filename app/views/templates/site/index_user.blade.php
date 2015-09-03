@extends(Helper::layout())
<?
setcookie('first_visit_index_user', 1, time()+60*60*24*365, '/');
echo '<!-- ' . (isset($_COOKIE['first_visit_index_user']) ? $_COOKIE['first_visit_index_user'] : '') . ' -->';
$ach_list = [];
if (isset($achievements) && count($achievements)) {
    foreach ($achievements as $achievement) {
        $ach_list[] = [
                'name' => $achievement->name, 'desc' => $achievement->desc, 'icon' => isset($achievement->image) && is_object($achievement->image) ? $achievement->image->full() : '',
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

                <p>МЫ ТОЖЕ ХОТИМ
                    <a href="#" class="js-open-box" data-box="promo" onclick="ga('send', 'event', 'brand', 'profile');">ДАТЬ ВАМ ОБЕЩАНИЕ</a>
                </p>
            </div>
        </div>
    </li>
@stop


@section('content')

    @if (0)

        <br />

        <big>
            <a href="{{ $user->identity }}" target="_blank">{{ $user->name }}</a>
        </big>
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

        <br />

        Контактов: {{ $count_user_friends }}<br />
        Обещаний: {{ @count($promises) }}<br />

        @if (isset($promises) && is_object($promises) && count($promises))

            Мои обещания:

            <ul>
                @foreach ($promises as $promise)
                    {{ Helper::ta_($promise) }}
                    <li>
                        <a href="{{ URL::route('app.promise', $promise->id) }}">{{ $promise->name }}</a>
                    </li>
                @endforeach
            </ul>
        @else

            <div class="wrapper">
                <div data-to-tip="promises"></div>
                <div class="us-text" data-to-tip="list">Вы еще не давали обещаний.</div>
            </div>

        @endif

        <br />

        <a href="{{ URL::route('app.new_promise') }}" onclick="ga('send', 'event', 'new_promise', 'profile'); yaCounter27511935.reachGoal('butpromisesme'); return true;">Дать обещание</a>

        <br /><br />

        @if (count($user->friends) || 1)

            Мои друзья:<br />

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

        <hr />

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
                <div style="background-image: url({{ $user->avatar ?: $default_avatar }});" class="profile-photo" data-to-tip="photo"></div>
                <div class="profile-info">
                    <div class="info-cont">
                        <div class="name"><span>{{ $user->name }}</span>
                            <a href="{{ URL::route('app.profile') }}" class="us-link" data-to-tip="edit">Редактировать</a>
                        </div>
                        @if ($user->years_old && 0)
                            <div class="age">
                                {{ trans_choice(':count год|:count года|:count лет', $user->years_old, array(), 'ru') }}
                            </div>
                        @endif
                        @if ($user->city)
                            <a href="{{ URL::route('app.cities', ['city' => $user->city]) }}" data-to-tip="city">{{ $user->city }}</a>
                        @endif
                        <div class="achives js-achives"></div>
                    </div>
                </div>
                <div class="btn-cont">
                    <a href="{{ URL::route('app.new_promise') }}" onclick="yaCounter27511935.reachGoal('butpromisesme'); return true;" class="us-btn" data-to-tip="promise">Дать обещание</a>
                </div>
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

                    @if ($p == 1)
                        <li class="promise-item type-add-new">
                            <a href="{{ URL::to('/new_promise') }}" class="add-content">
                            <span class="add-wrap">
                                <span class="add-text">Добавить новое обещание</span>
                                <span class="add-icon"></span>
                            </span>
                            </a>
                        </li>
                    @endif

                    @if ($p == 5)
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

            <ul class="promises-list js-inactive">
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

                <li class="promise-item type-show-inactive js-inactive-block">
                    <a href="{{ URL::to('/new_promise') }}" class="add-content js-show-inactive">
                        <span class="add-wrap">
                            <span class="add-text">Посмотреть все архивные обещания</span>
                            <span class="add-icon list-icon"></span>
                        </span>
                    </a>
                </li>

            </ul>
        @endif


        @if (!@count($active_promises) && !@count($inactive_promises))
            <div class="wrapper">
                <div data-to-tip="promises"></div>
                <div class="us-text" data-to-tip="list">Вы еще не давали обещаний.</div>
            </div>
        @endif


        @if ($auth_user->auth_method == 'native')

            <div class="wrapper">
                <div class="inv-form">
                    <p class="text">Пригласите вашего друга и расскажите ему о том, почему так важно сдерживать данные обещания.</p>

                    <div class="inv-btn js-inv-btn-cont2">
                        <a href="#" class="us-btn js-inv-btn2 invite-friend-show-form" data-to-tip="invite">Пригласить друга</a>
                    </div>
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
            <div class="wrapper">
                <div class="promises-title us-title" style="line-height: 60px;">
                    <span>Друзья на MyPromises</span>
                    <!-- <a href="#" class="us-btn right-title-btn">Посмотреть обещания друзей</a> -->
                </div>
            </div>
            <div class="friends-lists">
                <div class="wrapper">
                    <div class="friends friends-left">
                        <div class="friends-title">Ваши друзья</div>
                        <ul class="friends-list">

                            <?
                            $i = 0;
                            $also = [];
                            ?>


                                @if (count($user->existing_friends))
                                    @foreach ($user->existing_friends as $friend)
                                        <?
                                        ++$i;
                                        $default_avatar = '/theme/images/man.png';
                                        if (isset($friend['sex']) && $friend['sex'] == 1)
                                            $default_avatar = '/theme/images/woman.png';

                                        if (isset($friend['_name']) && $friend['_name'])
                                            $also[$friend['_name']] = 1;
                                        ?>
                                        <li class="friend-item registered-user js-friend-item-left" style="display: none;">

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

                                @if (count($subscribed_friends))
                                    @foreach ($subscribed_friends as $friend)
                                        <?
                                        ++$i;
                                        $default_avatar = '/theme/images/man.png';
                                        if (isset($friend['sex']) && $friend['sex'] == 1)
                                            $default_avatar = '/theme/images/woman.png';

                                        if (isset($friend->name) && $friend->name)
                                            if (isset($also[$friend->name]))
                                                continue;
                                            else
                                                $also[$friend->name] = 1;
                                        ?>
                                        <li class="friend-item registered-user js-friend-item-left" style="display: none;">
                                            <a href="{{ URL::route('app.profile_id', $friend->id) }}" style="background-image: url({{ $friend->avatar ?: $default_avatar }});" class="profile-photo clean-a"></a>
                                            <a href="{{ URL::route('app.profile_id', $friend->id) }}" class="name clean-a">{{ $friend->name }}</a>
                                        </li>
                                    @endforeach

                                @endif

                            <div style="float:none; clear:both;"></div>

                        </ul>
                    </div>
                    <div class="friends friends-right">
                        <div class="friends-title">Пригласить друга</sup></div>
                        <ul class="friends-list">

                            <?
                            $i = 0;
                            ?>

                            @if (count($user->non_existing_friends))

                                @foreach ($user->non_existing_friends as $friend)
                                    <?
                                    ++$i;
                                    $default_avatar = '/theme/images/man.png';
                                    if (isset($friend['sex']) && $friend['sex'] == 1)
                                        $default_avatar = '/theme/images/woman.png';
                                    ?>
                                    <li class="friend-item registered-user js-friend-item-right" style="display: none;">

                                        <a href="{{ URL::route('app.send_invite', array('name' => @$friend['_name'], 'avatar' => @$friend['avatar'], 'uid' => @$friend['id'])) }}" data-style="background-image: url({{ @$friend['avatar'] ?: $default_avatar }});" class="profile-photo clean-a"></a>
                                        <a href="{{ URL::route('app.send_invite', array('name' => @$friend['_name'], 'avatar' => @$friend['avatar'], 'uid' => @$friend['id'])) }}" class="name clean-a">{{ @$friend['_name'] }}</a>

                                    </li>
                                @endforeach

                            @endif

                            <div style="float:none; clear:both;"></div>

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="friends-more">
                <a href="#" class="js-show-friends">Показать еще друзей</a>
            </div>
        @endif

    </div>
    @if(!Cookie::get('first-visit-index_user') && 0)
        <div class="tip-overlay js-tip-overlay">
            <div class="tip-block arrow-right-top" data-tip="photo">
                Это Ваша фотография из соц сети. Вы можете ее изменить, зайдя в Настройки
            </div>
            <div class="tip-block arrow-top-left" data-tip="edit">
                Отредактируйте свой профиль и настройте частоту оповещений.
            </div>
            <div class="tip-block arrow-right-top" data-tip="city">
                Укажите город Вашего проживания, чтобы единомышленникам было проще Вас найти.
            </div>
            <div class="tip-block arrow-bottom-top" data-tip="promise">
                Здесь Вы можете составить своё обещание, и выбрать один из предложенных шаблонов его оформления.
            </div>
            <div class="tip-block" data-tip="list">
                <div class="fake-promise"></div>
                <div class="fake-promise"></div>
                <div class="fake-promise"></div>
                <div class="tip-text arrow-right-top">
                    Это список Ваших обещаний. Здесь хранятся все данные Вами обещания, включая выполненные, невыполненные и текущие.
                </div>
            </div>
            <div class="tip-block arrow-top-left" data-tip="invite">
                Вы всегда можете пригласить на MyPromises друга из соцсети, отправив ему нашу открытку.
            </div>
        </div>
    @endif
    <?
    ?>

    <script>
        var __SITE__ = {};
        __SITE__.achievements = {{ json_encode($ach_list, JSON_UNESCAPED_UNICODE) }};
    </script>
@stop


@section('scripts')

    @if (Input::get('new_promise') && $auth_user->auth_method == 'vkontakte' && 0)

        <script>
            //alert(0);
            var vk = {
                data: {},
                api: "//vk.com/js/api/openapi.js",
                appID: 4659025,
                init: function () {
                    //alert(1);
                    //$.js(vk.api);

                    window.vkAsyncInit = function () {
                        //alert("2'");
                        VK.init({apiId: vk.appID});
                        sendPostToWall();
                    }

                    $.getScript(vk.api, function () {
                        // nothing..
                    });

                    function sendPostToWall() {
                        //alert(3);
                        VK.Api.call('wall.post', {
                            owner_id: '{{ @$auth_user->full_social_info['id'] }}',
                            message: "Я только что дал обещание на mypromises.ru\r\nКаждый, кто читает эту запись, имеет право потребовать у меня отчет о выполнении обещания."
                        }, function (r) {
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
                $(document).ready(function () {
                    VK.Api.call('wall.post', {
                        owner_id: '{{ @$auth_user->full_social_info['id'] }}',
                        message: "Я только что дал обещание на mypromises.ru\r\nКаждый, кто читает эту запись, имеет право потребовать у меня отчет о выполнении обещания."
                    }, function (r) {
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
        $(".js-inv-btn2").on("click", function () {
            return $(".js-inv-btn-cont2").slideUp(), $(".js-inv-form2").slideDown(function () {
                $(this).find("input").trigger("focus")
            }), !1
        });

        $("#invite-form").validate({
            rules: {
                'email': {required: true, email: true},
            },
            messages: {
                'email': "",
            },
            errorClass: "inp-error",
            submitHandler: function (form) {
                //console.log(form);
                sendInviteForm(form);
                return false;
            }
        });

        function sendInviteForm(form) {

            //console.log(form);
            var options = {target: null, type: $(form).attr('method'), dataType: 'json'};

            options.beforeSubmit = function (formData, jqForm, options) {
                $(form).find('button').addClass('loading').attr('disabled', 'disabled');
                $(form).find('.error-msg').text('');
                //$('.error').text('').hide();
            }

            options.success = function (response, status, xhr, jqForm) {
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

            options.error = function (xhr, textStatus, errorThrown) {
                console.log(xhr);
                $(form).find('button').removeAttr('disabled');
                $(form).find('.error-msg').text('Ошибка при отправке, попробуйте позднее');
            }

            options.complete = function (data, textStatus, jqXHR) {
                $(form).find('button').removeClass('loading').removeAttribute('disabled');
            }

            $(form).ajaxSubmit(options);
        }

    </script>

@stop