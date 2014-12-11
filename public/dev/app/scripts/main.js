var SplatSite = {};
SplatSite.tabs = function() {
	var open_link = $('.js-open-box'),
		close_link = $('.js-pop-close'),
		overlay_shadow = $('.overlay-shadow'),
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
			popup.close($(this));
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

$(function(){
	var body = $('body');
	SplatSite.tabs();
	if(body.hasClass('index-page')) {
		SplatSite.index();
	}
});