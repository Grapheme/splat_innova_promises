function declOfNum(a,b){return cases=[2,0,1,1,1,2],b[a%100>4&&20>a%100?2:cases[5>a%10?a%10:5]]}var SplatSite={};SplatSite.tabs=function(){var a=$(".js-open-box"),b=$(".js-pop-close"),c=$(".overlay-shadow"),d=$(".js-change-box"),e=$(".overlay"),f=!1,g={};g.retPos=function(a){var b={};b.top=a.offset().top-$(window).scrollTop(),b.left=a.offset().left-$(window).scrollLeft(),b.bottom=window.innerHeight-b.top-a.height(),b.right=window.innerWidth-b.left-a.width(),c.css({top:b.top,left:b.left,bottom:b.bottom,right:b.right})},g.open=function(a){clearTimeout(f),a.hasClass("js-promise-btn")&&(""!=$(".js-promise-input").val()?($(".js-promise-title").show(),$(".js-promise-title").text($(".js-promise-input").val())):$('[data-box="req"]').trigger("click"));var b=a.attr("data-box"),d=$('.js-pop-up[data-box="'+b+'"]');this.retPos(a),a.addClass("js-opened-from"),setTimeout(function(){c.addClass("anim active"),setTimeout(function(){e.show(),d.show(),setTimeout(function(){d.addClass("active")},150)},150)},10)},g.close=function(){var a=$(".js-opened-from"),b=a.attr("data-box"),d=$('.js-pop-up[data-box="'+b+'"]');a.removeClass("js-opened-from"),this.retPos(a),c.removeClass("active"),d.removeClass("active").siblings().removeClass("active"),f=setTimeout(function(){e.hide(),c.removeClass("anim").removeAttr("style"),d.hide().siblings().hide(),$(".js-promise-title").hide()},500)},g.change=function(a){var b=$('.js-pop-up[data-box="'+a+'"]');b.show().addClass("active").siblings().hide().removeClass("active")};var h=function(){a.on("click",function(){return g.open($(this)),!1}),b.on("click",function(){return g.close(),!1}),d.on("click",function(){return g.change($(this).attr("data-box")),!1}),$(".js-form-pass").on("click",function(){return $(".js-pop-form").hide(),$('.js-pop-form[data-type="pass"]').show(),!1})},i=function(){h()};i()},SplatSite.simpleBox=function(){var a=$(".soverlay"),b=a.find(".sbox"),c=function(c){a.show(),b.filter('[data-name="'+c+'"]').show()},d=function(){a.hide(),b.hide()},e=function(){b.hide()};return $(".soverlay").on("click",function(a){$(a.target).hasClass("soverlay")&&d()}),e(),{open:c,close:d}},SplatSite.index=function(){var a=function(a){var b=$(".js-slide-title.active");b.addClass("faded"),setTimeout(function(){$(".js-slide-title.faded.active").removeClass("active faded")},1500),setTimeout(function(){$(".js-slide-title").eq(a).addClass("active")},250)},b=function(){var b={fit:"cover",width:"100%",height:"560px",autoplay:6e3,transitionduration:1e3,transition:"dissolve",arrows:!1,nav:!1},c=$(".js-main-fotorama").fotorama(b),d=(c.data("fotorama"),!1);$(".js-main-fotorama").on("fotorama:load",function(){d||(a(0),d=!0)}),$(".js-main-fotorama").on("fotorama:show",function(b,c){a(c.activeIndex)})},c=function(){var a={width:"100%",height:"600px",autoplay:4e3,transitionduration:1e3,transition:"dissolve",arrows:!1,nav:!1};$(".js-promises-fotorama").fotorama(a)},d=function(){},e=function(){$(document).on("click","[data-promise-text]",function(){$(".js-promise-input").val($(this).attr("data-promise-text")).trigger("focus")})},f=function(){$(".js-promise-card-btn").on("click",function(){var a=$(this).parents(".js-parent"),b=a.find(".js-promise-text").text();return $(".js-promise-input").val(b),$(".js-promise-placeholder promise-placeholder span").hide(),$(".js-promise-btn").trigger("click"),!1})},g=function(){b(),c(),d(),e(),f()};g()},SplatSite.ProfileEdit=function(){},SplatSite.Promise=function(){var a={};a.init=function(){this.events(),$(".js-types li").first().trigger("click")},a.setStyle=function(a){$(".js-type-select").val(a).trigger("change",[a])},a.events=function(){var a=this;$(".js-type-select").on("change",function(a,b){$(".js-type-parent").removeClass("type-blue type-yellow type-aqua type-green type-pink"),$(".js-type-parent").addClass("type-"+b),$(".js-types .type-"+b).addClass("active").siblings().removeClass("active")}),$(".js-types li").on("click",function(){var b=$(this).attr("data-type");a.setStyle(b)})},a.init()},SplatSite.InviteForm=function(){$(".js-inv-btn").on("click",function(){return $(".js-inv-btn-cont").slideUp(),$(".js-inv-form").slideDown(function(){$(this).find("input").trigger("focus")}),!1})},SplatSite.ShowFriends=function(){var a=function(){var a=0;$(".friend-item.hidden").each(function(){$(this).attr("data-number",a),a++})},b=function(){$(".friend-item").not(".hidden").each(function(){var a=$(this).find(".profile-photo"),b=a.attr("data-style");a.attr("style",b)})};b(),$(".show-more-friends").on("click",function(){var c=$(this);a();for(var d=0;12>d;d++)$('.friend-item.hidden[data-number="'+d+'"]').removeClass("hidden");return 0==$(".friend-item.hidden").length&&c.hide(),b(),!1})},
SplatSite.PromisePlaceholder=function(){var a=$(".js-promise-placeholder input, .js-promise-placeholder textarea"),b=$(".js-promise-placeholder .promise-placeholder"),c=b.find("span");b.on("click",function(){a.trigger("focus")}),a.on("focus",function(){c.hide()}),a.on("focusout",function(){""==a.val()&&c.show()}),""!=a.val()&&a.trigger("focus"),$(".js-promise-placeholder textarea").autosize()},SplatSite.CountDown=function(a){$.fn.MyCount=function(){for(var a=$(this).parents("[data-finish]"),b=a.attr("data-finish"),c=0;2>c;c++)b=b.replace("-","/");$(this).countdown(b,function(a){var b=declOfNum(parseInt(a.strftime("%-D")),["день","дня","дней"]);$(this).html(a.strftime('<span class="time-day"><span>%-D</span> '+b+'</span><span class="time-time">%H:%M:%S</span>')),("stoped"==a.type||"finish"==a.type)&&(window.location.href="?prefail=1")})},$(a).MyCount()},SplatSite.CardCountDown=function(a){$.fn.MyCount=function(){$(this).each(function(){for(var a=$(this).parents("[data-finish]"),b=a.attr("data-finish"),c=0;2>c;c++)b=b.replace("-","/");$(this).countdown(b,function(a){if("stoped"!=a.type||"finish"!=a.type){var b=a.finalDate.getTime()-(new Date).getTime(),c=864e5;c>b&&b>=0&&$(this).html(a.strftime("%H:%M:%S"))}})})},$(a).MyCount()},SplatSite.Common=function(){$(".js-advice").on("click",function(){return $(".js-advice-to").val($(this).text()).trigger("focus"),!1}),$(".ui-select").customSelect()},$.fn.AjaxForm=function(){var a=$(this).attr("action"),b=$(this);b.find(".js-ajax-after").hide(),$(this).on("submit",function(c){return b.find("[type=submit]").attr("disabled","disabled").addClass("loading"),$.ajax({url:a,data:b.serialize(),type:"post"}).done(function(a){b.find(".js-ajax-result").text(a.responseText),b.find(".js-ajax-before").slideUp(),b.find(".js-ajax-after").slideDown()}).fail(function(){console.log(data)}),c.preventDefault(),!1})},$.fn.SmartBtn=function(){$(this).each(function(){var a=$(this),b=!1;a.on("click",function(){return b?void 0:($(this).addClass("clicked"),b=!0,!1)}),a.on("click",".js-no",function(){return b?(a.removeClass("clicked"),b=!1,!1):void 0}),a.on("click",".js-yes",function(){return b?("promise-delete"==$(this).attr("data-ga")&&ga("send","event","promise","delete"),"comment-delete"==$(this).attr("data-ga")&&ga("send","event","comment","delete"),window.location.href=a.attr("data-href"),!1):void 0})})},SplatSite.ValidEmail=function(){if($(".js-email-input").length){var a=function(){var a=$(".js-email-input").val(),b=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;b.test(a)?$(".js-email-check-cont").slideDown():$(".js-email-check-cont").slideUp()};$(".js-email-input").on("input",function(){a()}),a()}},
function(a){"function"==typeof define&&define.amd?define(["../datepicker"],a):a(jQuery.datepicker)}(function(a){return a.regional.ru={closeText:"Закрыть",prevText:"&#x3C;Пред",nextText:"След&#x3E;",currentText:"Сегодня",monthNames:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],monthNamesShort:["Янв","Фев","Мар","Апр","Май","Июн","Июл","Авг","Сен","Окт","Ноя","Дек"],dayNames:["воскресенье","понедельник","вторник","среда","четверг","пятница","суббота"],dayNamesShort:["вск","пнд","втр","срд","чтв","птн","сбт"],dayNamesMin:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],weekHeader:"Нед",dateFormat:"dd.mm.yy",firstDay:1,isRTL:!1,showMonthAfterYear:!1,yearSuffix:""},a.setDefaults(a.regional.ru),a.regional.ru}),$.datepicker.setDefaults($.datepicker.regional.ru),$(function(){$("body");SplatSite.Common(),SplatSite.tabs(),SplatSite.ShowFriends(),SplatSite.Tooltips.init(),SplatSite.PromisePlaceholder(),SplatSite.ValidPhone(),SplatSite.ValidEmail(),$(".js-smart-btn").SmartBtn(),$(".js-countdown").length&&SplatSite.CountDown(".js-countdown"),$(".js-time-countdown").length&&SplatSite.CardCountDown(".js-time-countdown"),$(".js-ajax-form").AjaxForm(),$(".styledCheck").button(),$.extend($.inputmask.defaults.definitions,{i:{validator:"[0-5][0-9]",cardinality:2,prevalidator:[{validator:"[0-5]",cardinality:1}]},H:{validator:"[01][0-9]|2[0-3]",cardinality:2,prevalidator:[{validator:"[0-2]",cardinality:1}]}}),$.extend($.inputmask.defaults,{clearMaskOnLostFocus:!1}),$(".js-mask-time").inputmask("H:i",{placeholder:"чч:мм"}),""==$(".js-mask-time").val()&&$(".js-mask-time").val("12:00"),$(".js-mask-date").inputmask("dd.mm.yyyy",{placeholder:"дд.мм.гггг"}).datepicker({showOtherMonths:!0,defaultDate:new Date(1990,0,1),changeYear:!0,maxDate:0}),$(".js-future-date").inputmask("dd.mm.yyyy",{placeholder:"дд.мм.гггг",yearrange:{minyear:(new Date).getFullYear(),maxyear:2099}}).datepicker({showOtherMonths:!0,changeYear:!0,minDate:0,onSelect:function(){$("[name=limit_date]").valid(),$("[name=limit_time]").valid()}}),$(document).keypress(function(a){13==a.which&&$(".js-promise-input").is(":focus")&&$(".make-new-promise-btn").trigger("click")}),$(".date-div, .time-div").on("click",function(){$(this).find("input").trigger("focus")})});
SplatSite.ValidPhone = function() {
    if(!$('.js-phone').length) return;
    var defaultMethod = 'POST';
    var urls = SplatDict.urls;
    var start_check = false;
    var error_cont = $('.js-phone-error');
    var phone_status = $('.js-phone .phone-status');
    var hide_error = function() {
        error_cont.slideUp();
    }
    var show_error = function(text) {
        error_cont.html(text).slideDown();
    }
    var hide_popup_error = function() {
        $('.js-valid-errors').hide();
    }
    var show_popup_error = function(text) {
        $('.js-valid-errors').html(text).show();
    }
    var phoneCheckbox = function(act) {
        if(act == 'show') {
            $('.js-phone-check-cont').slideDown();
        } else {
            $('.js-phone-check-cont').slideUp();
            //$(".js-phone-checkbox").prop("checked", false);
            //$('.js-phone-check-cont label').removeClass('ui-state-active');
        }
    }
    var checkThis = function(elem) {
        var phone_number = elem.val(),
            just_numbers = phone_number
                .replace('(', '')
                .replace(')', '')
                .replace('-', '')
                .replace('-', ''),
            data = {
                user_id: SplatDict.user_id,
                phone: just_numbers
            };
        hide_error();
        $.ajax({
            url: urls['check_phone'],
            data: data,
            method: defaultMethod
        }).done(function(resp){
            if(resp.status == false) {
                show_error('Произошла ошибка. Попробуйте позже');
            } else {
                if(resp.state == 'new') {
                    phone_status.filter('[data-status="new"]').fadeIn();
                    show_error('<a href="#" class="js-phone-popup">Подтвердите свой номер телефона</a>');
                    phoneCheckbox('close');
                    closeForm();
                }
                if(resp.state == 'valid') {
                    phone_status.filter('[data-status="valid"]').fadeIn();
                    phoneCheckbox('show');
                }
            }
        }).fail(function(){
            show_error('Произошла ошибка. Попробуйте позже');
        });
    }
    var showForm = function() {
        $('.js-phone-code').slideDown();
        $('.js-phone-error').slideUp();
        $('[data-status="new"]').hide();
    }
    var closeForm = function() {
        $('.js-phone-code').slideUp();
    }
    var sendsms = function() {
        var phone_number = $('.js-phone-input').val(),
            just_numbers = phone_number
                .replace('(', '')
                .replace(')', '')
                .replace('-', '')
                .replace('-', ''),
            data = {
                user_id: SplatDict.user_id,
                phone: just_numbers
            };
        $('.js-phone-code').val('');
        $('.js-phone-popup').addClass('loading');
        $('.js-valid-repeat').addClass('loading-link');
        $.ajax({
            data: data,
            url: urls['send_sms'],
            method: defaultMethod
        })
        .done(function(resp){
            $('.js-valid-repeat').removeClass('loading-link');
            $('.js-phone-popup').removeClass('loading');
            if(resp.status == false) {
                show_error('Произошла ошибка. Попробуйте позже');
            } else {
                showForm();
            }
        })
        .fail(function(){
            $('.js-valid-repeat').removeClass('loading-link');
            $('.js-phone-popup').removeClass('loading');
            show_error('Произошла ошибка. Попробуйте позже');
        });
    }
    var showVerify = function() {
        hide_error();
        hide_popup_error();
        SplatSite.simpleBox().close();
        phone_status.filter('[data-status="new"]').fadeOut();
        phone_status.filter('[data-status="valid"]').fadeIn();
        phoneCheckbox('show');
        closeForm();
    }
    var checkCode = function() {
        var data = {
                user_id: SplatDict.user_id,
                code: $('.js-code-input').val()
            };
        $('.js-code-check').addClass('loading-link');
        $.ajax({
            data: data,
            url: $('.js-phone').attr('data-url'),
            method: defaultMethod
        })
        .done(function(resp){
            console.log(resp);
            $('.js-code-check').removeClass('loading-link');
            if(resp.state == 'invalid') {
                $('.js-phone-error').slideDown();
                $('.js-phone-error').html('Неверный код подтверждения. <a href="#" class="js-phone-popup">Выслать код еще раз</a>');
                phoneCheckbox('close');
            } else {
                showVerify();
            }
        })
        .fail(function(){
            $('.js-code-check').removeClass('loading-link');
            show_popup_error('Произошла ошибка. Попробуйте позже');
            phoneCheckbox('close');
        });
    }
    $('.js-phone-input').on('input', function(){
        if(!$('.js-phone-input').inputmask("isComplete")) {
            hide_error();
            phone_status.hide();
            phoneCheckbox('close');
        }
    });
    $('.js-phone-input').inputmask('+7(999)999-99-99', {
        "oncomplete": function(){
            checkThis($(this));
        }
    });
    /*if($('.js-phone-input').inputmask("isComplete")) {
        checkThis($('.js-phone-input'));
    }*/
    if(SplatDict.phone_confirm_code == 1) {
        showForm();
    } else {
        if($('.js-phone-input').inputmask("isComplete") && SplatDict.phone_confirmed != 1) {
            checkThis($('.js-phone-input'));
        }
    }
    if(SplatDict.phone_confirmed == 1) {
        hide_error();
        hide_popup_error();
        SplatSite.simpleBox().close();
        phone_status.filter('[data-status="new"]').fadeOut();
        phone_status.filter('[data-status="valid"]').fadeIn();
        phoneCheckbox('show');
        closeForm();
    }
    $(document).on('click', '.js-phone-popup', function(){
        if(!$(this).hasClass('loading') && !$('.js-code-check').hasClass('loading-link')) {
            sendsms();
        }
        return false;
    });
    $(document).on('click', '.js-valid-repeat', function(){
        if(!$(this).hasClass('loading-link') && !$('.js-code-check').hasClass('loading-link')) {
            sendsms();
            show_popup_error('Новый код отправлен');
        }
        return false;
    });
    $(document).on('click', '.js-code-verify', function(){
        if(!$(this).hasClass('loading-link') && !$('.js-valid-repeat').hasClass('loading-link')) {
            checkCode();
        }
        return false;
    });
}
SplatSite.Tooltips = {
    init: function() {
        var self = this;
        var close_allow = true;
        var close_timeout = false;
        var html = '<div class="js-tooltip"><div class="js-tooltip-body"></div></div>';
        $('body').append(html);
        $('[data-tooltip]').on('mouseover', function(){
            clearTimeout(close_timeout);
            var text = $(this).attr('data-tooltip');
            var elem = $(this);
            var add_class = $(this).attr('data-add-class');
            $('.js-tooltip').attr('class', 'js-tooltip');
            if(add_class)
                $('.js-tooltip').addClass(add_class);
            self.show(text, elem);
        });
        $('[data-tooltip]').on('mouseout', function(){
            close_timeout = setTimeout(function(){
                if(close_allow) {
                    $('.js-tooltip').removeClass($(this).attr('data-add-class'));
                    self.close();
                }
            }, 5);
        });
        $('.js-tooltip').on('mouseover', function(){
            clearTimeout(close_timeout);
            close_allow = false;
        });
        $('.js-tooltip').on('mouseout', function(){
            clearTimeout(close_timeout);
            close_allow = true;
            close_timeout = setTimeout(function(){
                if(close_allow) {
                    self.close();
                }
            }, 5);
        });
    },
    show: function(text, elem) {
        if(elem.attr('data-tooltip-media')) {
            if($(window).width() > elem.attr('data-tooltip-media')) {
                return false;
            }
        }
        var pos = {};
        pos.x = elem.offset().left + elem.width() + 20;
        pos.y = elem.offset().top + elem.height()/2;
        if(elem.attr('data-tooltip-center') == 'on') {
            pos.x = elem.offset().left + elem.width()/2;
        } else
        if(pos.x + $('.js-tooltip').width() > $(window).width()) {
            pos.x = elem.offset().left - $('.js-tooltip').width() - 20;
            $('.js-tooltip').addClass('tooltip-right');
        }
        $('.js-tooltip').css({
            top: pos.y,
            left: pos.x
        }).show();
        $('.js-tooltip-body').html(text);
    },
    close: function() {
        $('.js-tooltip').removeClass('tooltip-right').hide();
    }
}
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
var randomAdvice = function() {
	var advice = $('.js-advice');
	var advice_array = [];
	var show_array = [];
	advice.each(function(){
		advice_array.push($(this).index());
	});
	for(var i = 0; i < 6; i++){
		var rand = getRandomInt(0, advice_array.length-1);
		show_array.push(advice_array[rand]);
		advice_array.splice(rand, 1);
	}
	$.each(show_array, function(index, value){
		advice.eq(value).show();
	});
}
randomAdvice();
var BrowserDetect = {
    init: function () {
        this.browser = this.searchString(this.dataBrowser) || "Other";
        this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
    },
    searchString: function (data) {
        for (var i = 0; i < data.length; i++) {
            var dataString = data[i].string;
            this.versionSearchString = data[i].subString;
            if (dataString.indexOf(data[i].subString) !== -1) {
                return data[i].identity;
            }
        }
    },
    searchVersion: function (dataString) {
        var index = dataString.indexOf(this.versionSearchString);
        if (index === -1) {
            return;
        }
        var rv = dataString.indexOf("rv:");
        if (this.versionSearchString === "Trident" && rv !== -1) {
            return parseFloat(dataString.substring(rv + 3));
        } else {
            return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
        }
    },
    dataBrowser: [
        {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
        {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
        {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
        {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
        {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
        {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
    ]
};
BrowserDetect.init();
$(function(){
	if(BrowserDetect.browser == 'Explorer') {
		$('html').addClass('ie-detected');
	} else {
		$('html').addClass('not-ie');
	}
});
var SplitPromises = function(){
    if(!$('.js-split-promises').length) return;
    var showItems = 12;
    var activeStage = 0;
    var promiseItems = $('.js-split-promises .js-promise-item');
    var show = function(stage) {
        activeStage = stage;
        promiseItems.each(function(){
            var t = $(this);
            var showCount = showItems * stage;
            if($(this).index() < showCount) {
                t.show();
            } else {
                t.hide();
            }
            if(showCount >= promiseItems.length) {
                $('.js-promises-more').hide();
            } else {
                $('.js-promises-more').show();
            }
        });
    }
    show(1);
    $('.js-promises-more').on('click', function(){
        show(activeStage+1);
        return false;
    });
};
SplitPromises();
var usPopups = {
    open: function() {},
    close: function() {},
    init: function() {
        $('.js-us-overlay-close').on('click', function(){
            $(this).parents('.js-us-overlay').fadeOut(function(){
                $(this).remove();
            });
            return false;
        });
    }
};
usPopups.init();
var achives = {
    init: function() {
        if(!window.__SITE__) return;
        var obj = window.__SITE__.achievements || null;
        var parent = $('.js-achives');
        if(obj === null) return;
        $.each(obj, function(index, value){
            console.log(value);
            parent.append('<div data-add-class="achive-tooltip" data-tooltip="<div class=\'at-title\'>' + value.name + '</div><div class=\'at-desc\'>' + value.desc + '</div>" class="achives-item" style="background-image: url(' + value.icon + ');"></div>');
        });
    }
}
achives.init();
$('.js-chosen').chosen({
    width: '100%'
});
$('.js-reload-set').on('click', function(){
    window.location.href = $('.js-reload-select').val();
    return false;
});
(function friendsList(){
    var activeStep = 0;
    var showCount = 12;
    var show = function() {
        activeStep++;
        var countStep = activeStep * showCount;
        $('.js-friend-item-right').not(':visible').slice(0, showCount/2).show();
        $('.js-friend-item-left').not(':visible').slice(0, showCount/2).show();
        if($('.js-friend-item-left').not(':visible').length == 0 && $('.js-friend-item-right').not(':visible').length == 0) {
            $('.js-show-friends').hide();
        }
    }
    show();
    $('.js-show-friends').on('click', function(){
        show();
        return false;
    });
})();
(function inactive(){
    var toShow = $('.js-inactive li').not('.js-inactive-block');
    $('.js-inactive li').first().show();
    $('.js-inactive-block').show();
    $('.js-show-inactive').on('click', function(){
        toShow.show();
        $('.js-inactive-block').hide();
        return false;        
    });
})();