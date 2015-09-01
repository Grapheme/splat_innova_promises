@extends(Helper::layout())
<?
$page_title = 'Что обещают в ' . $current_city->dp;
?>


@section('style')
@stop


@section('content')

    <div class="promises-cont">
        <div class="indexpr-wrapper">
            <div class="wrapper">
                <div class="city-wrapper">
                    <div class="city-title">Что обещают в {{ $current_city->dp }}</div>
                    <div class="city-select">
                        <div class="select-title">Узнай, что обещают в других городах</div>
                        <div class="select-ui">
                            <div class="select-wrap">
                                <select class="ui-select js-reload-select">
                                    @foreach ($cities as $city)
                                        <option value="{{ URL::route('app.cities', ['city' => $city->name]) }}" class="select-option" {{ Input::get('city') == $city->name ? 'selected="selected"' : '' }}>{{ $city->name }}</option>
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

        </div>
    </div>

@stop


@section('scripts')
@stop