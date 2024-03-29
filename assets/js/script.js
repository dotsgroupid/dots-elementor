jQuery(function ($) {
	"use strict";

	$( '.product-slider .slick-slider' ).slick({
		infinite: false,
		slidesToShow: 6,
		slidesToScroll: 6,
	});

	$( '.channel-content .slick-slider' ).slick({
		infinite: false,
		slidesToShow: 4,
		slidesToScroll: 4,
	});

});
