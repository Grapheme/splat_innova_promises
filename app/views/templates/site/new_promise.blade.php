@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

        {{ Form::model(NULL, array('url' => URL::route('app.add_promise'), 'class' => 'smart-form', 'id' => 'promise-form', 'role' => 'form', 'method' => 'PUT', 'files' => true)) }}

            Я обещаю, что...<br/>

            {{ Form::textarea('promise_text', (@$_SESSION['promise_text'] && $_SESSION['promise_text'] != 'undefined' ? $_SESSION['promise_text'] : '')) }}<br/>

            Срок: {{ Form::text('time_limit', 14) }} дней<br/>
            <label>
                {{ Form::checkbox('only_for_me') }} видно только мне
            </label>

            <br/>

            {{ Form::submit('Добавить') }}

        {{ Form::close() }}

    @endif

      <div class="promise-make js-type-parent">
        <div class="wrapper">
          <div class="title">Новое обещание</div>
          <div class="profile-card">
            <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
            <div class="profile-info">
              <div class="info-cont">
                <div class="name"><span>Кирилл Черенков</span></div>
                <div class="age">28 лет</div>
              </div>
            </div>
          </div>
          <div class="promise-form">
            {{ Form::model(NULL, array('url' => URL::route('app.add_promise'), 'class' => 'smart-form', 'id' => 'promise-form', 'role' => 'form', 'method' => 'PUT', 'files' => true)) }}
              <div class="input-cont">
                {{ Form::textarea('promise_text', (@$_SESSION['promise_text'] && $_SESSION['promise_text'] != 'undefined' ? $_SESSION['promise_text'] : ''), array('placeholder' => "Я ОБЕЩАЮ ...")) }}<br/>
              </div>
              <div class="time-inputs">
                <div class="desc">Я выполню обещание к</div>
                <div class="input-cont">
                  <div class="input-div time-div">
                    <input class="time-input input-class">
                  </div><span class="bet-text">часам</span>
                  <div class="input-div date-div">
                    <input class="date-input input-class">
                  </div>
                </div>
              </div>
              <div class="color-inputs">
                <div class="desc">Выберите оформление</div>
                <select class="js-type-select hidden">
                  <option value="blue"></option>
                  <option value="yellow"></option>
                  <option value="aqua"></option>
                  <option value="pink"></option>
                  <option value="green"></option>
                </select>
                <ul class="color-select js-types">
                  <li data-type="blue" class="color-item type-blue"></li>
                  <li data-type="yellow" class="color-item type-yellow"></li>
                  <li data-type="aqua" class="color-item type-aqua"></li>
                  <li data-type="pink" class="color-item type-pink"></li>
                  <li data-type="green" class="color-item type-green"></li>
                </ul>
                <div class="check-cont">
                  {{ Form::checkbox('only_for_me', 1, NULL, array('id' => 'apply', 'class' => 'styledCheck')) }} видно только мне
                  <label for="apply"><span class="check-fake"><i class="fi icon-check"></i></span> Сделать обещание видимым только мне</label>
                </div>
                <div class="btn-cont">
                  <button class="us-btn">Дать обещание</button>
                </div>
              </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
      <div class="promo-block">
        <div class="wrapper">
          <div class="text">Каждый раз, выполняя обещания, вы становитесь чуточку лучше.Мы тоже хотим вам пообещать <a href="#">кое-что</a></div>
          <div class="logo"></div>
        </div>
      </div>


@stop


@section('scripts')
  <script>SplatSite.Promise();</script>
@stop