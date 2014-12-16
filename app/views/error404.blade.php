@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="error404">
        <div class="error404-cont">
            <div class="icon">
                <div class="fi icon-sad"></div>
            </div>
            <div class="title">404–ошибка</div>
            <div class="text">Страница не найдена.<br>Адрес набран неверно, или страница была удалена.<br>Перейти <a href="{{ URL::route('app.mainpage') }}">на главную</a>.</div>
        </div>
    </div>

@stop


@section('scripts')
@stop