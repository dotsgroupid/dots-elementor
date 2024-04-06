class DEA_Banner_Carousel extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				slick: '.slick-slider',
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );
		return {
			$slick: this.$element.find( selectors.slick ),
		};
	}

	onInit() {
		super.onInit();

		const elementSettings = this.getElementSettings(),
			slidesToShow = +elementSettings.slides_to_show || 4,
			isSingleSlide = 1 === slidesToShow,
			defaultLGDevicesSlidesCount = isSingleSlide ? 1 : 2;

		const slickOptions = {
			autoplay: 'yes' === elementSettings.autoplay,
			arrows: -1 !== [ 'arrows', 'both' ].indexOf( elementSettings.navigation ),
			dots: -1 !== [ 'dots', 'both' ].indexOf( elementSettings.navigation ),
			infinite: 'yes' === elementSettings.infinite,
			speed: elementSettings.speed,
			slidesToShow: slidesToShow,
			responsive: [
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						slidesToShow: 1,
						slidesToScroll: 1,
					},
				},
			],
		}

		if ( 'yes' === elementSettings.autoplay ) {
			slickOptions.autoplay = {
				pauseOnHover: elementSettings.pause_on_hover,
			};

			slickOptions.autoplay = {
				autoplaySpeed: elementSettings.autoplay_speed,
			};
		}

		if ( ! isSingleSlide ) {
			slickOptions.slidesToScroll = +elementSettings.slides_to_scroll || defaultLGDevicesSlidesCount;
		}

		this.elements.$slick.slick( slickOptions );
	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
	const addHandler = ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( DEA_Banner_Carousel, {
			$element,
		} );
	};

	elementorFrontend.hooks.addAction( 'frontend/element_ready/dea-banner-carousel.default', addHandler );
} );
