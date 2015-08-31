@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="promises-cont">
        <div class="indexpr-wrapper">
            <div class="wrapper">
                <div class="city-wrapper">
                    <div class="city-title">Что обещают в Москве</div>
                    <div class="city-select">
                        <div class="select-title">Узнай, что обещают в других городах</div>
                        <div class="select-ui">
                            <div class="select-wrap">
                                <select class="ui-select js-reload-select">
                                    @foreach ($cities as $city)
                                        <option value="{{ URL::route('app.cities', ['city' => $city->name]) }}" class="select-option">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="#" class="ui-btn us-btn js-reload-set">Узнать</a>
                        </div>
                    </div>
                </div>
            </div>


            @if (isset($promises) && is_object($promises) && $promises->count())

                <ul class="promises-index js-split-promises">

                    @foreach ($promises as $promise)
                        <?
                        $puser = isset($users[$promise->user_id]) ? $users[$promise->user_id] : NULL;
                        if (!$puser)
                            continue;
                        ?>
                            <!-- <?php print_r($promise); ?> -->
                            <li class="promise-item js-parent js-promise-item">
                                <div class="flipper">
                                    <div class="promise-cont type-{{ $promise->style_id }}">
                                        <div class="info-cont">
                                            {{--<a class="comments-amount">{{ trans_choice(':count комментарий|:count комментария|:count комментариев', $promise_comments_count, array(), 'ru') }}</a>--}}
                                            <div class="pr-title js-promise-text">{{ mb_strtoupper($promise->name) }}</div>
                                            <div class="user-info"><a style="background-image: url({{ $puser->avatar }})" class="user-photo"></a>
                                                <div class="user-text">
                                                    <div class="name">{{ $puser->name }}</div>
                                                    <div class="city">{{ $puser->city }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="cursor: pointer;" onclick="window.location.href='http://mypromises.ru/promise/{{ $promise->id }}'" class="promise-cont promise-hover type-{{ $promise->style_id }}">
                                        <div class="info-cont">
                                            <div class="promise-stat pr-loc">
                                                    <div class="stat-title">{{ trans_choice(':count Обещание|:count Обещания|:count Обещаний', count($promises), array(), 'ru') }}</div>
                                                    <div class="stat-desc">из <b>{{ $city->dp }}</b></div>
                                                    <div class="stat-desc" style="margin: 25px 0 0; font-size: 16px; line-height: 1.5;">{{ mb_strtoupper($promise->name) }}</div>
                                            </div>
                                            <div class="btn-cont"><a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a></div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                    @endforeach

                </ul>
                <div class="js-promises-more promises-more">
                    <a href="#">Показать еще</a>
                </div>

            @endif


            <ul class="promises-index js-split-promises">
                <li class="promise-item js-promise-item innova-block js-parent">
                    <div class="flipper">
                        <div class="promise-cont">
                            <div class="info-cont">
                                <div class="innova-choice">Выбор</div>
                                <a href="#" class="pr-title">Купить новый телевизор на шпагате</a>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg)" class="user-photo"></a>
                                    <div class="user-text">
                                        <div class="name">
                                            <a href="#">Руслан Корнеев</a>
                                        </div>
                                        <div class="city">
                                            <a href="#">Ростов-на-Дону</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="promise-cont promise-hover">
                            <div class="info-cont">
                                <div class="innova-choice">Выбор</div>
                                <div class="innova-text">
                                    <p>Команда INNOVA обещает, что каждую неделю мы будем выбирать одно выполненное обещание и награждать того,<br>кто сдержал свое слово призом-сюрпризом. </p>
                                    <a href="#" class="innova-link">Читать далее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-blue">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">ВЫЙТИ ЗАМУЖ В ЭТОМ ГОДУ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/b0c82b4fbbcc66aef2b56083809596a2.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-blue">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">БЫТЬ ЛУЧШИМ ОТЦОМ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/e9409610fb556cf414e6dc6997bd2cea.jpg)" class="user-photo"></a>
                                    <div class="user-text">
                                        <div class="name">Артем</div>
                                        <div class="city">Мск</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="promise-cont promise-hover type-blue">
                            <div class="info-cont">
                                <div class="promise-stat pr-loc">
                                    <div class="stat-title">45 Обещаний</div>
                                    <div class="stat-desc">из Мск</div>
                                </div>
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-blue">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">НАУЧИТЬСЯ ТАНЦЕВАТЬ САЛЬСУ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/d98cd811d0ff77f1349dc4e76168689a.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-green">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">НЕ РАССТРАИВАТЬСЯ ПО ПУСТЯКАМ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://cs624627.vk.me/v624627062/225/lKcpY5Jh2jY.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-blue">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">ЗАНЯТЬ ПРИЗОВОЕ МЕСТО НА ВОКАЛЬНОМ КОНКУРСЕ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/64b4ea9f026a25675e7f17b9df9a8f23.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-blue">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">БЫТЬ СЧАСТЛИВОЙ КАЖДУЮ МИНУТУ 2015 ГОДА</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://cs607919.vk.me/v607919721/61cb/ZuNjvJqdZ14.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-green">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">СТАТЬ ХОРОШИМ ВРАЧОМ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://cs621226.vk.me/v621226487/8722/n4fAxxaN1Ig.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-blue">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">ВЛЮБИТЬСЯ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/3356e062b0b4be1b8ef9604ab12ea7b2.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-green">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">НАУЧИТЬСЯ ИГРАТЬ НА ГИТАРЕ "SMOKE ON THE WATER"</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://cs411121.vk.me/v411121773/9d1a/SIxpfGvfpT0.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-aqua">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">ПРИХОДИТЬ НА РАБОТУ В ХОРОШЕМ НАСТРОЕНИИ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/bf0107c3df32ad80e336171fe425f5dd.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="promise-item js-promise-item js-parent">
                    <div class="flipper">
                        <div class="promise-cont type-blue">
                            <div class="info-cont">
                                <a class="comments-amount">0 комментариев</a>
                                <div class="pr-title js-promise-text">УСТРОИТЬ ОГРОМНЫЙ ПРАЗДНИК НА ДЕНЬ РОЖДЕНИЯ ДОЧКИ</div>
                                <div class="user-info">
                                    <a href="#" style="background-image: url(http://mypromises.ru/uploads/avatar/49cf97b4e4171eaead6babef89003fbc.jpg)" class="user-photo"></a>
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
                                <div class="btn-cont">
                                    <a href="#" class="stat-btn js-promise-card-btn">Пообещать тоже</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="js-promises-more promises-more">
                <a href="#">Показать еще</a>
            </div>
        </div>
    </div>

@stop


@section('scripts')
@stop