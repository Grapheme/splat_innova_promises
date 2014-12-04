@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <form action="{{ URL::route('app.do_restore_password') }}" method="POST">

        {{ Session::get('msg') }}<br/>

        Введите свой адрес электронной почты для сброса пароля:<br/>
        <input type="text" name="email" value="" placeholder="Укажите ваш e-mail">
        <input type="submit" value="Сбросить пароль"><br/>

    </form>

@stop


@section('scripts')

@stop