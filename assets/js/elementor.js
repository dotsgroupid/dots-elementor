class DOTS_Slides extends elementorModules.frontend.handlers.Base {
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

	getSlickSettings() {
		const elementSettings = this.getElementSettings();

		const slickOptions = {
			autoplay: 'yes' === elementSettings.autoplay,
			speed: elementSettings.speed,
		};

		if ( 'yes' === elementSettings.autoplay ) {
			slickOptions.autoplay = {
				speed: elementSettings.speed,
			};
		}

		return slickOptions;
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
			variableWidth: true,
		}

		if ( 'yes' === elementSettings.autoplay ) {
			slickOptions.autoplay = {
				autoplaySpeed: elementSettings.autoplay_speed,
			};
		}

		if ( 'yes' === elementSettings.centerPadding ) {
			slickOptions.centerPadding = {
				centerPadding: elementSettings.center_padding.size + elementSettings.center_padding.unit,
			};
		}

		this.elements.$slick.slick( slickOptions );
	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
	const addHandler = ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( DOTS_Slides, {
			$element,
		} );
	};

	elementorFrontend.hooks.addAction( 'frontend/element_ready/dots-slides.default', addHandler );
} );
