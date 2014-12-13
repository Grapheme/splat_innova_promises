@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

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

    @endif

      <div class="profile-page">
        <div class="wrapper">
          <div class="profile-card">
            <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
            <div class="profile-info profile-invite">
              <div class="info-cont">
                <div class="name"><span>{{ $user_name }}</span></div>
                <div class="age">28 лет</div>
                <div class="invite-info">
                  <p>Ваш друг {{-- из Facebook --}} не дал еще ни одного обещания. </p>
                  <p>Пригласите вашего друга и расскажите ему о том, почему так важно сдерживать данные обещания.</p>
                  <div class="inv-form">
                    <div class="inv-btn js-inv-btn-cont"><a href="#" class="us-btn js-inv-btn">Пригласить друга</a></div>
                    <div style="display: none;" class="form js-inv-form">
                          <input name="email" placeholder="E-mail друга" class="us-input">
                          <button class="us-btn">Пригласить</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


@stop


@section('scripts')

@stop