class DEA_Banner_Slides extends elementorModules.frontend.handlers.Base {
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

		const elementSettings = this.getElementSettings();
		const slickOptions = {
			autoplay: 'yes' === elementSettings.autoplay,
			arrows: -1 !== [ 'arrows', 'both' ].indexOf( elementSettings.navigation ),
			centerMode: 'yes' === elementSettings.center_mode,
			dots: -1 !== [ 'dots', 'both' ].indexOf( elementSettings.navigation ),
			infinite: 'yes' === elementSettings.infinite,
			speed: elementSettings.speed,
			variableWidth: 'true' === elementSettings.variable_width,
			responsive: [
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						centerMode: false,
						centerPadding: '40px',
						slidesToShow: 1,
						variableWidth: false,
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

		if ( 'yes' === elementSettings.center_mode ) {
			slickOptions.centerPadding = {
				centerPadding: elementSettings.center_padding.size + elementSettings.center_padding.unit,
			};
		}

		this.elements.$slick.slick( slickOptions );
	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
	const addHandler = ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( DEA_Banner_Slides, {
			$element,
		} );
	};

	elementorFrontend.hooks.addAction( 'frontend/element_ready/dea-banner-slides.default', addHandler );
} );
