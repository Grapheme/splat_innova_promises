@extends(Helper::layout())


@section('style')
@stop


@section('content')


        Вы вошли как: <a href="{{ $user->identity }}" target="_blank">{{ $user->name }}</a>
        <a href="{{ URL::route('app.profile') }}">Профиль</a>
        <a href="#" class="logout">Выйти</a>

        <br/>

        Контактов: {{ @count($user->friends) }}<br/>
        Обещаний: {{ @count($promises) }}
        @if (@count($promises) && 0)
            <a href="{{ URL::route('app.promises') }}">просмотр</a>
        @endif
        <br/>

            @if (isset($promises) && is_object($promises) && count($promises))

                <ul>
                @foreach ($promises as $promise)

                    {{ Helper::ta_($promise) }}

                    <li><a href="{{ URL::route('app.promise', $promise->id) }}">{{ $promise->name }}</a></li>

                @endforeach
                </ul>

            @else

                Вы еще не давали обещаний.

            @endif

        <a href="{{ URL::route('app.new_promise') }}">Дать обещание</a>

        <br/><br/>

        @if (count($user->friends) || 1)

            Мои друзья:<br/>

            @if (count($user->existing_friends))
                Уже в системе:
                <ul>
                @foreach ($user->existing_friends as $friend)
                    <li>
                        {{ @$friend['_name'] }}
                    </li>
                @endforeach
                </ul>
            @endif

            @if (count($user->non_existing_friends))
                Можно пригласить:
                <ul>
                    @foreach ($user->non_existing_friends as $friend)
                        <li>
                            {{ @$friend['_name'] }}
                        </li>
                    @endforeach
                </ul>
            @endif

        @endif

    <hr/>

    DEBUG:
    {{ Helper::d(@$_SESSION) }}
    {{ Helper::d(@$_COOKIE) }}
    {{ Helper::ta_(@$promises) }}

    <div id="fb-root"></div>

@stop


@section('scripts')

@stop