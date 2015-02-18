var SplatSite = {};
SplatSite.tabs = function() {
	var open_link = $('.js-open-box'),
		close_link = $('.js-pop-close'),
		overlay_shadow = $('.overlay-shadow'),
		change_link = $('.js-change-box'),
		overlay = $('.overlay'),
		close_timeout = false,
		popup = {};

	popup.retPos = function(link) {
		var pos = {};
		pos.top = link.offset().top - $(window).scrollTop();
		pos.left = link.offset().left - $(window).scrollLeft();
		pos.bottom = window.innerHeight - pos.top - link.height();
		pos.right = window.innerWidth - pos.left - link.width();
		overlay_shadow.css({
			'top': pos.top,
			'left': pos.left,
			'bottom': pos.bottom,
			'right': pos.right
		});
	}
	popup.open = function(link) {
		clearTimeout(close_timeout);
		if(link.hasClass('js-promise-btn')) {
			if($('.js-promise-input').val() != '') {
				$('.js-promise-title').show();
				$('.js-promise-title').text($('.js-promise-input').val());
			} else {
				$('[data-box="req"]').trigger('click');
			}
		}
		var box_name = link.attr('data-box');
		var box = $('.js-pop-up[data-box="' + box_name + '"]');
		this.retPos(link);
		link.addClass('js-opened-from');
		setTimeout(function(){
			overlay_shadow.addClass('anim active');
			setTimeout(function(){
				overlay.show();
				box.show();
				setTimeout(function(){
					box.addClass('active');
				}, 150);
			}, 150);
		}, 10);
	}
	popup.close = function() {
		var link = $('.js-opened-from');
		var box_name = link.attr('data-box');
		var box = $('.js-pop-up[data-box="' + box_name + '"]');
		link.removeClass('js-opened-from');
		this.retPos(link);
		overlay_shadow.removeClass('active');
		box.removeClass('active').siblings().removeClass('active');
		close_timeout = setTimeout(function(){
			overlay.hide();
			overlay_shadow.removeClass('anim').removeAttr('style');
			box.hide().siblings().hide();
			$('.js-promise-title').hide();
		}, 500);
	}
	popup.change = function(box_name) {
		var box = $('.js-pop-up[data-box="' + box_name + '"]');
		box.show().addClass('active')
				.siblings().hide().removeClass('active');
	}
	var setEvents = function() {
		open_link.on('click', function(){
			popup.open($(this));
			return false;
		});
		close_link.on('click', function(){
			popup.close();
			return false;
		});
		change_link.on('click', function(){
			popup.change($(this).attr('data-box'));
			return false;
		});
		$('.js-form-pass').on('click', function(){
			$('.js-pop-form').hide();
			$('.js-pop-form[data-type="pass"]').show();
			return false;
		});
	}
	var init = function() {
		setEvents();
	}

	init();
}
SplatSite.simpleBox = function() {
	var sparent = $('.soverlay');
	var sbox = sparent.find('.sbox');
	var open = function(name) {
		sparent.show();
		sbox.filter('[data-name="' + name + '"]').show();
	}
	var close = function() {
		sparent.hide();
		sbox.hide();
	}
	var init = function() {
		sbox.hide();
	}
	$('.soverlay').on('click', function(e){
		if($(e.target).hasClass('soverlay')) {
			close();
		}
	});
	init();
	return {open: open, close: close};
}
SplatSite.index = function() {
	var showSlide = function(id) {
		var active = $('.js-slide-title.active');
		active.addClass('faded');
		setTimeout(function(){
			$('.js-slide-title.faded.active').removeClass('active faded');
		}, 1500);
		setTimeout(function(){
			$('.js-slide-title').eq(id).addClass('active');
		}, 250);
	}

	var main_fotorama = function() {
		var fsets = {
			fit: 'cover',
			width: '100%',
			height: '560px',
			autoplay: 6000,
			transitionduration: 1000,
			transition: 'dissolve',
			arrows: false,
			nav: false
		};
		var $fotorama_ = $('.js-main-fotorama').fotorama(fsets);
		var fotorama = $fotorama_.data('fotorama');
		var loaded = false;
		$('.js-main-fotorama').on('fotorama:load', function (e, fotorama, extra){
			if(!loaded) {
				showSlide(0);
				loaded = true;
			}
		});
		$('.js-main-fotorama').on('fotorama:show', function (e, fotorama, extra){
		    showSlide(fotorama.activeIndex);
		});
	}

	var promises_fotorama = function() {
		var fsets = {
			width: '100%',
			height: '600px',
			autoplay: 4000,
			transitionduration: 1000,
			transition: 'dissolve',
			arrows: false,
			nav: false
		};
		$('.js-promises-fotorama').fotorama(fsets);
	}

	var promises_masonry = function() {
		/*var container = document.querySelector('.js-promises');
		var msnry = new Masonry( container, {
		  columnWidth: 1,
		  itemSelector: 'li'
		});*/
	}

	var promises_click = function() {
		$(document).on('click', '[data-promise-text]', function(){
			$('.js-promise-input').val($(this).attr('data-promise-text')).trigger('focus');
		});
	}

	var promise_card = function() {
		$('.js-promise-card-btn').on('click', function(){
			var parent = $(this).parents('.js-parent');
			var pr_text = parent.find('.js-promise-text').text();
			$('.js-promise-input').val(pr_text);
			$('.js-promise-placeholder promise-placeholder span').hide();
			$('.js-promise-btn').trigger('click');
			return false;
		});
	}

	var init = function() {
		main_fotorama();
		promises_fotorama();
		promises_masonry();
		promises_click();
		promise_card();
	}

	init();
}
SplatSite.ProfileEdit = function() {

}
SplatSite.Promise = function() {
	var select = {};
	select.init = function() {
		this.events();
		$('.js-types li').first().trigger('click');
	}
	select.setStyle = function(type) {
		$('.js-type-select').val(type).trigger('change', [type]);
	}
	select.events = function() {
		var self = this;
		$('.js-type-select').on('change', function(data, type){
			$('.js-type-parent').removeClass('type-blue type-yellow type-aqua type-green type-pink');
			$('.js-type-parent').addClass('type-' + type);
			$('.js-types .type-' + type).addClass('active')
				.siblings().removeClass('active');
		});
		$('.js-types li').on('click', function(){
			var type = $(this).attr('data-type');
			self.setStyle(type);
		});
	}
	select.init();
}
SplatSite.InviteForm = function() {
	$('.js-inv-btn').on('click', function(){
		$('.js-inv-btn-cont').slideUp();
		$('.js-inv-form').slideDown(function(){
			$(this).find('input').trigger('focus');
		});
		return false;
	});
}

SplatSite.ShowFriends = function() {
	var check = function() {
		var i = 0;
		$('.friend-item.hidden').each(function(){
			$(this).attr('data-number', i);
			i++;
		});
	};
	var showImage = function() {
		$('.friend-item').not('.hidden').each(function(){
			var photo_div = $(this).find('.profile-photo');
			var style_str = photo_div.attr('data-style');
			photo_div.attr('style', style_str);
		});
	}
	showImage();
	$('.show-more-friends').on('click', function(){
		var self = $(this);
		check();
		for(var i = 0; i < 12; i++) {
			$('.friend-item.hidden[data-number="' + i + '"]').removeClass('hidden');
		}
		if($('.friend-item.hidden').length == 0) {
			self.hide();
		}
		showImage();
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

SplatSite.PromisePlaceholder = function() {
	var input = $('.js-promise-placeholder input, .js-promise-placeholder textarea');
	var place = $('.js-promise-placeholder .promise-placeholder');
	var dots = place.find('span');
	place.on('click', function(){
		input.trigger('focus');
	});
	input.on('focus', function(){
		dots.hide();
	});
	input.on('focusout', function(){
		if(input.val() == '') {
			dots.show();
		}
	});
	if(input.val() != '') {
		input.trigger('focus');
	}
	$('.js-promise-placeholder textarea').autosize();
}

SplatSite.CountDown = function(elem) {
	$.fn.MyCount = function() {
		var parent = $(this).parents('[data-finish]');
		var date_str = parent.attr('data-finish');
		for(var i = 0; i < 2; i++) {
			date_str = date_str.replace('-', '/');
		}
		$(this).countdown(date_str, function(event){
			var days_name = declOfNum(parseInt(event.strftime('%-D')), ['день', 'дня', 'дней']);
			$(this).html(event.strftime('<span class="time-day"><span>%-D</span> ' + days_name + '</span><span class="time-time">%H:%M:%S</span>'));
			if(event.type == 'stoped' || event.type == 'finish') {
				window.location.href = '?prefail=1';
			}
		});
	}
	$(elem).MyCount();
}

SplatSite.CardCountDown = function(elem) {
	$.fn.MyCount = function() {
		$(this).each(function(){
			var parent = $(this).parents('[data-finish]');
			var date_str = parent.attr('data-finish');
			for(var i = 0; i < 2; i++) {
				date_str = date_str.replace('-', '/');
			}
			$(this).countdown(date_str, function(event){
				if(event.type != 'stoped' || event.type != 'finish') {
					var difference = event.finalDate.getTime() - new Date().getTime();
					var oneDay = 86400000;
					if(difference < oneDay && difference >= 0) {
						$(this).html(event.strftime('%H:%M:%S'));
					}
				}
			});
		});
	}
	$(elem).MyCount();
}

SplatSite.Common = function() {
	$('.js-advice').on('click', function(){
		$('.js-advice-to')
			.val($(this).text())
			.trigger('focus');
		return false;
	});
	$('.ui-select').customSelect();
}

$.fn.AjaxForm = function() {
	var action = $(this).attr('action');
	var form = $(this);
	form.find('.js-ajax-after').hide();
	$(this).on('submit', function(e){
		form.find('[type=submit]').attr('disabled', 'disabled').addClass('loading');
		$.ajax({
			url: action,
			data: form.serialize(),
			type: 'post'
		}).done(function(data){
			form.find('.js-ajax-result').text(data.responseText);
			form.find('.js-ajax-before').slideUp();
			form.find('.js-ajax-after').slideDown();
		}).fail(function(){
			console.log(data);
		});
		e.preventDefault();
		return false;
	});
}

$.fn.SmartBtn = function() {
	$(this).each(function(){
		var self = $(this);
		var opened = false;
		self.on('click', function(){
			if(!opened) {
				$(this).addClass('clicked');
				opened = true;
				return false;
			}
		});
		self.on('click', '.js-no', function(){
			if(opened) {
				self.removeClass('clicked');
				opened = false;
				return false;
			}
		});
		self.on('click', '.js-yes', function(){
			if(opened) {
				if($(this).attr('data-ga') == 'promise-delete') {
					ga('send', 'event', 'promise', 'delete');
				}
				if($(this).attr('data-ga') == 'comment-delete') {
					ga('send', 'event', 'comment', 'delete');
				}
				window.location.href = self.attr('data-href');
				return false;
			}
		});
	});
}

SplatSite.ValidPhone = function() {
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
				}
				if(resp.state == 'valid') {
					phone_status.filter('[data-status="valid"]').fadeIn();
				}
			}
		}).fail(function(){
			show_error('Произошла ошибка. Попробуйте позже');
		});
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
				SplatSite.simpleBox().open('sms');
			}
		})
		.fail(function(){
			$('.js-valid-repeat').removeClass('loading-link');
			$('.js-phone-popup').removeClass('loading');
			show_error('Произошла ошибка. Попробуйте позже');
		});
	}
	var checkCode = function() {
		var data = {
				user_id: SplatDict.user_id,
				code: $('.js-phone-code').val()
			};
		console.log(data);
		$('.js-code-check').addClass('loading-link');
		$.ajax({
			data: data,
			url: urls['check_code'],
			method: defaultMethod
		})
		.done(function(resp){
			$('.js-code-check').removeClass('loading-link');
			if(resp.status == false) {
				show_popup_error('Неверный код подтверждения');
			} else {
				hide_error();
				hide_popup_error();
				SplatSite.simpleBox().close();
				phone_status.filter('[data-status="new"]').fadeOut();
				phone_status.filter('[data-status="valid"]').fadeIn();
			}
		})
		.fail(function(){
			$('.js-code-check').removeClass('loading-link');
			show_popup_error('Произошла ошибка. Попробуйте позже');
		});
	}
	$('.js-phone-input').on('input', function(){
		if(!$('.js-phone-input').inputmask("isComplete")) {
			hide_error();
			phone_status.hide();
		}
	});
	$('.js-phone-input').inputmask('+7(999)999-99-99', {
	    "oncomplete": function(){
			checkThis($(this));
		}
	});
	if($('.js-phone-input').inputmask("isComplete")) {
		checkThis($('.js-phone-input'));
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
	$(document).on('click', '.js-code-check', function(){
		if(!$(this).hasClass('loading-link') && !$('.js-valid-repeat').hasClass('loading-link')) {
			checkCode();
		}
		return false;
	});
}

function declOfNum(number, titles) {  
    cases = [2, 0, 1, 1, 1, 2];  
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
}

/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}(function( datepicker ) {

datepicker.regional['ru'] = {
	closeText: 'Закрыть',
	prevText: '&#x3C;Пред',
	nextText: 'След&#x3E;',
	currentText: 'Сегодня',
	monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
	'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
	monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
	'Июл','Авг','Сен','Окт','Ноя','Дек'],
	dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
	dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
	dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	weekHeader: 'Нед',
	dateFormat: 'dd.mm.yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''};
datepicker.setDefaults(datepicker.regional['ru']);

return datepicker.regional['ru'];

}));
$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );

$(function(){
	var body = $('body');
	SplatSite.Common();
	SplatSite.tabs();
	SplatSite.ShowFriends();
	SplatSite.Tooltips.init();
	SplatSite.PromisePlaceholder();
	SplatSite.ValidPhone();
	$('.js-smart-btn').SmartBtn();
	if($('.js-countdown').length) {
		SplatSite.CountDown('.js-countdown');
	}
	if($('.js-time-countdown').length) {
		SplatSite.CardCountDown('.js-time-countdown');
	}
	$('.js-ajax-form').AjaxForm();

	$('.styledCheck').button();

	$.extend($.inputmask.defaults.definitions, {
        'i': { //minute
            "validator": "[0-5][0-9]",
            "cardinality": 2,
            "prevalidator": [{ "validator": "[0-5]", "cardinality": 1}]
        },
        'H': { //hour
            "validator": "[01][0-9]|2[0-3]",
            "cardinality": 2,
            "prevalidator": [{ "validator": "[0-2]", "cardinality": 1}]
        }
    });
    $.extend($.inputmask.defaults, {
    	clearMaskOnLostFocus: false
    });
	$('.js-mask-time').inputmask('H:i', {"placeholder": "чч:мм"});
	if($('.js-mask-time').val() == '') $('.js-mask-time').val('12:00');
	$('.js-mask-date')
		.inputmask('dd.mm.yyyy', {"placeholder": "дд.мм.гггг"})
		.datepicker({
			showOtherMonths: true,
			defaultDate: new Date(1990, 00, 01),
      		changeYear: true,
      		maxDate: 0
		});
	$('.js-future-date')
		.inputmask('dd.mm.yyyy', {"placeholder": "дд.мм.гггг", yearrange: { minyear: new Date().getFullYear(), maxyear: 2099 }})
		.datepicker({
			showOtherMonths: true,
      		changeYear: true,
      		minDate: 0,
      		onSelect: function (date) {
				//$('[name="limit_date"]').removeClass('inp-error');
				$("[name=limit_date]").valid()
				$("[name=limit_time]").valid();
			}
		});

	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        if($('.js-promise-input').is(':focus')) {
	        	$('.make-new-promise-btn').trigger('click');
	        }
	    }
	});
	$('.date-div, .time-div').on('click', function(){
		$(this).find('input').trigger('focus')
	});
});