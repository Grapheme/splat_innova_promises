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
        Пожалуйста подтвердите свои данные.

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
                  Пожалуйста, подтвердите ваши данные.
            @elseif ($msg == 'odnoklassniki')
                Вы успешно зарегистрировались через соц.сеть Одноклассники.<br/>
                  Пожалуйста, подтвердите ваши данные.
            @elseif ($msg == 'facebook')
                Вы успешно зарегистрировались через соц.сеть Facebook.<br/>
                  Пожалуйста, подтвердите ваши данные.
            @endif
        </div>
        </div>
        <div class="profile-edit">

        <?
        $default_avatar = '/theme/images/man.png';
        if (isset($user->sex) && $user->sex == 1)
            $default_avatar = '/theme/images/woman.png';
        ?>

          <form action="{{ URL::route('app.update_avatar') }}" method="POST" enctype="multipart/form-data" class="photo-cont" id="avatar-form">
            <div>
              <div style="background-image: url({{ $user->avatar ?: $default_avatar }});" class="profile-photo">
                <div class="profile-hover">

                    <a href="#" class="down-link">
                        <div class="fi icon-arrow-down"></div>
                        <input name="avatar" type="file" accept="image/*">
                    </a>
                    {{--
                    <a href="#" class="remove-link">
                        <div class="fi icon-cross"></div>
                    </a>
                    --}}
                </div>
              </div>
            </div>
          </form>

          <form action="{{ URL::route('app.update_profile') }}" method="POST" class="edit-cont" id="profile_form">
            <div>
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

              @if ($new_user)
              <div class="check-cont">
                <label for="apply"><span class="check-fake check-dark"><i class="fi icon-check"></i></span>Подтверждаю ознакомление с <a target="_blank" href="http://mypromises.ru/privacy_policy.pdf">правилами пользования</a></label>
                  <input type="checkbox" name="confirmation" id="apply" class="styledCheck">
              </div>
              @endif

              <div class="input-cont">
                  <label for="n1"><span class="check-fake check-dark"><i class="fi icon-check"></i></span>
                      Оповещать меня о новых комментариях
                  </label>
                  <input type="checkbox" name="notification_new_comment" id="n1" class="styledCheck">
              </div>
              <div class="input-cont">
                  <label for="n2"><span class="check-fake check-dark"><i class="fi icon-check"></i></span>
                      Напоминать мне о дате выполнения моих обещаний
                  </label>
                  <input type="checkbox" name="notification_promise_dates" id="n2" class="styledCheck">
              </div>
              <div class="input-cont">
                  <label for="n3"><span class="check-fake check-dark"><i class="fi icon-check"></i></span>
                      Оповещать о смене статуса моих обещаний
                  </label>
                  <input type="checkbox" name="notification_promise_status" id="n3" class="styledCheck">
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
<script>

    $('input[type="file"]').on('change', function(){
        $(this).parents('form').submit();
    });


    $("#avatar-form").validate({
        rules: {
            //'avatar': { required: true },
        },
        messages: {
            //'avatar': "",
        },
        errorClass: "inp-error",
        submitHandler: function(form) {
            //console.log(form);
            sendAvatarForm(form);
            return false;
        }
    });

    function sendAvatarForm(form) {

        //console.log(form);
        var options = { target: null, type: $(form).attr('method'), dataType: 'json' };

        options.beforeSubmit = function(formData, jqForm, options){
            //$(form).find('button').addClass('loading').attr('disabled', 'disabled');
            //$(form).find('.error-msg').text('');
            //$('.error').text('').hide();
        }

        options.success = function(response, status, xhr, jqForm){
            //console.log(response);
            //$('.success').hide().removeClass('hidden').slideDown();
            //$(form).slideUp();

            if (response.status) {
                /*
                $(form).find('button').addClass('success').text('Отправлено');
                $(form).find('.popup-body').slideUp(function(){
                    setTimeout(function(){ $('.popup .js-popup-close').trigger('click'); }, 3000);
                });
                */
                //$(form).slideUp();
                $(form).find('.profile-photo').attr('style', 'background-image: url(' + response.new_avatar + ');');

            } else {
                //$('.response').text(response.responseText).show();
            }

        }

        options.error = function(xhr, textStatus, errorThrown){
            console.log(xhr);
            $(form).find('button').removeAttr('disabled');
            $(form).find('.error-msg').text('Ошибка при отправке, попробуйте позднее');
        }

        options.complete = function(data, textStatus, jqXHR){
            //$(form).find('button').removeClass('loading').removeAttribute('disabled');
        }

        $(form).ajaxSubmit(options);
    }

    </script>
@stop