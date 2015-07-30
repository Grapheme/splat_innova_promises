@extends(Helper::layout())


@section('style')
@stop


@section('content')

	<div class="wrapper">
	  <div class="normal-wrapper">
	    <div class="normal-title">Восстановление пароля</div>
	    <div class="normal-text">
	      <form action="{{ URL::route('app.do_restore_password') }}" method="POST">

	          {{ Session::get('msg') }}<br/>

	          <p>Введите свой адрес электронной почты:</p>
	          <div>
	          	<input type="text" name="email" value="" placeholder="Укажите ваш e-mail">
	          </div>
	          <button class="us-btn" type="submit">Сбросить пароль</button><br/>

	      </form>
	    </div>
	  </div>
	</div>
    

@stop


@section('scripts')

@stop