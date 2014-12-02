@extends(Helper::layout())


@section('style')
@stop


@section('content')


    <big><a href="{{ $user->identity }}" target="_blank">{{ $user->name }}</a></big>

    <br/>

    Обещаний: {{ @count($promises) }}<br/>

    @if (isset($promises) && is_object($promises) && count($promises))

        Обещания пользователя:

        {{ Helper::ta($promises) }}

        <ul>
        @foreach ($promises as $promise)
            {{ Helper::ta_($promise) }}
            <?
            if ($promise->only_for_me)
                continue;
            ?>
            <li><a href="{{ URL::route('app.promise', $promise->id) }}">{{ $promise->name }}</a></li>
        @endforeach
        </ul>
    @else

        Пользователь еще не давал обещаний.

    @endif

@stop


@section('scripts')

@stop