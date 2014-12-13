@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

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

    @endif



      <div class="wrapper">
        <div class="profile-message">
          <div class="icon">
            <div class="fi icon-smile"></div>
          </div>
          <div class="text">
            @if ($msg == 'vkontakte')
                Вы успешно зарегистрировались через соц.сеть ВКонтакте.<br/>
            @elseif ($msg == 'odnoklassniki')
                Вы успешно зарегистрировались через соц.сеть Одноклассники.<br/>
            @elseif ($msg == 'facebook')
                Вы успешно зарегистрировались через соц.сеть Facebook.<br/>
            @endif
            Пожалуйста, подтвердите ваши данные.
        </div>
        </div>
        <div class="profile-edit">


          <form action="{{ URL::route('app.update_profile') }}" method="POST">
            <div class="photo-cont">
              <div style="background-image: url({{ $user->avatar }});" class="profile-photo">
                <div class="profile-hover"><a href="#" class="down-link">
                    <div class="fi icon-arrow-down"></div>
                    <input type="file"></a><a href="#" class="remove-link">
                    <div class="fi icon-cross"></div></a></div>
              </div>
            </div>
            <div class="edit-cont">
              <div class="input-cont">
                <input name="name" value="{{ trim($user->name) }}" placeholder="Ваше имя" class="us-input">
              </div>
              <div class="input-cont">
                <input name="email" value="{{ $user->email }}" placeholder="Укажите e-mail" class="us-input">
              </div>
              <div class="input-hint">Обязательно укажите е-mail, которым вы пользуетесь, чтобы мы могли напомнить о вашем обещании.</div>
              <div class="input-cont">
                <input name="bdate" value="{{ $user->bdate }}" placeholder="Ваша дата рождения" class="us-input js-mask-date">
              </div>
              <div class="check-cont">
                <input type="checkbox" name="confirmation" id="apply" class="styledCheck">
                <label for="apply"><span class="check-fake"><i class="fi icon-check"></i></span>Подтверждаю ознакомление с <a href="http://mypromises.ru/privacy_policy.pdf">правилами пользования</a></label>
              </div>
              <div class="btn-cont">
                <button class="us-btn">Сохранить</button>
              </div>
            </div>
          </form>


        </div>
      </div>





@stop


@section('scripts')

@stop