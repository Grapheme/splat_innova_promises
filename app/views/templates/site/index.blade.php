@extends(Helper::layout())


@section('style')
@stop


@section('content')

    Hello, SPLAT!


    @if ($user !== NULL)
        <br/>
        Вы вошли как: <a href="{{ $user->identity }}" target="_blank">{{ $user->name }}</a>
        <a href="#" class="logout">Выйти</a>
        Друзей: {{ @count($user->friends) }}
    @else
        <script src="//ulogin.ru/js/ulogin.js"></script><div id="uLogin_c0a8a519" data-uloginid="c0a8a519"></div>
    @endif

    <hr/>

    DEBUG:
    {{ Helper::d(@$_SESSION) }}
    {{ Helper::d(@$_COOKIE) }}

@stop


@section('scripts')
@stop