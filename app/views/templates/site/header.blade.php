   <div class="main-wrapper"> 
    <header class="main-header bordered">
      <div class="wrapper">
        <div class="user-links">
        @if (!isset($auth_user) || !is_object($auth_user) || !$auth_user->id)
            <a href="#"><span data-box="auth" class="js-open-box">Войти</span></a>
            <a href="#"><span data-box="auth" class="js-open-box">Зарегистрироваться</span></a>
        @else
            <a href="{{ URL::route('app.mainpage') }}"><span data-box="auth_" class="js-open-box_">Главная</span></a>
            <a href="{{ URL::route('app.me') }}"><span data-box="auth_" class="js-open-box_">Мои Обещания</span></a>
            <a href="#"><span data-box="auth_" class="js-open-box_ logout">Выйти</span></a>
        @endif
        </div>
        <ul class="soc-links">
          <li><a href="http://www.facebook.com/sharer.php?u=http://mypromises.ru" class="soc-icon"><i class="fi icon-fb"></i></a></li>
          <li><a href="http://vk.com/share.php?url=http://mypromises.ru&event=button_share" class="soc-icon"><i class="fi icon-vk"></i></a></li>
          <li><a href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=mypromises.ru" class="soc-icon"><i class="fi icon-ok"></i></a></li>
        </ul>
        <div class="logo-text">Мои обещания</div>
        <div class="header-desc">
          <div class="desc-cont">Обещания не просто слова. Когда о них говорят дела</div>
        </div>
      </div>
    </header>
