@extends(Helper::layout())


@section('title')Карта сайта@stop


@section('style')
@stop


@section('content')

    <div class="sitemap">
        <div class="wrapper">
            <div class="sitemap-cont">
                <div class="map-title">Карта сайта</div>
                <ul class="map-links">
                    <li class="map-parent">Весь сайт</li>
                </ul>
                <ul class="map-links">
                    <li><a href="/">Главная страница</a></li>
                    <li><a href="/privacy_policy.pdf">Правила пользования</a></li>
                    {{--<li><a href="#">О проекте</a></li>--}}
                    <li><a href="mailto:hello@mypromises.ru?subject=%D0%A3%20%D0%BC%D0%B5%D0%BD%D1%8F%20%D0%B5%D1%81%D1%82%D1%8C%20%D0%BF%D1%80%D0%B5%D0%B4%D0%BB%D0%BE%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5&body=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5!%20%D0%AF%20%D0%B1%D1%8B%20%D1%85%D0%BE%D1%82%D0%B5%D0%BB%20%D0%BF%D1%80%D0%B5%D0%B4%D0%BB%D0%BE%D0%B6%D0%B8%D1%82%D1%8C%20...">Обратная связь</a></li>
                </ul>
            </div>
        </div>
    </div>

@stop


@section('scripts')
@stop