$(document).ready(function($){
    var ulogintoken = getCookie("ulogintoken");
    if (ulogintoken != '')
        uloginauth(ulogintoken);

    /*
    var user_social_info = getCookie("user_social_info");
    if (user_social_info != '') {
        user_social_info = $.parseJSON(user_social_info); 
        console.log(user_social_info);
    }
    */
});


$(document).on('click', '#logout', function(e){
	e.preventDefault();
    setCookie("ulogintoken", null);
    $(this).text("Войти");
    $(this).attr("id", "login");
});


function uloginauth(token) {

    if(typeof ulogintoken == "undefined")
        setCookie("ulogintoken", token, "Mon, 01-Jan-2018 00:00:00 GMT", "/");
        
    $.getJSON("//ulogin.ru/token.php?host=" + encodeURIComponent(location.toString()) + "&token=" + token + "&callback=?", function(data){

        data = $.parseJSON(data.toString());
        console.log(data);

        if(!data.error){

            //alert("Привет, "+data.first_name+" "+data.last_name+"!");
            //$(".welcome_msg").html("Добро пожаловать, "+data.first_name+"!");

            $(".popup.auth").addClass("hidden");
            $(".overlay").addClass("hidden");

            $("#login").text("Выйти");
            $("#login").attr("id", "logout");


            /**
             * Отправляем запрос на сервер для добавления пользователя
             */

            var new_user = true;

            /**
             * Проверка - если пользователь новый, то получим список его друзей
             */

            if (new_user) {

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
                        data: { user_id: data.uid, fields: 'nickname, domain, sex, bdate, city', name_case: 'nom' }
                    })
                        .done(function(response) {
                            //alert("SUCCESS");
                            //console.log(response);
                            //console.log(response.response.length);
                            if (response.response.length) {

                                /**
                                 * Сохраняем список друзей пользователя
                                 */
                                console.log(response);
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            //alert('ERROR');
                            console.log(textStatus);
                        })
                        .always(function(response) {
                            //console.log(response);
                            //alert( "complete" );
                        })
                    ;
                }
            }


        } else {

            if (data.error == 'token expired') {

                // Token expired
                setCookie("ulogintoken", null);
                alert('Ваша сессия завершена. Пожалуйста, повторите вход');
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
