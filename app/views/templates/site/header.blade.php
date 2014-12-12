  <header class="main-header">
    <div class="wrapper">
      <div class="user-links">
      @if (!isset($user) || !is_object($user) || !$user->id)
        <a href="#"><span data-box="auth" class="js-open-box">Войти</span></a>
        <a href="#"><span data-box="auth" class="js-open-box">Зарегистрироваться</span></a>
      @else
        <a href="{{ URL::route('app.mainpage') }}"><span data-box="auth_" class="js-open-box_">Мой Профиль</span></a>
        <a href="{{ URL::route('app.mainpage') }}"><span data-box="auth_" class="js-open-box_">Мои Обещания</span></a>
        <a href="#"><span data-box="auth_" class="js-open-box_ logout">Выйти</span></a>
      @endif
      </div>
      <ul class="soc-links">
        <li><a href="#" class="soc-icon"><i class="fi icon-fb"></i></a></li>
        <li><a href="#" class="soc-icon"><i class="fi icon-vk"></i></a></li>
        <li><a href="#" class="soc-icon"><i class="fi icon-ok"></i></a></li>
      </ul>
      <div class="logo-text">Мои обещания</div>
      <div class="header-desc">
        <div class="desc-cont">Обещания не просто слова. Когда о них говорят дела</div>
      </div>
    </div>
  </header>
