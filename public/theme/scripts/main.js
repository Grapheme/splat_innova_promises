function declOfNum(a,b){return cases=[2,0,1,1,1,2],b[a%100>4&&20>a%100?2:cases[5>a%10?a%10:5]]}var SplatSite={};SplatSite.tabs=function(){var a=$(".js-open-box"),b=$(".js-pop-close"),c=$(".overlay-shadow"),d=$(".js-change-box"),e=$(".overlay"),f=!1,g={};g.retPos=function(a){var b={};b.top=a.offset().top-$(window).scrollTop(),b.left=a.offset().left-$(window).scrollLeft(),b.bottom=window.innerHeight-b.top-a.height(),b.right=window.innerWidth-b.left-a.width(),c.css({top:b.top,left:b.left,bottom:b.bottom,right:b.right})},g.open=function(a){clearTimeout(f),a.hasClass("js-promise-btn")&&(""!=$(".js-promise-input").val()?($(".js-promise-title").show(),$(".js-promise-title").text($(".js-promise-input").val())):$('[data-box="req"]').trigger("click"));var b=a.attr("data-box"),d=$('.js-pop-up[data-box="'+b+'"]');this.retPos(a),a.addClass("js-opened-from"),setTimeout(function(){c.addClass("anim active"),setTimeout(function(){e.show(),d.show(),setTimeout(function(){d.addClass("active")},150)},150)},10)},g.close=function(){var a=$(".js-opened-from"),b=a.attr("data-box"),d=$('.js-pop-up[data-box="'+b+'"]');a.removeClass("js-opened-from"),this.retPos(a),c.removeClass("active"),d.removeClass("active").siblings().removeClass("active"),f=setTimeout(function(){e.hide(),c.removeClass("anim").removeAttr("style"),d.hide().siblings().hide(),$(".js-promise-title").hide()},500)},g.change=function(a){var b=$('.js-pop-up[data-box="'+a+'"]');b.show().addClass("active").siblings().hide().removeClass("active")};var h=function(){a.on("click",function(){return g.open($(this)),!1}),b.on("click",function(){return g.close(),!1}),d.on("click",function(){return g.change($(this).attr("data-box")),!1}),$(".js-form-pass").on("click",function(){return $(".js-pop-form").hide(),$('.js-pop-form[data-type="pass"]').show(),!1})},i=function(){h()};i()},SplatSite.simpleBox=function(){var a=$(".soverlay"),b=a.find(".sbox"),c=function(c){a.show(),b.filter('[data-name="'+c+'"]').show()},d=function(){a.hide(),b.hide()},e=function(){b.hide()};return $(".soverlay").on("click",function(a){$(a.target).hasClass("soverlay")&&d()}),e(),{open:c,close:d}},SplatSite.index=function(){var a=function(a){var b=$(".js-slide-title.active");b.addClass("faded"),setTimeout(function(){$(".js-slide-title.faded.active").removeClass("active faded")},1500),setTimeout(function(){$(".js-slide-title").eq(a).addClass("active")},250)},b=function(){var b={fit:"cover",width:"100%",height:"560px",autoplay:6e3,transitionduration:1e3,transition:"dissolve",arrows:!1,nav:!1},c=$(".js-main-fotorama").fotorama(b),d=(c.data("fotorama"),!1);$(".js-main-fotorama").on("fotorama:load",function(){d||(a(0),d=!0)}),$(".js-main-fotorama").on("fotorama:show",function(b,c){a(c.activeIndex)})},c=function(){var a={width:"100%",height:"600px",autoplay:4e3,transitionduration:1e3,transition:"dissolve",arrows:!1,nav:!1};$(".js-promises-fotorama").fotorama(a)},d=function(){},e=function(){$(document).on("click","[data-promise-text]",function(){$(".js-promise-input").val($(this).attr("data-promise-text")).trigger("focus")})},f=function(){$(".js-promise-card-btn").on("click",function(){var a=$(this).parents(".js-parent"),b=a.find(".js-promise-text").text();return $(".js-promise-input").val(b),$(".js-promise-placeholder promise-placeholder span").hide(),$(".js-promise-btn").trigger("click"),!1})},g=function(){b(),c(),d(),e(),f()};g()},SplatSite.ProfileEdit=function(){},SplatSite.Promise=function(){var a={};a.init=function(){this.events(),$(".js-types li").first().trigger("click")},a.setStyle=function(a){$(".js-type-select").val(a).trigger("change",[a])},a.events=function(){var a=this;$(".js-type-select").on("change",function(a,b){$(".js-type-parent").removeClass("type-blue type-yellow type-aqua type-green type-pink"),$(".js-type-parent").addClass("type-"+b),$(".js-types .type-"+b).addClass("active").siblings().removeClass("active")}),$(".js-types li").on("click",function(){var b=$(this).attr("data-type");a.setStyle(b)})},a.init()},SplatSite.InviteForm=function(){$(".js-inv-btn").on("click",function(){return $(".js-inv-btn-cont").slideUp(),$(".js-inv-form").slideDown(function(){$(this).find("input").trigger("focus")}),!1})},SplatSite.ShowFriends=function(){var a=function(){var a=0;$(".friend-item.hidden").each(function(){$(this).attr("data-number",a),a++})},b=function(){$(".friend-item").not(".hidden").each(function(){var a=$(this).find(".profile-photo"),b=a.attr("data-style");a.attr("style",b)})};b(),$(".show-more-friends").on("click",function(){var c=$(this);a();for(var d=0;12>d;d++)$('.friend-item.hidden[data-number="'+d+'"]').removeClass("hidden");return 0==$(".friend-item.hidden").length&&c.hide(),b(),!1})},SplatSite.Tooltips={init:function(){var a=this,b=!0,c=!1,d='<div class="js-tooltip"><div class="js-tooltip-body"></div></div>';$("body").append(d),$("[data-tooltip]").on("mouseover",function(){clearTimeout(c);var b=$(this).attr("data-tooltip"),d=$(this),e=$(this).attr("data-add-class");e&&$(".js-tooltip").addClass(e),a.show(b,d)}),$("[data-tooltip]").on("mouseout",function(){c=setTimeout(function(){b&&($(".js-tooltip").removeClass($(this).attr("data-add-class")),a.close())},5)}),$(".js-tooltip").on("mouseover",function(){clearTimeout(c),b=!1}),$(".js-tooltip").on("mouseout",function(){clearTimeout(c),b=!0,c=setTimeout(function(){b&&a.close()},5)})},show:function(a,b){if(b.attr("data-tooltip-media")&&$(window).width()>b.attr("data-tooltip-media"))return!1;var c={};c.x=b.offset().left+b.width()+20,c.y=b.offset().top+b.height()/2,"on"==b.attr("data-tooltip-center")?c.x=b.offset().left+b.width()/2:c.x+$(".js-tooltip").width()>$(window).width()&&(c.x=b.offset().left-$(".js-tooltip").width()-20,$(".js-tooltip").addClass("tooltip-right")),$(".js-tooltip").css({top:c.y,left:c.x}).show(),$(".js-tooltip-body").html(a)},close:function(){$(".js-tooltip").removeClass("tooltip-right").hide()}},SplatSite.PromisePlaceholder=function(){var a=$(".js-promise-placeholder input, .js-promise-placeholder textarea"),b=$(".js-promise-placeholder .promise-placeholder"),c=b.find("span");b.on("click",function(){a.trigger("focus")}),a.on("focus",function(){c.hide()}),a.on("focusout",function(){""==a.val()&&c.show()}),""!=a.val()&&a.trigger("focus"),$(".js-promise-placeholder textarea").autosize()},SplatSite.CountDown=function(a){$.fn.MyCount=function(){for(var a=$(this).parents("[data-finish]"),b=a.attr("data-finish"),c=0;2>c;c++)b=b.replace("-","/");$(this).countdown(b,function(a){var b=declOfNum(parseInt(a.strftime("%-D")),["день","дня","дней"]);$(this).html(a.strftime('<span class="time-day"><span>%-D</span> '+b+'</span><span class="time-time">%H:%M:%S</span>')),("stoped"==a.type||"finish"==a.type)&&(window.location.href="?prefail=1")})},$(a).MyCount()},SplatSite.CardCountDown=function(a){$.fn.MyCount=function(){$(this).each(function(){for(var a=$(this).parents("[data-finish]"),b=a.attr("data-finish"),c=0;2>c;c++)b=b.replace("-","/");$(this).countdown(b,function(a){if("stoped"!=a.type||"finish"!=a.type){var b=a.finalDate.getTime()-(new Date).getTime(),c=864e5;c>b&&b>=0&&$(this).html(a.strftime("%H:%M:%S"))}})})},$(a).MyCount()},SplatSite.Common=function(){$(".js-advice").on("click",function(){return $(".js-advice-to").val($(this).text()).trigger("focus"),!1}),$(".ui-select").customSelect()},$.fn.AjaxForm=function(){var a=$(this).attr("action"),b=$(this);b.find(".js-ajax-after").hide(),$(this).on("submit",function(c){return b.find("[type=submit]").attr("disabled","disabled").addClass("loading"),$.ajax({url:a,data:b.serialize(),type:"post"}).done(function(a){b.find(".js-ajax-result").text(a.responseText),b.find(".js-ajax-before").slideUp(),b.find(".js-ajax-after").slideDown()}).fail(function(){console.log(data)}),c.preventDefault(),!1})},$.fn.SmartBtn=function(){$(this).each(function(){var a=$(this),b=!1;a.on("click",function(){return b?void 0:($(this).addClass("clicked"),b=!0,!1)}),a.on("click",".js-no",function(){return b?(a.removeClass("clicked"),b=!1,!1):void 0}),a.on("click",".js-yes",function(){return b?("promise-delete"==$(this).attr("data-ga")&&ga("send","event","promise","delete"),"comment-delete"==$(this).attr("data-ga")&&ga("send","event","comment","delete"),window.location.href=a.attr("data-href"),!1):void 0})})},SplatSite.ValidEmail=function(){if($(".js-email-input").length){var a=function(){var a=$(".js-email-input").val(),b=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;b.test(a)?$(".js-email-check-cont").slideDown():$(".js-email-check-cont").slideUp()};$(".js-email-input").on("input",function(){a()}),a()}},SplatSite.ValidPhone=function(){if($(".js-phone").length){var a="POST",b=SplatDict.urls,c=$(".js-phone-error"),d=$(".js-phone .phone-status"),e=function(){c.slideUp()},f=function(a){c.html(a).slideDown()},g=function(){$(".js-valid-errors").hide()},h=function(a){$(".js-valid-errors").html(a).show()},i=function(a){"show"==a?$(".js-phone-check-cont").slideDown():$(".js-phone-check-cont").slideUp()},j=function(c){var g=c.val(),h=g.replace("(","").replace(")","").replace("-","").replace("-",""),j={user_id:SplatDict.user_id,phone:h};e(),$.ajax({url:b.check_phone,data:j,method:a}).done(function(a){0==a.status?f("Произошла ошибка. Попробуйте позже"):("new"==a.state&&(d.filter('[data-status="new"]').fadeIn(),f('<a href="#" class="js-phone-popup">Подтвердите свой номер телефона</a>'),i("close")),"valid"==a.state&&(d.filter('[data-status="valid"]').fadeIn(),i("show")))}).fail(function(){f("Произошла ошибка. Попробуйте позже")})},k=function(){var c=$(".js-phone-input").val(),d=c.replace("(","").replace(")","").replace("-","").replace("-",""),e={user_id:SplatDict.user_id,phone:d};$(".js-phone-code").val(""),$(".js-phone-popup").addClass("loading"),$(".js-valid-repeat").addClass("loading-link"),$.ajax({data:e,url:b.send_sms,method:a}).done(function(a){$(".js-valid-repeat").removeClass("loading-link"),$(".js-phone-popup").removeClass("loading"),0==a.status?f("Произошла ошибка. Попробуйте позже"):SplatSite.simpleBox().open("sms")}).fail(function(){$(".js-valid-repeat").removeClass("loading-link"),$(".js-phone-popup").removeClass("loading"),f("Произошла ошибка. Попробуйте позже")})},l=function(){var c={user_id:SplatDict.user_id,code:$(".js-phone-code").val()};console.log(c),$(".js-code-check").addClass("loading-link"),$.ajax({data:c,url:b.check_code,method:a}).done(function(a){$(".js-code-check").removeClass("loading-link"),0==a.status?(h("Неверный код подтверждения"),i("close")):(e(),g(),SplatSite.simpleBox().close(),d.filter('[data-status="new"]').fadeOut(),d.filter('[data-status="valid"]').fadeIn(),i("show"))}).fail(function(){$(".js-code-check").removeClass("loading-link"),h("Произошла ошибка. Попробуйте позже"),i("close")})};$(".js-phone-input").on("input",function(){$(".js-phone-input").inputmask("isComplete")||(e(),d.hide(),i("close"))}),$(".js-phone-input").inputmask("+7(999)999-99-99",{oncomplete:function(){j($(this))}}),$(".js-phone-input").inputmask("isComplete")&&j($(".js-phone-input")),$(document).on("click",".js-phone-popup",function(){return $(this).hasClass("loading")||$(".js-code-check").hasClass("loading-link")||k(),!1}),$(document).on("click",".js-valid-repeat",function(){return $(this).hasClass("loading-link")||$(".js-code-check").hasClass("loading-link")||(k(),h("Новый код отправлен")),!1}),$(document).on("click",".js-code-check",function(){return $(this).hasClass("loading-link")||$(".js-valid-repeat").hasClass("loading-link")||l(),!1})}},function(a){"function"==typeof define&&define.amd?define(["../datepicker"],a):a(jQuery.datepicker)}(function(a){return a.regional.ru={closeText:"Закрыть",prevText:"&#x3C;Пред",nextText:"След&#x3E;",currentText:"Сегодня",monthNames:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],monthNamesShort:["Янв","Фев","Мар","Апр","Май","Июн","Июл","Авг","Сен","Окт","Ноя","Дек"],dayNames:["воскресенье","понедельник","вторник","среда","четверг","пятница","суббота"],dayNamesShort:["вск","пнд","втр","срд","чтв","птн","сбт"],dayNamesMin:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],weekHeader:"Нед",dateFormat:"dd.mm.yy",firstDay:1,isRTL:!1,showMonthAfterYear:!1,yearSuffix:""},a.setDefaults(a.regional.ru),a.regional.ru}),$.datepicker.setDefaults($.datepicker.regional.ru),$(function(){$("body");SplatSite.Common(),SplatSite.tabs(),SplatSite.ShowFriends(),SplatSite.Tooltips.init(),SplatSite.PromisePlaceholder(),SplatSite.ValidPhone(),SplatSite.ValidEmail(),$(".js-smart-btn").SmartBtn(),$(".js-countdown").length&&SplatSite.CountDown(".js-countdown"),$(".js-time-countdown").length&&SplatSite.CardCountDown(".js-time-countdown"),$(".js-ajax-form").AjaxForm(),$(".styledCheck").button(),$.extend($.inputmask.defaults.definitions,{i:{validator:"[0-5][0-9]",cardinality:2,prevalidator:[{validator:"[0-5]",cardinality:1}]},H:{validator:"[01][0-9]|2[0-3]",cardinality:2,prevalidator:[{validator:"[0-2]",cardinality:1}]}}),$.extend($.inputmask.defaults,{clearMaskOnLostFocus:!1}),$(".js-mask-time").inputmask("H:i",{placeholder:"чч:мм"}),""==$(".js-mask-time").val()&&$(".js-mask-time").val("12:00"),$(".js-mask-date").inputmask("dd.mm.yyyy",{placeholder:"дд.мм.гггг"}).datepicker({showOtherMonths:!0,defaultDate:new Date(1990,0,1),changeYear:!0,maxDate:0}),$(".js-future-date").inputmask("dd.mm.yyyy",{placeholder:"дд.мм.гггг",yearrange:{minyear:(new Date).getFullYear(),maxyear:2099}}).datepicker({showOtherMonths:!0,changeYear:!0,minDate:0,onSelect:function(){$("[name=limit_date]").valid(),$("[name=limit_time]").valid()}}),$(document).keypress(function(a){13==a.which&&$(".js-promise-input").is(":focus")&&$(".make-new-promise-btn").trigger("click")}),$(".date-div, .time-div").on("click",function(){$(this).find("input").trigger("focus")})});
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