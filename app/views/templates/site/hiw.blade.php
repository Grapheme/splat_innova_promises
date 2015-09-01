@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <div class="hiw">
        <div class="hiw-block">
            <div class="hiw-text">
                <div class="hiw-title">Говорите.</div>
                <div class="hiw-desc">
                    Фиксируйте свои обещания на сайте и выбирайте сроки их выполнения. Делитесь ими в соцсетях, чтобы друзья могли помочь вам сдержать слово.
                </div>
            </div>
            <div class="hiw-image" style="background-image: url('/theme/images/hiw/top.jpg');"></div>
        </div>
        <div class="hiw-block">
            <div class="hiw-image" style="background-image: url('/theme/images/hiw/middle.jpg');"></div>
            <div class="hiw-text">
                <div class="hiw-title">Делайте.</div>
                <div class="hiw-desc">
                    Только от ваших усилий зависит, останутся ваши слова просто словами или превратятся в дела. Действуйте, а сайт mypromises.ru всегда напомнит об оставшемся времени на выполнение.
                </div>
            </div>
        </div>
        <div class="hiw-block">
            <div class="hiw-text">
                <div class="hiw-title">Вдохновляйте.</div>
                <div class="hiw-desc">
                    Отмечайте выполненные обещания, делитесь результатами в соцсетях и становитесь достойным примером для окружающих!<br>
                    И помните: слова обязательно меняют мир, если становятся делами.
                </div>
            </div>
            <div class="hiw-image" style="background-image: url('/theme/images/hiw/bottom.jpg');"></div>
        </div>
    </div>

    <div class="hiw-btn">
        @if (isset($user) && is_object($user) && $user->id)
            <!-- Если авторизован - кидаем на /new_promise -->
            <a href="{{ URL::route('app.new_promise') }}" class="us-btn">Создать свое обещание</a>
        @else
            <!-- Если нет, показываем этот блок -->
            <a href="#" class="us-btn js-open-box" data-box="auth">Создать свое обещание</a>
        @endif
    </div>

@stop


@section('scripts')
@stop