  </div>
</div>
  <footer class="main-footer">
    <div class="wrapper">
      <div class="footer-block left-logo"><span>Мои<br>Обещания</span></div>
      <div class="footer-block">
        <ul class="footer-links">
          <!-- <li><a href="#">О проекте</a></li> -->
          <li><a target="_blank" href="http://mypromises.ru/privacy_policy.pdf">Правила использования</a></li>
        </ul>
      </div>
      <div class="footer-block"><span>Поделиться с друзьями:</span>
        <ul class="footer-soc">
          <li><a href="http://www.facebook.com/sharer.php?u=http://mypromises.ru" target="_blank" class="soc-icon"><i class="fi icon-fb"></i></a></li>
          <li><a href="http://vk.com/share.php?url=http://mypromises.ru&event=button_share" target="_blank" class="soc-icon"><i class="fi icon-vk"></i></a></li>
          <li><a href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=mypromises.ru" target="_blank" class="soc-icon"><i class="fi icon-ok"></i></a></li>
        </ul>
      </div>
      <a href="http://ru.innova-oralcare.com" target="_blank" class="footer-block right-logo"></a>
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
          <div class="soc-auth">
            <a href="#" class="soc-fb fb-oauth-link">
                <i class="fi icon-fb"></i>Facebook
            </a>
            <a href="#" class="soc-vk vk-oauth-link">
                <i class="fi icon-vk"></i>Вконтакте
            </a>
            <a href="#" class="soc-ok ok-oauth-link" data-domain="{{ domain }}">
                <i class="fi icon-ok"></i>Одноклассники
            </a>
          </div>
          <div class="desc">или с помощью адреса электронной почты:</div>
          <div data-type="auth" class="form-inputs js-pop-form">

            <form action="{{ URL::route('app.email-pass-auth') }}" method="POST" id="auth_form">
              <input type="hidden" name="promise_text">
              <div class="input-cont">
                <input type="email" name="email" placeholder="Эл. почта" required>
              </div>
              <div class="input-cont">
                <input type="password" name="pass" placeholder="Пароль" required>
              </div>
              <div class="btns">
                <button class="us-btn">Войти</button><a href="{{ URL::route('app.restore_password') }}" class="right-link js-form-pass">восстановить пароль</a>
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
    <div data-box="promo" class="popup promo-popup js-pop-up"><a href="#" class="popup-close js-pop-close"><span></span></a>
      <div class="promo-box">
        <div class="logo"></div>
        <div class="text">Мы обещаем, что через месяц использования зубных средств <b>innova</b><br>ваши зубы станут менее чувствительными, эмаль восстановится,<br>а вы почувствуете уверенность в себе и раскрепощённость.</div>
        <div class="spec-link"><a href="http://www.splat-innova.com" target="_blank">Узнать больше</a></div>
      </div>
    </div>
  </div>
