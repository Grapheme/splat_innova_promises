@extends(Helper::layout())


@section('style')
@stop


@section('content')
	
    

    <div class="wrapper">
      <div class="normal-wrapper">
        <div class="normal-title">Восстановление пароля</div>
        <div class="normal-text">
          <form action="{{ URL::route('app.restore_password_set_new_password') }}" method="POST">

              <p>{{ Session::get('msg') }}</p>

            <div class="restore-block">
              <p>Введите новый пароль:</p>
              <div class="input-container">
              	<input class="us-input" type="password" name="password" value="">
              </div>
              <input type="hidden" name="token" value="{{ $token }}">
              <div class="input-container">
              	<button class="us-btn" type="submit">Сбросить пароль</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>

@stop


@section('scripts')

@stop