@extends(Helper::layout())


@section('style')
@stop


@section('content')

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

    @if (count($comments))
        @foreach ($comments as $comment)
            <?
            $user = @$users[$comment->user_id];
            if (!is_object($user))
                continue;
            ?>
            <strong>
                {{ $user->name }}
            </strong>
            <p>
                {{ $comment->comment_text }}
            </p>
        @endforeach
    @endif

@stop


@section('scripts')

@stop