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
			height: '600px',
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
		var container = document.querySelector('.js-promises');
		var msnry = new Masonry( container, {
		  columnWidth: 1,
		  itemSelector: 'li'
		});
	}

	var init = function() {
		main_fotorama();
		promises_fotorama();
		promises_masonry();
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
	$('.show-more-friends').on('click', function(){
		var self = $(this);
		check();
		for(var i = 0; i < 12; i++) {
			$('.friend-item.hidden[data-number="' + i + '"]').removeClass('hidden');
		}
		if($('.friend-item.hidden').length == 0) {
			self.hide();
		}
		return false;
	});
}

SplatSite.Tooltips = {
	init: function() {
		var self = this;
		var html = '<div class="js-tooltip"><div class="js-tooltip-body"></div></div>';
		$('body').append(html);
		$('[data-tooltip]').on('mouseover', function(){
			var text = $(this).attr('data-tooltip');
			var elem = $(this);
			self.show(text, elem);
		});
		$('[data-tooltip]').on('mouseout', function(){
			self.close();
		});
	},
	show: function(text, elem) {
		var pos = {};
		pos.x = elem.offset().left + elem.width() + 20;
		pos.y = elem.offset().top + elem.height()/2;
		if(pos.x + $('.js-tooltip').width() > $(window).width()) {
			pos.x = elem.offset().left - $('.js-tooltip').width() - 20;
			$('.js-tooltip').addClass('tooltip-right');
		}
		$('.js-tooltip').css({
			top: pos.y,
			left: pos.x
		}).show();
		$('.js-tooltip-body').text(text);
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
			var days_name = declOfNum(event.offset.days, ['день', 'дня', 'дней']);
			$(this).html(event.strftime('<span class="time-day"><span>%-D</span> ' + days_name + '</span><span class="time-time">%H:%M:%S</span>'));
		});
	}
	$(elem).MyCount();
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

function declOfNum(number, titles) {  
    cases = [2, 0, 1, 1, 1, 2];  
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
}

$(function(){
	var body = $('body');
	SplatSite.tabs();
	SplatSite.ShowFriends();
	SplatSite.Tooltips.init();
	SplatSite.PromisePlaceholder();
	if($('[data-finish]').length) {
		SplatSite.CountDown('.js-countdown');
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
	$('.js-mask-time').inputmask('H:i', {"placeholder": "чч:мм"});
	if($('.js-mask-time').val() == '') $('.js-mask-time').val('12:00');
	$('.js-mask-date').inputmask('d.m.y', {"placeholder": "дд.мм.гггг"});
});