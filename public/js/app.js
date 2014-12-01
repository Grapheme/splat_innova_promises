
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


    $(document).on('click', '.vk-oauth-link', function(e){
        e.preventDefault();

        var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=800,height=600"
        window.open('https://oauth.vk.com/authorize?client_id=4659025&scope=friends,email,offline&redirect_uri=' + domain + '/vk-oauth&response_type=code&v=5.27', 'vk-oauth', params);
        return false;
    });