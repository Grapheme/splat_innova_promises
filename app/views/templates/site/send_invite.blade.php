@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

        <big>{{ $user_name }}</big>

        <br/>

        {{ $user_name }} не дал еще ни одного обещания. Пригласите!
        <form action="{{ URL::route('app.send_invite_message') }}" method="POST">
            <input type="text" name="email" placeholder="Введите e-mail">
            <button>Пригласить</button>
        </form>

        <hr/>

        DEBUG:
        {{ Helper::d(@$_SESSION) }}
        {{ Helper::d(@$_COOKIE) }}
        {{ Helper::ta_(@$promises) }}

    @endif

      <div class="profile-page">
        <div class="wrapper">
          <div class="profile-card">
            <div style="background-image: url(http://img0.liveinternet.ru/images/attach/c/6/102/827/102827412_1346919545_0107400x320.jpg);" class="profile-photo"></div>
            <div class="profile-info profile-invite">
              <div class="info-cont">
                <div class="name"><span>{{ $user_name }}</span></div>
                <div class="age">28 лет</div>
                <div class="invite-info">
                  <p>Ваш друг {{-- из Facebook --}} не дал еще ни одного обещания. </p>
                  <p>Пригласите вашего друга и расскажите ему о том, почему так важно сдерживать данные обещания.</p>
                  <div class="inv-form">
                    <div class="inv-btn js-inv-btn-cont"><a href="#" class="us-btn js-inv-btn">Пригласить друга</a></div>
                    <div style="display: none;" class="form js-inv-form">
                      <div id="send-invite-success" style="display:none">
                        Приглашение успешно отправлено.
                      </div>
                      <form action="{{ URL::route('app.send_invite_message') }}" method="POST" id="invite-form">
                          <input name="email" placeholder="E-mail друга" class="us-input">
                          <input type="hidden" name="name" value="{{ $user_name }}">
                          <button class="us-btn">Пригласить</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


@stop


@section('scripts')
  <script>SplatSite.InviteForm();</script>
  <script>

    $("#invite-form").validate({
        rules: {
            'email': { required: true, email: true },
        },
        messages: {
            'email': "",
        },
        errorClass: "inp-error",
        submitHandler: function(form) {
            //console.log(form);
            sendInviteForm(form);
            return false;
        }
    });

    function sendInviteForm(form) {

        //console.log(form);
        var options = { target: null, type: $(form).attr('method'), dataType: 'json' };

        options.beforeSubmit = function(formData, jqForm, options){
            $(form).find('button').addClass('loading').attr('disabled', 'disabled');
            $(form).find('.error-msg').text('');
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
                $(form).slideUp();
                $("#send-invite-success").slideDown();

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
            $(form).find('button').removeClass('loading').removeAttribute('disabled');
        }

        $(form).ajaxSubmit(options);
    }

</script>
@stop