  <footer class="main-footer">
    <div class="wrapper">
      <div class="footer-block left-logo"><span>Мои<br>Обещания</span></div>
      <div class="footer-block">
        <ul class="footer-links">
          <li><a href="#">О проекте</a></li>
          <li><a href="#">Правила использования</a></li>
        </ul>
      </div>
      <div class="footer-block"><span>Поделиться с друзьями:</span>
        <ul class="footer-soc">
          <li><a href="#" class="soc-icon"><i class="fi icon-fb"></i></a></li>
          <li><a href="#" class="soc-icon"><i class="fi icon-vk"></i></a></li>
          <li><a href="#" class="soc-icon"><i class="fi icon-twitter"></i></a></li>
        </ul>
      </div>
      <div class="footer-block right-logo"></div>
    </div>
  </footer>
  <div class="overlay-shadow"></div>
  <div class="overlay">
    <div data-box="auth" class="popup auth-popup js-pop-up"><a href="#" class="popup-close js-pop-close"><span></span></a>
      <div class="wrapper">
        <div style="display: none;" class="title js-promise-title"></div>
      </div>
      <div class="form-block">
        <div class="wrapper">
          <div class="desc">Для того, чтобы сохранить ваше обещание, вам необходимо зарегистрироваться на нашем сайте<br>с помощью одной из этих социальных сетей:</div>
          <ul class="soc-auth">
            <li class="soc-fb">
                <i class="fi icon-fb"></i>Facebook

                <!--
                  Below we include the Login Button social plugin. This button uses
                  the JavaScript SDK to present a graphical Login button that triggers
                  the FB.login() function when clicked.
                -->
                <div id="fb-root"></div>
                <fb:login-button scope="public_profile,email,user_birthday,user_photos,user_friends,user_about_me,user_hometown" onlogin="checkLoginState();">
                </fb:login-button>

            </li>
            <li class="soc-vk"><i class="fi icon-vk"></i>Вконтакте</li>
            <li class="soc-ok"><i class="fi icon-ok"></i>Одноклассники<a href="#" class="ok-oauth-link" data-domain="{{ domain }}">ВОЙТИ</a></li>
          </ul>
          <div class="desc">или с помощью адреса электронной почты:</div>
          <div data-type="auth" class="form-inputs js-pop-form">
            <form>
              <input type="hidden" name="promise-text">
              <div class="input-cont">
                <input placeholder="Эл. почта">
              </div>
              <div class="input-cont">
                <input placeholder="Пароль">
              </div>
              <div class="btns">
                <button class="us-btn">Войти</button><a href="#" class="right-link js-form-pass">восстановить пароль</a>
              </div>
            </form>
          </div>
          <div data-type="pass" style="display: none;" class="form-inputs js-pop-form">
            <form>
              <div class="input-cont">
                <input placeholder="Эл. почта">
              </div>
              <div class="btns">
                <button class="us-btn">Восстановить</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="wrapper">
        <ul class="auth-desc">
          <li class="about-soc"><span class="icon"></span><span class="text">Выберите ту социальную сеть, в которой сможете рассказать о данном вами обещании.</span></li>
          <li class="about-dif"><span class="icon"></span><span class="text">У вас появится возможность выбрать различные варианты оформления карточек с обещаниями.</span></li>
          <li class="about-sav"><span class="icon"></span><span class="text">Вы сможете сохранить ваше обещание, а мы будем напоминать вам о нем.</span></li>
          <li class="about-new"><span class="icon"></span><span class="text">В новогоднюю ночь сбываются чудеса, а люди во всем мире дают друг другу обещания, которые порой так трудно исполнить.</span></li>
        </ul>
      </div>
    </div>
  </div>
