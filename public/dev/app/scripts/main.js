var SplatSite = {};
SplatSite.tabs = function() {
	var open_link = $('.js-open-box'),
		close_link = $('.js-pop-close'),
		overlay_shadow = $('.overlay-shadow'),
		change_link = $('.js-change-box'),
		overlay = $('.overlay'),
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
		if(link.hasClass('js-promise-btn')) {
			if($('.js-promise-input').val() != '') {
				$('.js-promise-title').show();
				$('.js-promise-title').text($('.js-promise-input').val());
			} else {
				return;
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
		box.removeClass('active');
		setTimeout(function(){
			overlay.hide();
			overlay_shadow.removeClass('anim').removeAttr('style');
			box.hide();
			$('.js-promise-title').hide();
		}, 500);
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
			popup.close();
			popup.open($('.js-open-box[data-box="' + $(this).attr('data-box') + '"]').first());
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
		$('.js-main-fotorama').fotorama(fsets);
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
		$('.js-tooltip').css({
			top: pos.y,
			left: pos.x
		}).show();
		$('.js-tooltip-body').text(text);
	},
	close: function() {
		$('.js-tooltip').hide();
	}
}

SplatSite.PromisePlaceholder = function() {
	var input = $('.js-promise-placeholder input, .js-promise-placeholder textarea');
	var dots = $('.js-promise-placeholder .promise-placeholder span');
	input.on('focus', function(){
		console.log(dots);
		dots.hide();
	});
	input.on('focusout', function(){
		if(input.val() == '') {
			dots.show();
		}
	});
	$('.js-promise-placeholder textarea').autosize();
}

$(function(){
	var body = $('body');
	SplatSite.tabs();
	SplatSite.ShowFriends();
	SplatSite.Tooltips.init();
	SplatSite.PromisePlaceholder();

	$('.styledCheck').button();

	$('.js-mask-time').mask('00:00', {placeholder: "00:00"});
	$('.js-mask-date').mask('00.00.0000', {placeholder: "дд.мм.гггг"});
});