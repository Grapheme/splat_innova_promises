@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

        <strong>
            {{ $promise->promise_text }}
        </strong>
        <br/>

        <?
        $failed = !$promise->finished_at && ($promise->promise_fail || date('Y-m-d') > $promise->date_finish);
        ?>
        @if ($failed)
            Задание провалено
        @elseif ($promise->finished_at)
            Выполнено {{ $promise->finished_at }}
        @else
            <a href="?finished=1">Выполнить</a>
            <a href="?fail=1">Отказаться</a>
        @endif

        {{ Helper::ta($promise) }}

        <p><strong>Я обещаю...</strong></p>

        {{ $promise->promise_text }}<br/>

        <a href="#">Выполнено</a>
        <a href="#">Отказаться</a>

        <br/>

        Таймер...

        <h3>Комментарии</h3>

        {{ Helper::ta_($comments) }}
        {{ Helper::ta_($users) }}

        @if (count($comments))
            @foreach ($comments as $comment)
                <?
                $user = @$users[$comment->user_id];
                if (!is_object($user))
                    continue;
                ?>
                <strong>
                    {{ $user->name }}
                </strong><br/>
                {{ $comment->comment_text }}
                <br/><br/>
            @endforeach
        @endif

        <form action="{{ URL::route('app.add_comment') }}" method="POST">
            <input type="hidden" name="promise_id" value="{{ $promise->id }}">
            <textarea name="comment_text" placeholder="Введите текст комментария"></textarea>
            <button>Отправить</button>
        </form>

    @endif

    <?
    $default_avatar = '/theme/images/man.png';
    if (isset($promise_user->sex) && $user->sex == 1)
        $default_avatar = '/theme/images/woman.png';

    if (!$promise->style_id) {
        $styles = array('green', 'aqua', 'yellow', 'blue', 'pink');
        $promise->style_id = $styles[array_rand($styles)];
    }
    ?>
    <div class="promise-make promise-page type-{{ $promise->style_id }}" data-finish="{{ $promise->time_limit }}">
        <div class="wrapper">
            <div class="profile-card">
                <div style="background-image: url({{ $promise_user->avatar ?: $default_avatar }});" class="profile-photo"></div>
                <div class="profile-info">
                    <div class="info-cont">
                        <div class="name"><span>{{ $promise_user->name }}</span></div>
                        @if ($promise_user->years_old)
                            <div class="age">
                                {{ trans_choice(':count год|:count года|:count лет', $promise_user->years_old, array(), 'ru') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="promise-text">
                {{ $promise->promise_text }}
            </div>
            <?
            $failed = !$promise->finished_at && ($promise->promise_fail || date('Y-m-d H:i:s') > $promise->time_limit);
            ?>
            @if (!$failed && !$promise->finished_at)
                <div class="promise-time"><i class="fi icon-progress"></i><span class="js-countdown"></span></div>
            @endif
            <!-- <div class="promise-time"><i class="fi icon-progress"></i><span class="js-countdown"></span></div> -->

            @if($promise_user->id == $auth_user->id)
            <div class="progress-btns">
                @if ($failed)
                    {{-- Задание провалено --}}
                    <div class="pr-btn active">
                        <i class="fi icon-no"></i>
                        <span>
                            @if ($promise->user_id == $user->id)
                                Вы не смогли выполнить данное обещание
                            @else
                                Обещание выполнить не удалось
                            @endif
                        </span>
                    </div>
                @elseif ($promise->finished_at)
                    {{-- Обещание выполнено $promise->finished_at --}}
                    <div class="pr-btn active"><i class="fi icon-okey"></i><span>Обещание выполнено</span></div>
                @else
                    <a href="?finished=1" class="pr-btn"><i class="fi icon-okey"></i><span>Выполнено</span></a>
                    <a href="?fail=1" class="pr-btn"><i class="fi icon-no"></i><span>Отказаться</span></a>
                    <a href="?delete=1" class="pr-btn" title="Удалить"><span>Удалить обещание</span></a>
                @endif
            </div>
            @endif

        </div>
    </div>
    <div class="promo-block">
        <div class="wrapper">
            <div class="logo"></div>
            <div class="text">Каждый раз, выполняя обещания, вы становитесь чуточку лучше. Мы тоже хотим вам пообещать <a href="#" class="js-open-box" data-box="promo">кое-что</a></div>
        </div>
    </div>


    @if (count($comments))
        <div class="wrapper">
            <ul class="comments-list">

                @foreach ($comments as $comment)
                <?
                $commentator = @$users[$comment->user_id];
                if (!is_object($commentator))
                    continue;
                $default_avatar = '/theme/images/man.png';
                if (isset($commentator->sex) && $user->sex == 1)
                    $default_avatar = '/theme/images/woman.png';
                ?>
                <li class="comment">
                    <div style="background-image: url({{ $commentator->avatar ?: $default_avatar }});" class="profile-photo"></div>
                    <div class="comment-content">
                        <div class="name">
                            {{ $commentator->name }}
                        </div>
                        <div class="text">
                            {{ $comment->comment_text }}
                        </div>
                        @if ($comment->user_id == $auth_user->id || $promise->user_id == $auth_user->id)
                        <div class="text">
                            <a href="?do=delete_comment&id={{ $comment->id }}">удалить</a>
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="leave-comment">
        <form action="{{ URL::route('app.add_comment') }}" method="POST">
            <input type="hidden" name="promise_id" value="{{ $promise->id }}">
            <div class="wrapper">
                <div style="background-image: url({{ $user->avatar ?: $default_avatar }});" class="profile-photo"></div>
                <div class="comment-form">
                    <div class="textarea-cont">
                        <textarea name="comment_text" class="input-class"></textarea>
                    </div>
                    <button class="us-btn">Оставить комментарий</button>
                </div>
            </div>
        </form>
    </div>

@stop


@section('scripts')

@stop