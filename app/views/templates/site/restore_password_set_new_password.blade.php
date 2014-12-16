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

              <p>Введите новый пароль:</p>
              <div class="input-container">
              	<input class="us-btn" type="password" name="password" value="">
              </div>
              <div class="input-container">
              	<input class="us-btn" type="hidden" name="token" value="{{ $token }}">
              </div>
              <div class="input-container">
              	<button type="submit">Сбросить пароль<button>
              </div>

          </form>
        </div>
      </div>
    </div>

@stop


@section('scripts')

@stop