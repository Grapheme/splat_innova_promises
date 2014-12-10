var SplatSite = {};
SplatSite.index = function() {
	var main_fotorama = function() {
		var fsets = {
			fit: 'cover',
			width: '100%',
			height: '600px',
			autoplay: 5000,
			transition: 'dissolve',
			arrows: false,
			nav: false
		};
		$('.js-main-fotorama').fotorama(fsets);
	}

	main_fotorama();
}

$(function(){
	var body = $('body');
	if(body.hasClass('index-page')) {
		SplatSite.index();
	}
});