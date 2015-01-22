
var fb_app_id = '1010986995584773';

/**
 * Хеши картинок из ВК
 */

/**
 * Без ссылки
 */
/*
var photos = {
    blue:   'photo-62074862_348392589',
    yellow: 'photo-62074862_348392593',
    aqua:   'photo-62074862_348392590',
    pink:   'photo-62074862_348392591',
    green:  'photo-62074862_348392585'
};
//*/
/**
 * Со ссылкой
 */
//*
var photos = {
    blue:   'photo-62074862_352161152',
    yellow: 'photo-62074862_352161148',
    aqua:   'photo-62074862_352161151',
    pink:   'photo-62074862_352161150',
    green:  'photo-62074862_352055707'
};
//*/

$(document).ready(function($){
    var ulogintoken;
    //var ulogintoken = getCookie("ulogintoken");
    //if (ulogintoken != '')
    //    uloginauth(ulogintoken);
});


$(document).on('click', '.logout', function(e){

	e.preventDefault();

    $.ajax({
        url: base_url + '/user-logout',
        type: 'POST',
    })
        .fail(function(jqXHR, textStatus, errorThrown) {
            //alert('ERROR');
            console.log(textStatus);
        })
        .done(function(response) {

            //console.log(response);
            //setCookie('user_token', '', 0, '/');
            location.href = '/';
        });
});

$.validator.setDefaults({
    ignore: [],
    // any other default options and/or rules
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
                            FB.api('/me/friends?fields=name,birthday,gender,hometown,first_name,last_name,picture,link&limit=' + fb_friends_limit, function(response) {

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
                                        location.reload();
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

    console.log(ODKL.Oauth2);

    //ODKL.Oauth2(this, 1110811904, 'VALUABLE_ACCESS;SET_STATUS;PHOTO_CONTENT;GET_EMAIL', $(this).attr('data-domain') + '/ok-oauth' );
    ODKL.Oauth2(this, 1110811904, 'VALUABLE_ACCESS;GET_EMAIL', $(this).attr('data-domain') + '/ok-oauth' );

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
    window.open('https://oauth.vk.com/authorize?client_id=4659025&scope=friends,email,offline,photos,wall&redirect_uri=' + domain + '/vk-oauth' + '&response_type=code&v=5.27', 'vk-oauth', params);

    return false;
});



/**
 *
 * FACEBOOK
 *
 */
$(document).on('click', '.fb-oauth-link', function(e){

    e.preventDefault();

    var promise_text = $('.promise_text').val();

    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=800,height=600"
    window.open('https://www.facebook.com/dialog/oauth?client_id=' + fb_app_id + '&redirect_uri=' + domain + '/fb-oauth&scope=public_profile,email,user_birthday,user_photos,user_friends,user_about_me,user_hometown', 'fb-oauth', params);

    return false;
});



/**
 *
 * EMAIL & PASSWORD
 *
 */
//*

$(".auth_form_validate").validate({
    rules: {
        'email': { required: true, email: true },
        'pass': { required: true }
    },
    messages: {
        'email': "",
        'pass': ""
    },
    errorClass: "inp-error",
    submitHandler: function(form) {
        //alert(111);
        //console.log(form);
        //return false;
        //return true;

        //$(form).submit();

        //var email = $('.user-auth-email').val();
        //var pass = $('.user-auth-pass').val();
        var promise_text = $('.promise-text').val();

        $('input[type=hidden][name=promise_text]').val(promise_text);
        form.submit();

        //return true;
    }
});

$(".reg_form_validate").validate({
    rules: {
        'email': { required: true, email: true },
        'pass': { required: true }
    },
    messages: {
        'email': "",
        'pass': ""
    },
    errorClass: "inp-error",
    submitHandler: function(form) {
        var promise_text = $('.promise-text').val();
        $('input[type=hidden][name=promise_text]').val(promise_text);
        form.submit();
    }
});
//*/

/*
$(document).on('submit', '#auth_form', function(e){

    //e.preventDefault();

    var promise_text = $('.promise_text').val();
    //var email = $('.user-auth-email').val();
    //var pass = $('.user-auth-pass').val();

    $('input[type=hidden][name=promise_text]').val(promise_text);

    return true;
});
//*/

function gotome() {
    var promise_text = $('.promise-text').val();
    //location.href = '/me?promise_text=' + promise_text;

    var new_location = '/me';
    if (typeof promise_text != 'undefined' && promise_text != 'undefined' && promise_text != '')
        new_location += '?promise_text=' + promise_text;
    location.href = new_location;
}


$('.make-new-promise-btn').click(function(e){
//$(document).on('click', '.make-new-promise-btn', function(e){
    //e.preventDefault();

    //alert(user_id);
    //return false;
    if (!user_id)
        return true;

    gotome();
    return false;
});




$.validator.addMethod(
    "customDate",
    function(value, element) {
        // put your own logic here, this is just a (crappy) example
        return value.match(/^\d\d\.\d\d\.\d\d\d\d$/);
    },
    "Please enter a date in the format dd.mm.yyyy."
);
$.validator.addMethod(
    "customTime",
    function(value, element) {
        // put your own logic here, this is just a (crappy) example
        return value.match(/^\d\d\:\d\d$/);
    },
    "Please enter a time in the format hh:mm."
);



jQuery.validator.addMethod("futureDate", function(value, element) {
    var now = new Date();
    var splitDate = value.split('.');
    if(splitDate[0] && splitDate[1] && splitDate[2]) {
        var ourDate = new Date();
        ourDate.setDate(splitDate[0]);
        ourDate.setMonth(parseInt(splitDate[1]) - 1);
        ourDate.setYear(splitDate[2]);
        now.setHours(0);
        now.setMinutes(0);
        return ourDate.getTime() > now.getTime();
    } else {
        return false;
    }
}, "Выбрана прошедшая дата");

jQuery.validator.addMethod("futureTime", function(value, element) {
    var now = new Date();
    var splitDate = $('[name="limit_date"]').val().split('.');
    if($('[name="limit_date"]').val() != '') {
        var splitTime = value.split(':');
        var ourDate = new Date();
        ourDate.setDate(splitDate[0]);
        ourDate.setMonth(parseInt(splitDate[1]) - 1);
        ourDate.setYear(splitDate[2]);
        ourDate.setHours(splitTime[0]);
        ourDate.setMinutes(splitTime[1]);
        return ourDate.getTime() > now.getTime();
    } else {
        return true;
    }
}, "");

$("#promise-form").validate({
    rules: {
        'promise_text': { required: true },
        'limit_date': { required: true, customDate: true, futureDate: true },
        'limit_time': { required: true, customTime: true, futureTime: true },
        'style_id': { required: true }
    },
    messages: {
        'promise_text': '',
        'limit_date': '',
        'limit_time': '',
        'style_id': ''
    },
    errorClass: "inp-error",
    submitHandler: function(form) {

        //console.log(form);

        var current_form = form;

        var only_for_me = $('input[name=only_for_me]').prop("checked");

        /**
         * Если юзер авторизовался не через ВК, или обещание видно только автору...
         */
        if (auth_method != 'vkontakte' || only_for_me) {

            /**
             * ...отправляем форму сразу
             */
            form.submit();

        } else {


            /**
             * Текущий стиль
             */
            var current_style_id = $('.js-types .active').attr('data-type') || 'blue';
            //console.log(current_style_id);

            /**
             * Хеш картинки для текущего стиля
             */
            var attachment = photos[current_style_id];
            //console.log(attachment);

            /**
             * Текст обещания
             */
            var promise_text = $('[name=promise_text]').val() || '';

            /**
             * Открываем окно с предложением оставить запись на стене
             */
            VK.Api.call("wall.post", {
                owner_id: auth_user_id,
                message: "Я обещаю " + promise_text + "\r\n\r\n"
                    + "Каждый, кто читает эту запись, имеет право потребовать у меня отчет о выполнении обещания.\r\n\r\n"
                    + "Все мои обещания можно посмотреть здесь: " + user_profile_url,
                //attachments: r3.response[0].id
                //attachments: "photo1889847_350020035" // синий фон
                //attachments: "photo1889847_350023713" // снеговик
                attachments: attachment // выбранный стиль
            }, function(r4) {
                //console.log(r4);
                //// В самом конце отправляем форму
                current_form.submit();
            });
            return;

            /******************************************************************************************************** */

            /**
             * Получим URL для загрузки изображения на сервер ВК
             */
            VK.Api.call('photos.getWallUploadServer', {

                group_id: auth_user_id,
                version: 5.27

            }, function(r1) {

                //console.log(r);

                /**
                 * Делаем запрос на собственный сервер для отправки картинки через POST-запрос на сервер ВК
                 */
                $.ajax({
                    url: vkapi_post_image_upload_url,
                    type: 'POST',
                    dataType: 'json',
                    data: { url: r1.response.upload_url }
                })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        //alert('ERROR');
                        console.log(textStatus);
                        console.log(jqXHR);
                    })
                    .done(function (r2) {

                        console.log(r2);

                        /**
                         * Сохраняем отправленную фотографию на сервере ВК
                         */
                        VK.Api.call('photos.saveWallPhoto', {

                            server: r2.answer.server,
                            photo: r2.answer.photo,
                            hash: r2.answer.hash,
                            group_id: auth_user_id // ВАЖНО! Без этой строки не работает

                        }, function(r3) {

                            console.log(r3);

                            /**
                             * Открываем окно с предложением оставить запись на стене
                             */
                            /*
                            VK.Api.call('wall.post', {

                                owner_id: auth_user_id,
                                message: "Я только что дал обещание на mypromises.ru\r\nКаждый, кто читает эту запись, имеет право потребовать у меня отчет о выполнении обещания.\r\n\r\nВсе мои обещания можно посмотреть здесь: " + user_profile_url,
                                //attachments: r3.response[0].id
                                attachments: 'photo1889847_350020035'

                            }, function(r4) {

                                alert('!!!');
                                console.log(r4);

                                //// В самом конце отправляем форму
                                //current_form.submit();
                            });
                            */

                        });


                    });

            });


            /*
            function vk_wall_post() {

                VK.Api.call("wall.post", {
                    owner_id: auth_user_id,
                    message: "Я только что дал обещание на mypromises.ru\r\nКаждый, кто читает эту запись, имеет право потребовать у меня отчет о выполнении обещания.\r\n\r\nВсе мои обещания можно посмотреть здесь: " + user_profile_url,
                    //attachments: r3.response[0].id
                    //attachments: "photo1889847_350020035" // синий фон
                    attachments: "photo1889847_350023713" // снеговик
                }, function(r4) {
                    console.log(r4);
                    //// В самом конце отправляем форму
                    //current_form.submit();
                });
            }

            setTimeout(vk_wall_post, 3000);
            */
            //return;
            //*/
        }
    }
});

$("#profile_form").validate({
    rules: {
        'name': { required: true },
        'email': { required: true, email: true },
        //'bdate': { customDate: true },
        'city': { required: true },
        'confirmation': { required: true }
    },
    messages: {
        'name': '',
        'email': '',
        //'bdate': '',
        'city': '',
        'confirmation': 'Необходимо ознакомиться с правилами'
    },
    errorClass: "inp-error",
    submitHandler: function(form) {
        //console.log(form);
        form.submit();
    }
});



$(".promise-finish-button").on('click', function(e){

    if (auth_method != 'vkontakte' || only_for_me) {

        return true;

    } else {

        e.preventDefault();

        var href = $(this).attr('href');

        /**
         * Открываем окно с предложением оставить запись на стене
         */
        VK.Api.call("wall.post", {
            owner_id: auth_user_id,
            message: "Я выполнил обещание " + promise_text
            + "\r\n"
            + "Дайте свое обещание на сайте mypromises.ru",
            attachments: 'photo-62074862_348392589'
        }, function(r) {
            //console.log(r4);
            //return true;

            location.href = href;
        });

    }

})




function array_rand ( input, num_req ) {	// Pick one or more random entries out of an array
    //
    // +   original by: _argos

    var Indexes = [];
    var Ticks = num_req || 1;
    var Check = {
        Duplicate	: function ( input, value ) {
            var Exist = false, Index = 0;
            while ( Index < input.length ) {
                if ( input [ Index ] === value ) {
                    Exist = true;
                    break;
                }
                Index++;
            }
            return Exist;
        }
    };

    if ( input instanceof Array && Ticks <= input.length ) {
        while ( true ) {
            var Rand = Math.floor ( ( Math.random ( ) * input.length ) );
            if ( Indexes.length === Ticks ) { break; }
            if ( !Check.Duplicate ( Indexes, Rand ) ) { Indexes.push ( input[Rand] ); }
        }
    } else {
        Indexes = null;
    }

    return ( ( Ticks == 1 ) ? Indexes.join ( ) : Indexes );
}

function random(element) {
    var los = Math.floor(Math.random() * element.length)
    return element[los];
}