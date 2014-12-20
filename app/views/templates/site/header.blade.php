   <div class="main-wrapper"> 
    <header class="main-header bordered">
      <div class="wrapper">
        <div class="user-links">
        @if (!isset($auth_user) || !is_object($auth_user) || !$auth_user->id)
            <a href="#"><span data-box="auth" class="js-open-box" onclick="ga('send', 'event', 'header', 'login');">Войти</span></a>
            <a href="#"><span data-box="reg" class="js-open-box" onclick="ga('send', 'event', 'header', 'register');">Зарегистрироваться</span></a>
        @else
            <!-- <a href="{{ URL::route('app.mainpage') }}"><span data-box="auth_" class="js-open-box_">Главная</span></a> -->
            <!-- <a href="{{ URL::route('app.me') }}"><span data-box="auth_" class="js-open-box_">Мои Обещания</span></a> -->
            <a href="{{ URL::route('app.me') }}"><span data-box="auth_" class="js-open-box_">Мой профиль</span></a>
            <a href="#"><span data-box="auth_" class="js-open-box_ logout">Выйти</span></a>
        @endif
          <a href="#"><span data-box="restore" class="js-open-box"></span></a>
        </div>
        <ul class="soc-links">
          <li><a target="_blank" onclick="ga('send', 'event', 'like', 'facebook');" href="http://www.facebook.com/sharer.php?u=http://mypromises.ru" class="soc-icon"><i class="fi icon-fb"></i></a></li>
          <li><a target="_blank" onclick="ga('send', 'event', 'like', 'vkontakte');" href="http://vk.com/share.php?url=http://mypromises.ru&event=button_share" class="soc-icon"><i class="fi icon-vk"></i></a></li>
          <li><a target="_blank" onclick="ga('send', 'event', 'like', 'odnoklassniki');" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=mypromises.ru" class="soc-icon"><i class="fi icon-ok"></i></a></li>
          <li class="soc-text"><span>Поделиться с друзьями</span></li>
        </ul>
        <a href="{{ URL::route('app.mainpage') }}" class="logo-text">Мои обещания</a>
        <div class="header-desc">
          <div class="desc-cont">НАШИ СЛОВА МЕНЯЮТ МИР, КОГДА СТАНОВЯТСЯ ДЕЛАМИ</div>
        </div>
      </div>
    </header>
