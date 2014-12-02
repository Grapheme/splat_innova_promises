@extends(Helper::layout())


@section('style')
@stop


@section('content')


        <big>{{ $user_name }}</big>

        <br/>

        {{ $user_name }} не дал еще ни одного обещания. Пригласите!
        <form action="{{ URL::route('app.send_invite_message') }}" method="POST">
            <input type="text" name="email" placeholder="Введите e-mail">
            <button>Пригласить</button>
        </form>

    <hr/>

    DEBUG:
    {{ Helper::d(@$_SESSION) }}
    {{ Helper::d(@$_COOKIE) }}
    {{ Helper::ta_(@$promises) }}

    <div id="fb-root"></div>

@stop


@section('scripts')

@stop