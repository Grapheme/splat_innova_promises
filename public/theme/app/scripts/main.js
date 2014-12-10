var SplatSite = {};
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
			autoplay: 1000,
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

	main_fotorama();
	promises_fotorama();
	promises_masonry();
}

$(function(){
	var body = $('body');
	if(body.hasClass('index-page')) {
		SplatSite.index();
	}
});