@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <strong>
        {{ $promise->promise_text }}
    </strong>
    <br/>

    @if ($promise->promise_fail)
        Задание провалено
    @elseif ($promise->finished_at)
        Выполнено {{ $promise->finished_at }}
    @else
        <a href="?finished=1">Выполнить</a>
        <a href="?fail=1">Отказаться</a>
    @endif

    {{ Helper::ta($promise) }}

    <h3>Комментарии...</h3>

@stop


@section('scripts')

@stop