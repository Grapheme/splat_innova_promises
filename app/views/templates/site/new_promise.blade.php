<?/*
Картинки для шеринга - в /public/js/app.js
*/?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

        {{ Form::model(null, array('url' => URL::route('app.add_promise'), 'class' => 'smart-form', 'id' => 'promise-form', 'role' => 'form', 'method' => 'PUT', 'files' => true)) }}

        Я обещаю, что...<br />

        {{ Form::textarea('promise_text', (@$_SESSION['promise_text'] && $_SESSION['promise_text'] != 'undefined' ? $_SESSION['promise_text'] : '')) }}<br />

        Срок: {{ Form::text('time_limit', 14) }} дней<br />
        <label>
            {{ Form::checkbox('only_for_me') }} видно только мне </label>

        <br />

        {{ Form::submit('Добавить') }}

        {{ Form::close() }}

    @endif

    <?
    $default_avatar = '/theme/images/man.png';
    if (isset($user->sex) && $user->sex == 1)
        $default_avatar = '/theme/images/woman.png';
    ?>

    <div class="promise-make js-type-parent">
        <div class="wrapper">
            <div class="title">Новое обещание</div>
            <div class="profile-card">
                <div style="background-image: url({{ $user->avatar ?: $default_avatar }});" class="profile-photo"></div>
                <div class="profile-info">
                    <div class="info-cont">
                        <div class="name"><span>{{ $user->name }}</span></div>
                        @if ($user->years_old && 0)
                            <div class="age">
                                {{ trans_choice(':count год|:count года|:count лет', $user->years_old, array(), 'ru') }}
                            </div>
                        @endif
                        @if ($user->city)
                            {{ $user->city }}
                        @endif
                        {{-- <div class="achives js-achives"></div> --}}
                    </div>
                </div>
            </div>
            <div class="promise-form">
                {{ Form::model(null, array('url' => URL::route('app.add_promise'), 'class' => 'smart-form', 'id' => 'promise-form', 'role' => 'form', 'method' => 'PUT', 'files' => true)) }}
                        <!-- <div class="input-cont">
                {{ Form::textarea('promise_text', (@$_SESSION['promise_text'] && $_SESSION['promise_text'] != 'undefined' ? $_SESSION['promise_text'] : ''), array('placeholder' => "Я ОБЕЩАЮ ...")) }}<br/>
              </div> -->
                <div class="input-cont input-advice-cont">
                    <div class="make-promise-placeholder js-promise-placeholder">
                        <div class="promise-placeholder">Я ОБЕЩАЮ <span>...</span></div>
                        {{ Form::textarea('promise_text', (@$_SESSION['promise_text'] && $_SESSION['promise_text'] != 'undefined' ? $_SESSION['promise_text'] : ''), ['class' => 'js-advice-to']) }}
                        <div class="promises-advice">
                            <span>Например:</span>
                            <a href="#" class="js-advice" style="display: none;">Научиться признавать свои ошибки</a>
                            <a href="#" class="js-advice" style="display: none;">Не пропускать тренировки</a>
                            <a href="#" class="js-advice" style="display: none;">Начать правильно питаться</a>
                            <a href="#" class="js-advice" style="display: none;">Прыгнуть с парашютом и нырнуть с аквалангом за лето</a>
                            <a href="#" class="js-advice" style="display: none;">Не сидеть дома по выходным</a>
                            <a href="#" class="js-advice" style="display: none;">Съездить в диснейленд</a>
                            <a href="#" class="js-advice" style="display: none;">Посвятить день самому себе</a>
                            <a href="#" class="js-advice" style="display: none;">Находить выход из любой ситуации</a>
                            <a href="#" class="js-advice" style="display: none;">Не расстраиваться по пустякам</a>
                            <a href="#" class="js-advice" style="display: none;">Приходить на работу в хорошем настроении</a>
                            <a href="#" class="js-advice" style="display: none;">Звонить родителям каждый день</a>
                            <a href="#" class="js-advice" style="display: none;">Улыбаться кассирам в магазине</a>
                            <a href="#" class="js-advice" style="display: none;">Перестать опаздывать</a>
                        </div>
                    </div>
                </div>
                @if($auth_user->auth_method == 'vkontakte')
                    <div class="promise-friend time-inputs">
                        <div class="friend-title">Пообещать другу</div>
                        <div class="friend-input">
                            <select class="input-class js-chosen" multiple data-placeholder="Выберите друга">
                                <option>Andrey Samoilov</option>
                                <option>Kostya Durnev</option>
                            </select>
                        </div>
                        <div class="friend-or">или</div>
                        <div class="friend-input">
                            <input class="input-class" placeholder="Введите email друзей через запятую">
                        </div>
                    </div>
                @endif
                <div class="time-inputs">
                    <div class="desc">Я выполню обещание к</div>
                    <div class="input-cont">
                        <!-- <span class="bet-text">часам</span> -->
                        <div class="input-div date-div">
                            <input name="limit_date" class="date-input input-class js-future-date">
                        </div>
                        <span class="bet-text"></span>

                        <div class="input-div time-div">
                            <input name="limit_time" class="time-input input-class js-mask-time">
                        </div>
                    </div>
                </div>
                <div class="color-inputs">
                    <div class="desc">Выберите оформление</div>
                    <select name="style_id" class="js-type-select hidden">
                        <option value="blue"></option>
                        <option value="yellow"></option>
                        <option value="aqua"></option>
                        <option value="pink"></option>
                        <option value="green"></option>
                    </select>
                    <ul class="color-select js-types">
                        <li data-type="blue" class="color-item type-blue"></li>
                        <li data-type="yellow" class="color-item type-yellow"></li>
                        <li data-type="aqua" class="color-item type-aqua"></li>
                        <li data-type="pink" class="color-item type-pink"></li>
                        <li data-type="green" class="color-item type-green"></li>
                    </ul>
                    <div class="check-cont">
                        {{ Form::checkbox('only_for_me', 1, null, array('id' => 'apply', 'class' => 'styledCheck')) }}
                        <label for="apply"><span class="check-fake"><i class="fi icon-check"></i></span> Сделать обещание видимым только мне</label>
                    </div>
                    <div class="btn-cont">
                        <button class="us-btn">Дать обещание</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <!--
    <div class="promo-block">
      <div class="wrapper">
        <div class="text">
            КАЖДЫЙ РАЗ, ВЫПОЛНЯЯ ОБЕЩАНИЯ, ВЫ СТАНОВИТЕСЬ СИЛЬНЕЕ.</br>
            МЫ ТОЖЕ ХОТИМ <a href="#" class="js-open-box" data-box="promo" onclick="ga('send', 'event', 'brand', 'promise');">ДАТЬ ВАМ ОБЕЩАНИЕ</a>
        </div>
        <div class="logo"></div>
      </div>
    </div>
    -->


@stop


@section('scripts')
    <script>SplatSite.Promise();</script>

    <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
    <script type="text/javascript">
        VK.init({
            apiId: 4659025
        });
        VK.Auth.getLoginStatus(function (response) {
            console.log(response);
            if (response.session) {
                /* Авторизованный в Open API пользователь */
            } else {
                /* Неавторизованный в Open API пользователь */
            }
        });
        var auth_method = '{{ @$auth_user->auth_method }}';
        var auth_user_id = '{{ @$auth_user->full_social_info['id'] }}';
        var vkapi_post_image_upload_url = '{{ URL::route('app.vk-api.post-upload') }}';
        var user_profile_url = '{{ URL::route('app.profile_id', $auth_user->id) }}';
    </script>

@stop