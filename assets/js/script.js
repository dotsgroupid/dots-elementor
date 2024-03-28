jQuery(function ($) {
	"use strict";

	$( '#banner .slick-slider' ).slick({
		autoplay: true,
		centerMode: true,
		centerPadding: '208px',
		dots: true,
		infinite: true,
		variableWidth: true,
	});

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
