@extends(Helper::layout())



<?
$fb_app_id = '1010986995584773';
$fb_friends_limit = 99;
?>


@section('style')
@stop


@section('content')

    <form action="#" method="POST" id="auth_form">

        Я обещаю, что...<br/>
        <textarea class="promise_text"></textarea><br/>
        <input type="button" value="Дать обещание">

        <br/>
        <br/>

        Войдите с помощью ВКонтакте (uLogin):
        <script src="//ulogin.ru/js/ulogin.js"></script><div id="uLogin_c0a8a519" data-uloginid="c0a8a519"></div>

        или адреса электронной почты:<br/>

        почта <input type="text" name="email"><br/>
        пароль <input type="password" name="pass">

    </form>

    <hr/>

    DEBUG:
    {{ Helper::d(@$_SESSION) }}
    {{ Helper::d(@$_COOKIE) }}
    {{ Helper::ta_(@$promises) }}

    <hr/>




    <!--
    https://developers.facebook.com/docs/javascript/reference/v2.2?locale=ru_RU
    https://developers.facebook.com/docs/facebook-login/permissions/v2.2?locale=ru_RU
    http://stackoverflow.com/questions/23417356/facebook-graph-api-v2-0-me-friends-returns-empty-or-only-friends-who-also-u
    https://developers.facebook.com/apps/1010986995584773/review-status/
    -->
    <script>
      // This is called with the results from from FB.getLoginStatus().
      function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().

        if (response.status === 'connected') {

          // Logged into your app and Facebook.
          //testAPI();
          fbConnected();

        } else if (response.status === 'not_authorized') {

          // The person is logged into Facebook, but not your app.
          //document.getElementById('status').innerHTML = 'Please log into this app.';

        } else {

          // The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
          //document.getElementById('status').innerHTML = 'Please log into Facebook.';
        }
      }

      // This function is called when someone finishes with the Login Button.
      // See the onlogin handler attached to it in the sample code below.
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }

      window.fbAsyncInit = function() {
          FB.init({
            appId   : '{{ $fb_app_id }}',
            status: true,
            oauth: true,
            cookie  : true,  // enable cookies to allow the server to access the session
            xfbml   : true,  // parse social plugins on this page
            version : 'v2.1' // use version 2.1
          });

          // Now that we've initialized the JavaScript SDK, we call
          // FB.getLoginStatus().  This function gets the state of the
          // person visiting this page and can return one of three states to
          // the callback you provide.  They can be:
          //
          // 1. Logged into your app ('connected')
          // 2. Logged into Facebook, but not your app ('not_authorized')
          // 3. Not logged into Facebook and can't tell if they are logged into
          //    your app or not.
          //
          // These three cases are handled in the callback function.

          FB.getLoginStatus(function(response) {
            //statusChangeCallback(response);
          });

      };

      // Load the SDK asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      // Here we run a very simple test of the Graph API after login is
      // successful. See statusChangeCallback() for when this call is made.
      function fbConnected() {

        console.log('Welcome! Fetching your information.... ');

        FB.api('/me', function(response) {

          console.log('Successful login for: ' + response.name);
          console.log(response)
          document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.name + '!';

            /**
             * FB - Отправляем запрос на сервер для добавления пользователя
             */
            var promise_text = $('.promise_text').val();
            var data = response;
            data.identity = response.link;
            data.network = 'facebook';
            $.ajax({
                url: base_url + '/user-auth',
                type: 'POST',
                dataType: 'json',
                data: { data: data, promise_text: promise_text }
            })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    //alert('ERROR');
                    console.log(textStatus);
                })
                .done(function(response) {

                    //alert("SUCCESS");
                    console.log(response);

                    if (typeof response.status != 'undefined' && response.status && typeof response.user != 'undefined') {

                        var user_data = response;
                        //console.log('token => ' + user_data.user.user_token);
                        setCookie("user_token", user_data.user.user_token, "Mon, 01-Jan-2018 00:00:00 GMT", "/");

                        /**
                         * Отправляем запрос к VK для получения списка друзей
                         */
                        if (typeof data.network != 'undefined' && data.network == 'facebook') {

                            // get friends
                            FB.api('/me/taggable_friends?limit=<?=$fb_friends_limit?>', function(response) {

                                console.log('FB taggable friends list:');
                                console.log(response);

                                var result_holder = document.getElementById('result_friends');
                                //var friend_data = response.data.sort(sortMethod);
                                var friend_data = response.data;

                                var results = '';
                                for (var i = 0; i < friend_data.length; i++) {
                                    //results += '<div><img src="https://graph.facebook.com/' + friend_data[i].id + '/picture">' + friend_data[i].name + '</div>';
                                    results += '<div><img src="' + friend_data[i].picture.data.url + '">' + friend_data[i].name + '</div>';
                                }

                                // and display them at our holder element
                                result_holder.innerHTML = '<h2>Список ваших друзей:</h2>' + results;
                            });

                            // get friends
                            FB.api('/me/friends?limit=<?=$fb_friends_limit?>', function(response) {

                                console.log('FB friends list:');
                                console.log(response);
                            });

                        }

                    }


                })
            ;


        });
      }
    </script>

    <!--
      Below we include the Login Button social plugin. This button uses
      the JavaScript SDK to present a graphical Login button that triggers
      the FB.login() function when clicked.
    -->

    <div id="fb-root"></div>
    <fb:login-button scope="public_profile,email,user_birthday,user_photos,user_friends" onlogin="checkLoginState();">
    </fb:login-button>
    <div id="status"></div>
    <div id="result_friends"></div>







    <hr/>





    <!--
    http://api.mail.ru/docs/guides/ok_sites/
    -->
    <link href="http://www.odnoklassniki.ru/oauth/resources.do?type=css" rel="stylesheet">
    <script src="http://www.odnoklassniki.ru/oauth/resources.do?type=js" type="text/javascript" charset="utf-8">
    </script>

    <a class="odkl-oauth-lnk" href=""
         onclick="ODKL.Oauth2(this, 1110811904, 'SET STATUS;VALUABLE ACCESS;PHOTO CONTENT', 'http://splat.dev.grapheme.ru/ok-oauth' ); return false;">
    </a>

@stop


@section('scripts')

@stop