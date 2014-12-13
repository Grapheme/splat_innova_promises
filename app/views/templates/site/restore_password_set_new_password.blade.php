@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <form action="{{ URL::route('app.restore_password_set_new_password') }}" method="POST">

        {{ Session::get('msg') }}<br/>

        Введите новый пароль:<br/>
        <input type="password" name="password" value="">
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="submit" value="Сбросить пароль"><br/>

    </form>

@stop


@section('scripts')

@stop