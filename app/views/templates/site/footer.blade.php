  </div>
</div>
  <footer class="main-footer">
    <div class="wrapper">
      <div class="footer-block left-logo"><span>Мои<br>Обещания</span></div>
      <div class="footer-block">
        <ul class="footer-links">
          <li><a target="_blank" href="http://mypromises.ru/privacy_policy.pdf">Правила использования</a></li>
          <li><a onclick="ga('send', 'event', 'footer', 'feedback');" href="mailto:hello@mypromises.ru?subject=У меня есть предложение&body=Здравствуйте! Я бы хотел предложить ...">Обратная связь</a></li>
          <li><a href="http://mypromises.ru/sitemap">Карта сайта</a></li>
        </ul>
      </div>
      <div class="footer-block"><span>Поделиться с друзьями:</span>
        <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="small" data-yashareQuickServices="vkontakte,facebook,odnoklassniki" data-yashareTheme="counter"></div>
        <!-- <ul class="footer-soc">
          <li><a onclick="ga('send', 'event', 'like', 'facebook');" href="http://www.facebook.com/sharer.php?u=http://mypromises.ru" target="_blank" class="soc-icon"><i class="fi icon-fb"></i></a></li>
          <li><a onclick="ga('send', 'event', 'like', 'vkontakte');" href="http://vk.com/share.php?url=http://mypromises.ru&event=button_share" target="_blank" class="soc-icon"><i class="fi icon-vk"></i></a></li>
          <li><a onclick="ga('send', 'event', 'like', 'odnoklassniki');" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=mypromises.ru" target="_blank" class="soc-icon"><i class="fi icon-ok"></i></a></li>
        </ul> -->
      </div>
      <a onclick="ga('send', 'event', 'footer', 'brand');" href="http://splat.ru" target="_blank" class="footer-block right-logo"></a>
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
          <div class="desc">Данные вами обещания обязательно должны превратиться в дела.<br>Авторизируйтесь на сайте через социальную сеть, чтобы ваши друзья могли поддержать вас.</div>
          <div class="soc-auth">
            <a href="#" class="soc-fb fb-oauth-link" onclick="ga('send', 'event', 'auth', 'facebook');">
                <i class="fi icon-fb"></i>Facebook
            </a>
            <a href="#" class="soc-vk vk-oauth-link" onclick="ga('send', 'event', 'auth', 'vkontakte');">
                <i class="fi icon-vk"></i>Вконтакте
            </a>
            <a href="#" class="soc-ok ok-oauth-link" data-domain="{{ domain }}" onclick="ga('send', 'event', 'auth', 'odnoklassniki');">
                <i class="fi icon-ok"></i>Одноклассники
            </a>
          </div>
          <div class="desc">или с помощью адреса электронной почты:</div>
          <div data-type="auth" class="form-inputs js-pop-form">

            <form action="{{ URL::route('app.email-pass-auth') }}" method="POST" class="auth_form_validate">
              <input type="hidden" name="promise_text">
              <div class="input-cont">
                <input type="email" name="email" placeholder="Эл. почта">
              </div>
              <div class="input-cont">
                <input type="password" name="pass" placeholder="Пароль">
              </div>
              <div class="btns">
                <button class="us-btn" onclick="ga('send', 'event', 'auth', 'email');">Войти</button><a href="#" class="right-link js-change-box" data-box="restore">Забыли пароль?</a><a href="#" class="right-link js-change-box" data-box="reg">Регистрация</a>
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
          <!--<li class="about-new"><span class="icon"></span><span class="text">В новогоднюю ночь сбываются чудеса, а люди во всем мире дают друг другу обещания, которые порой так трудно исполнить.</span></li>-->
        </ul>
      </div>
    </div>
    <div data-box="restore" class="popup auth-popup js-pop-up"><a href="#" class="popup-close js-pop-close"><span></span></a>
      <div class="restore-form">
        <div class="form-inputs">
          <form action="{{ URL::route('app.do_restore_password') }}" class="js-ajax-form">
            <div class="js-ajax-before">
              <div class="input-title">Восстановление пароля</div>
              <div class="input-cont">
                <input name="email" placeholder="Укажите е-мейл" class="us-input">
              </div>
              <div class="btns">
                <button class="us-btn" type="submit">Восстановить</button>
              </div>
            </div>
            <div class="js-ajax-after">
              <div class="input-title js-ajax-result"></div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div data-box="reg" class="popup auth-popup js-pop-up"><a href="#" class="popup-close js-pop-close"><span></span></a>
      <div class="wrapper">
        <div style="display: none;" class="title js-promise-title"></div>
      </div>
      <div class="form-block">
        <div class="wrapper">
          <div class="desc">Данные вами обещания обязательно должны превратиться в дела.<br>Зарегистрируйтесь на сайте через социальную сеть, чтобы ваши друзья могли поддержать вас.</div>
          <div class="soc-auth">
            <a href="#" class="soc-fb fb-oauth-link" onclick="ga('send', 'event', 'auth', 'facebook');">
                <i class="fi icon-fb"></i>Facebook
            </a>
            <a href="#" class="soc-vk vk-oauth-link" onclick="ga('send', 'event', 'auth', 'vkontakte');">
                <i class="fi icon-vk"></i>Вконтакте
            </a>
            <a href="#" class="soc-ok ok-oauth-link" data-domain="{{ domain }}" onclick="ga('send', 'event', 'auth', 'odnoklassniki');">
                <i class="fi icon-ok"></i>Одноклассники
            </a>
          </div>
          <div class="desc">или с помощью адреса электронной почты:</div>
          <div data-type="auth" class="form-inputs">

            <form action="{{ URL::route('app.email-pass-auth') }}" method="POST" class="reg_form_validate">
              <input type="hidden" name="promise_text">
              <div class="input-cont">
                <input type="email" name="email" placeholder="Эл. почта">
              </div>
              <div class="input-cont">
                <input type="password" name="pass" placeholder="Пароль">
              </div>
              <div class="btns">
                <button class="us-btn" onclick="ga('send', 'event', 'register', 'email');">Зарегистрироваться</button><a href="{{ URL::route('app.restore_password') }}" class="right-link js-change-box" data-box="auth">У меня уже есть аккаунт!</a>
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
          <!--<li class="about-new"><span class="icon"></span><span class="text">В новогоднюю ночь сбываются чудеса, а люди во всем мире дают друг другу обещания, которые порой так трудно исполнить.</span></li>-->
        </ul>
      </div>
    </div>
    <div data-box="promo" class="popup promo-popup js-pop-up"><a href="#" class="popup-close js-pop-close"><span></span></a>
      <div class="promo-box">
        <div class="logo"></div>
        <div class="text">
        	<? if (rand(0,1) == 0): ?>
          Обещания не просто слова, когда о них говорят дела. Мы обещаем себе <br>и вам каждый день 
          делать самые лучшие продукты по уходу за полостью рта. <br>Чтобы помогать вам быть 
          здоровыми, красивыми и успешными. <br> 
          Команда SPLAT
          <? else: ?>
          Мы обещаем делать счастливым хотя бы одного человека в день! <br>Команда SPLAT
          <? endif; ?>
        </div>
        <div class="spec-link"><a href="http://www.splat.ru" target="_blank">Узнать больше</a></div>
      </div>
    </div>
  </div>
