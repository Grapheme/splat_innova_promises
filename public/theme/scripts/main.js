function declOfNum(a,b){return cases=[2,0,1,1,1,2],b[a%100>4&&20>a%100?2:cases[5>a%10?a%10:5]]}var SplatSite={};SplatSite.tabs=function(){var a=$(".js-open-box"),b=$(".js-pop-close"),c=$(".overlay-shadow"),d=$(".js-change-box"),e=$(".overlay"),f=!1,g={};g.retPos=function(a){var b={};b.top=a.offset().top-$(window).scrollTop(),b.left=a.offset().left-$(window).scrollLeft(),b.bottom=window.innerHeight-b.top-a.height(),b.right=window.innerWidth-b.left-a.width(),c.css({top:b.top,left:b.left,bottom:b.bottom,right:b.right})},g.open=function(a){clearTimeout(f),a.hasClass("js-promise-btn")&&(""!=$(".js-promise-input").val()?($(".js-promise-title").show(),$(".js-promise-title").text($(".js-promise-input").val())):$('[data-box="req"]').trigger("click"));var b=a.attr("data-box"),d=$('.js-pop-up[data-box="'+b+'"]');this.retPos(a),a.addClass("js-opened-from"),setTimeout(function(){c.addClass("anim active"),setTimeout(function(){e.show(),d.show(),setTimeout(function(){d.addClass("active")},150)},150)},10)},g.close=function(){var a=$(".js-opened-from"),b=a.attr("data-box"),d=$('.js-pop-up[data-box="'+b+'"]');a.removeClass("js-opened-from"),this.retPos(a),c.removeClass("active"),d.removeClass("active").siblings().removeClass("active"),f=setTimeout(function(){e.hide(),c.removeClass("anim").removeAttr("style"),d.hide().siblings().hide(),$(".js-promise-title").hide()},500)},g.change=function(a){var b=$('.js-pop-up[data-box="'+a+'"]');b.show().addClass("active").siblings().hide().removeClass("active")};var h=function(){a.on("click",function(){return g.open($(this)),!1}),b.on("click",function(){return g.close(),!1}),d.on("click",function(){return g.change($(this).attr("data-box")),!1}),$(".js-form-pass").on("click",function(){return $(".js-pop-form").hide(),$('.js-pop-form[data-type="pass"]').show(),!1})},i=function(){h()};i()},SplatSite.index=function(){var a=function(a){var b=$(".js-slide-title.active");b.addClass("faded"),setTimeout(function(){$(".js-slide-title.faded.active").removeClass("active faded")},1500),setTimeout(function(){$(".js-slide-title").eq(a).addClass("active")},250)},b=function(){var b={fit:"cover",width:"100%",height:"600px",autoplay:6e3,transitionduration:1e3,transition:"dissolve",arrows:!1,nav:!1},c=$(".js-main-fotorama").fotorama(b),d=(c.data("fotorama"),!1);$(".js-main-fotorama").on("fotorama:load",function(){d||(a(0),d=!0)}),$(".js-main-fotorama").on("fotorama:show",function(b,c){a(c.activeIndex)})},c=function(){var a={width:"100%",height:"600px",autoplay:4e3,transitionduration:1e3,transition:"dissolve",arrows:!1,nav:!1};$(".js-promises-fotorama").fotorama(a)},d=function(){{var a=document.querySelector(".js-promises");new Masonry(a,{columnWidth:1,itemSelector:"li"})}},e=function(){b(),c(),d()};e()},SplatSite.ProfileEdit=function(){},SplatSite.Promise=function(){var a={};a.init=function(){this.events(),$(".js-types li").first().trigger("click")},a.setStyle=function(a){$(".js-type-select").val(a).trigger("change",[a])},a.events=function(){var a=this;$(".js-type-select").on("change",function(a,b){$(".js-type-parent").removeClass("type-blue type-yellow type-aqua type-green type-pink"),$(".js-type-parent").addClass("type-"+b),$(".js-types .type-"+b).addClass("active").siblings().removeClass("active")}),$(".js-types li").on("click",function(){var b=$(this).attr("data-type");a.setStyle(b)})},a.init()},SplatSite.InviteForm=function(){$(".js-inv-btn").on("click",function(){return $(".js-inv-btn-cont").slideUp(),$(".js-inv-form").slideDown(function(){$(this).find("input").trigger("focus")}),!1})},SplatSite.ShowFriends=function(){var a=function(){var a=0;$(".friend-item.hidden").each(function(){$(this).attr("data-number",a),a++})},b=function(){$(".friend-item").not(".hidden").each(function(){var a=$(this).find(".profile-photo"),b=a.attr("data-style");a.attr("style",b)})};b(),$(".show-more-friends").on("click",function(){var c=$(this);a();for(var d=0;12>d;d++)$('.friend-item.hidden[data-number="'+d+'"]').removeClass("hidden");return 0==$(".friend-item.hidden").length&&c.hide(),b(),!1})},SplatSite.Tooltips={init:function(){var a=this,b='<div class="js-tooltip"><div class="js-tooltip-body"></div></div>';$("body").append(b),$("[data-tooltip]").on("mouseover",function(){var b=$(this).attr("data-tooltip"),c=$(this);a.show(b,c)}),$("[data-tooltip]").on("mouseout",function(){a.close()})},show:function(a,b){var c={};c.x=b.offset().left+b.width()+20,c.y=b.offset().top+b.height()/2,c.x+$(".js-tooltip").width()>$(window).width()&&(c.x=b.offset().left-$(".js-tooltip").width()-20,$(".js-tooltip").addClass("tooltip-right")),$(".js-tooltip").css({top:c.y,left:c.x}).show(),$(".js-tooltip-body").text(a)},close:function(){$(".js-tooltip").removeClass("tooltip-right").hide()}},SplatSite.PromisePlaceholder=function(){var a=$(".js-promise-placeholder input, .js-promise-placeholder textarea"),b=$(".js-promise-placeholder .promise-placeholder"),c=b.find("span");b.on("click",function(){a.trigger("focus")}),a.on("focus",function(){c.hide()}),a.on("focusout",function(){""==a.val()&&c.show()}),""!=a.val()&&a.trigger("focus"),$(".js-promise-placeholder textarea").autosize()},SplatSite.CountDown=function(a){$.fn.MyCount=function(){for(var a=$(this).parents("[data-finish]"),b=a.attr("data-finish"),c=0;2>c;c++)b=b.replace("-","/");$(this).countdown(b,function(a){var b=declOfNum(parseInt(a.strftime("%-D")),["день","дня","дней"]);$(this).html(a.strftime('<span class="time-day"><span>%-D</span> '+b+'</span><span class="time-time">%H:%M:%S</span>'))})},$(a).MyCount()},$.fn.AjaxForm=function(){var a=$(this).attr("action"),b=$(this);b.find(".js-ajax-after").hide(),$(this).on("submit",function(c){return b.find("[type=submit]").attr("disabled","disabled").addClass("loading"),$.ajax({url:a,data:b.serialize(),type:"post"}).done(function(a){b.find(".js-ajax-result").text(a.responseText),b.find(".js-ajax-before").slideUp(),b.find(".js-ajax-after").slideDown()}).fail(function(){console.log(data)}),c.preventDefault(),!1})},$(function(){$("body");SplatSite.tabs(),SplatSite.ShowFriends(),SplatSite.Tooltips.init(),SplatSite.PromisePlaceholder(),$("[data-finish]").length&&SplatSite.CountDown(".js-countdown"),$(".js-ajax-form").AjaxForm(),$(".styledCheck").button(),$.extend($.inputmask.defaults.definitions,{i:{validator:"[0-5][0-9]",cardinality:2,prevalidator:[{validator:"[0-5]",cardinality:1}]},H:{validator:"[01][0-9]|2[0-3]",cardinality:2,prevalidator:[{validator:"[0-2]",cardinality:1}]}}),$(".js-mask-time").inputmask("H:i",{placeholder:"чч:мм"}),""==$(".js-mask-time").val()&&$(".js-mask-time").val("12:00"),$(".js-mask-date").inputmask("d.m.y",{placeholder:"дд.мм.гггг"}),$(document).keypress(function(a){13==a.which&&$(".js-promise-input").is(":focus")&&$(".make-new-promise-btn").trigger("click")})});