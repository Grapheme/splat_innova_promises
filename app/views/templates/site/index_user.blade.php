@extends(Helper::layout())


@section('style')
@stop


@section('content')


        <big><a href="{{ $user->identity }}" target="_blank">{{ $user->name }}</a></big>
        <a href="{{ URL::route('app.profile') }}">Редактировать</a>
        <a href="#" class="logout">Выйти</a>

        <br/>

        Контактов: {{ @count($user->friends) }}<br/>
        Обещаний: {{ @count($promises) }}<br/>

        @if (isset($promises) && is_object($promises) && count($promises))

            Мои обещания:

            <ul>
            @foreach ($promises as $promise)
                {{ Helper::ta_($promise) }}
                <li><a href="{{ URL::route('app.promise', $promise->id) }}">{{ $promise->name }}</a></li>
            @endforeach
            </ul>
        @else

            Вы еще не давали обещаний.

        @endif

        <br/>

        <a href="{{ URL::route('app.new_promise') }}">Дать обещание</a>

        <br/><br/>

        @if (count($user->friends) || 1)

            Мои друзья:<br/>

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

    <hr/>

    DEBUG:
    {{ Helper::d(@$_SESSION) }}
    {{ Helper::d(@$_COOKIE) }}
    {{ Helper::ta_(@$promises) }}

    <div id="fb-root"></div>

@stop


@section('scripts')

@stop