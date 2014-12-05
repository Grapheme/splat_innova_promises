
$(document).ready(function($){
    var ulogintoken;
    //var ulogintoken = getCookie("ulogintoken");
    //if (ulogintoken != '')
    //    uloginauth(ulogintoken);
});


$(document).on('click', '.logout', function(e){
	e.preventDefault();
    setCookie("user_token", null);
    location.href = location.href;
});


/**
 * Callback-функция, вызывается после авторизации через ulogin
 * @param token
 */
function uloginauth(token) {

    if(typeof ulogintoken == "undefined")
        setCookie("ulogintoken", token, "Mon, 01-Jan-2018 00:00:00 GMT", "/");
        
    $.getJSON("//ulogin.ru/token.php?host=" + encodeURIComponent(location.toString()) + "&token=" + token + "&callback=?", function(data){

        data = $.parseJSON(data.toString());
        console.log(data);

        if(!data.error){

            //alert("Привет, "+data.first_name+" "+data.last_name+"!");

            /**
             * Сохраняем текст в поле обещания
             */
            var promise_text = $('.promise_text').val();
            //alert(promise_text); return;

            /**
             * Отправляем запрос на сервер для добавления пользователя
             */
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
                        if (typeof data.network != 'undefined' && data.network == 'vkontakte') {

                            /**
                             * https://vk.com/dev/api_requests
                             * https://vk.com/dev/friends.get
                             */
                            $.ajax({
                                url: 'https://api.vk.com/method/friends.get',
                                type: 'POST',
                                dataType: 'jsonp',
                                data: {
                                    user_id: data.uid,
                                    fields: 'nickname, domain, sex, bdate, country, city',
                                    name_case: 'nom'
                                }
                            })
                                .done(function (response) {
                                    //alert("SUCCESS");
                                    //console.log(response);
                                    //console.log(response.response.length);
                                    if (response.response.length) {

                                        /**
                                         * Сохраняем список друзей пользователя
                                         */
                                        console.log(response);

                                        $.ajax({
                                            url: base_url + '/user-update-friends',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {user_id: user_data.user.id, friends: response.response}
                                        })
                                            .done(function (response) {
                                                //alert("SUCCESS");
                                                console.log(response);

                                                //alert('RELOAD PAGE');
                                                location.href = base_url + '';
                                            })
                                            .fail(function (jqXHR, textStatus, errorThrown) {
                                                //alert('ERROR');
                                                console.log(textStatus);
                                            })
                                        ;

                                    }
                                })
                                .fail(function (jqXHR, textStatus, errorThrown) {
                                    //alert('ERROR');
                                    console.log(textStatus);
                                })
                                .always(function (response) {
                                    //console.log(response);
                                    //alert( "complete" );
                                })
                            ;

                        }

                    }

                })
            ;


        } else {

            if (data.error == 'token expired') {

                // Token expired
                setCookie("ulogintoken", null);
                //alert('Ваша сессия завершена. Пожалуйста, повторите вход');

            } else if (data.error == 'invalid token') {

                // Invalid token
                setCookie("ulogintoken", null);
            }
        }
    });
}


/********************************************************************************** */


function setCookie (name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}


/********************************************************************************** */


/**
 *
 * FACEBOOK
 *
 */
/*
https://developers.facebook.com/tools/explorer/
http://habrahabr.ru/post/132794/

https://developers.facebook.com/docs/javascript/reference/v2.2?locale=ru_RU
https://developers.facebook.com/docs/facebook-login/permissions/v2.2?locale=ru_RU
http://stackoverflow.com/questions/23417356/facebook-graph-api-v2-0-me-friends-returns-empty-or-only-friends-who-also-u
https://developers.facebook.com/apps/1010986995584773/review-status/
*/
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
        appId   : fb_app_id,
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

    FB.api('/me?fields=id,name,birthday,gender,hometown,installed,verified,first_name,last_name,picture,link&locale=ru_RU', function(response) {

        console.log('Successful login for: ' + response.name);
        console.log(response)
        //document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.name + '!';


        /**
         * Сохраняем текст в поле обещания
         */
        var promise_text = $('.promise_text').val();
        //alert(promise_text); return;

        /**
         * FB - Отправляем запрос на сервер для добавления пользователя
         */
        var data = response;
        data.auth_method = 'facebook';
        data.identity = response.link;
        //data.identity = 'https://www.facebook.com/profile.php?id=' + data.id;
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
                     * Отправляем запрос к FB для получения списка друзей
                     */
                    if (typeof data.auth_method != 'undefined' && data.auth_method == 'facebook') {

                        var friends = {};

                        /**
                         * STEP 1: taggable_friends
                         */
                        FB.api('/me/taggable_friends?limit=' + fb_friends_limit, function(response) {

                            console.log('FB taggable friends list:');
                            console.log(response);
                            friends.taggable_friends = response.data;

                            /**
                             * STEP 2: friends
                             */
                                // get friends, which also install our app
                            FB.api('/me/friends?limit=' + fb_friends_limit, function(response) {

                                console.log('FB friends list:');
                                console.log(response);
                                friends.friends = response.data;

                                /**
                                 * STEP 3: save friends
                                 */
                                $.ajax({
                                    url: base_url + '/user-update-friends',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {user_id: user_data.user.id, friends: friends}
                                })
                                    .done(function (response) {
                                        //alert("SUCCESS");
                                        console.log(response);

                                        //alert('RELOAD PAGE');
                                        //location.href = base_url + '';
                                        location.href = location.href;
                                    })
                                    .fail(function (jqXHR, textStatus, errorThrown) {
                                        //alert('ERROR');
                                        console.log(textStatus);
                                    })
                                ;
                            });
                        });

                    }

                }


            })
        ;


    });
}




/**
 *
 * ODNOKLASSNIKI
 *
 */
$(document).on('click', '.ok-oauth-link', function(e){

    e.preventDefault();

    var promise_text = $('.promise_text').val();

    ODKL.Oauth2(this, 1110811904, 'VALUABLE_ACCESS;SET_STATUS;PHOTO_CONTENT', $(this).attr('data-domain') + '/ok-oauth?promise_text=' + promise_text );

    return false;
});



/**
 *
 * VKONTAKTE
 *
 */
/**
 * https://vk.com/dev/api_requests
 * https://vk.com/dev/friends.get
 * https://vk.com/editapp?id=4659025&section=options
 */
$(document).on('click', '.vk-oauth-link', function(e){

    e.preventDefault();

    var promise_text = $('.promise_text').val();

    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=800,height=600"
    window.open('https://oauth.vk.com/authorize?client_id=4659025&scope=friends,email,offline&redirect_uri=' + domain + '/vk-oauth?promise_text='+ promise_text + '&response_type=code&v=5.27', 'vk-oauth', params);

    return false;
});



/**
 *
 * EMAIL & PASSWORD
 *
 */
$(document).on('submit', '#auth_form', function(e){

    //e.preventDefault();

    var promise_text = $('.promise_text').val();
    var email = $('.user-auth-email').val();
    var pass = $('.user-auth-pass').val();

    $('input[type=hidden][name=promise_text]').val(promise_text);

    return true;
});

