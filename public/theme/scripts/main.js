var SplatSite={};SplatSite.tabs=function(){var a=$(".js-open-box"),b=$(".js-pop-close"),c=$(".overlay-shadow"),d=$(".overlay"),e={};e.retPos=function(a){var b={};b.top=a.offset().top-$(window).scrollTop(),b.left=a.offset().left-$(window).scrollLeft(),b.bottom=window.innerHeight-b.top-a.height(),b.right=window.innerWidth-b.left-a.width(),c.css({top:b.top,left:b.left,bottom:b.bottom,right:b.right})},e.open=function(a){if(a.hasClass("js-promise-btn")){if(""==$(".js-promise-input").val())return;$(".js-promise-title").show(),$(".js-promise-title").text($(".js-promise-input").val())}var b=a.attr("data-box"),e=$('.js-pop-up[data-box="'+b+'"]');this.retPos(a),a.addClass("js-opened-from"),setTimeout(function(){c.addClass("anim active"),setTimeout(function(){d.show(),e.show(),setTimeout(function(){e.addClass("active")},150)},150)},10)},e.close=function(){var a=$(".js-opened-from"),b=a.attr("data-box"),e=$('.js-pop-up[data-box="'+b+'"]');a.removeClass("js-opened-from"),this.retPos(a),c.removeClass("active"),e.removeClass("active"),setTimeout(function(){d.hide(),c.removeClass("anim").removeAttr("style"),e.hide(),$(".js-promise-title").hide()},500)};var f=function(){a.on("click",function(){return e.open($(this)),!1}),b.on("click",function(){return e.close($(this)),!1}),$(".js-form-pass").on("click",function(){return $(".js-pop-form").hide(),$('.js-pop-form[data-type="pass"]').show(),!1})},g=function(){f()};g()},SplatSite.index=function(){var a=function(){var a={fit:"cover",width:"100%",height:"600px",autoplay:6e3,transitionduration:1e3,transition:"dissolve",arrows:!1,nav:!1};$(".js-main-fotorama").fotorama(a)},b=function(){var a={width:"100%",height:"600px",autoplay:4e3,transitionduration:1e3,transition:"dissolve",arrows:!1,nav:!1};$(".js-promises-fotorama").fotorama(a)},c=function(){{var a=document.querySelector(".js-promises");new Masonry(a,{columnWidth:1,itemSelector:"li"})}},d=function(){a(),b(),c()};d()},SplatSite.ProfileEdit=function(){},SplatSite.Promise=function(){var a={};a.init=function(){this.events(),$(".js-types li").first().trigger("click")},a.setStyle=function(a){$(".js-type-select").val(a).trigger("change",[a])},a.events=function(){var a=this;$(".js-type-select").on("change",function(a,b){$(".js-type-parent").removeClass("type-blue type-yellow type-aqua type-green type-pink"),$(".js-type-parent").addClass("type-"+b),$(".js-types .type-"+b).addClass("active").siblings().removeClass("active")}),$(".js-types li").on("click",function(){var b=$(this).attr("data-type");a.setStyle(b)})},a.init()},SplatSite.InviteForm=function(){$(".js-inv-btn").on("click",function(){return $(".js-inv-btn-cont").slideUp(),$(".js-inv-form").slideDown(function(){$(this).find("input").trigger("focus")}),!1})},SplatSite.ShowFriends=function(){$(".show-more-friends").on("click",function(){for(var a=this,b=0;12>b;b++)$(".friend-item.hidden").eq(b).removeClass("hidden");0==$(".friend-item.hidden").length&&a.hide()})},$(function(){$("body");SplatSite.tabs(),SplatSite.ShowFriends(),$(".styledCheck").button(),$(".js-mask-time").mask("00:00",{placeholder:"00:00"}),$(".js-mask-date").mask("0000-00-00",{placeholder:"0000-00-00"})});