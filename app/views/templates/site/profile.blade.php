@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if ($msg == 'vkontakte')
        Вы успешно зарегистрировались через соц.сеть ВКонтакте.<br/>
    @elseif ($msg == 'odnoklassniki')
        Вы успешно зарегистрировались через соц.сеть Одноклассники.<br/>
    @elseif ($msg == 'facebook')
        Вы успешно зарегистрировались через соц.сеть Facebook.<br/>
    @endif
    Подтвердите пожалуйста свои данные.

    <form action="{{ URL::route('app.update_profile') }}" method="POST">

        <input type="text" name="name" value="{{ trim($user->name) }}"><br/>

        <input type="text" name="email" value="{{ $user->email }}" placeholder="Укажите ваш e-mail">
        Обязательно укажите емейл<br/>

        <input type="text" name="bdate" value="{{ $user->bdate }}" placeholder="Дата рождения"><br/>

        <input type="submit" value="Сохранить"><br/>

    </form>

@stop


@section('scripts')

@stop