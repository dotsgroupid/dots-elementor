jQuery( function ( $ ) {
	"use strict";

	$( '.channel-content .slick-slider' ).slick({
		infinite: false,
		slidesToShow: 4,
		slidesToScroll: 4,
	});

	/**
     * Change product quantity
     */
    $( document ).on( 'click', '.stepper-wrapper .minus-wrapper, .stepper-wrapper .plus-wrapper', function (event) {
		event.preventDefault();

		var $this = $( this ),
			$value = $this.siblings( '.value-wrapper' ),
			current = parseInt( $value.text(), 10 ),
			min = 1,
			max = current + 1;

		if ( $this.hasClass( 'minus-wrapper' ) && current > min ) {
			$( '.stepper-wrapper .minus-wrapper' ).removeClass( 'btn-disabled border-neutral-500 text-neutral-500' );
			$( '.stepper-wrapper .di-minus' ).removeClass( 'text-neutral-100' );
			$( '.stepper-wrapper .minus-wrapper' ).addClass( 'btn-disabled border-neutral-700 text-neutral-700' );
			$( '.stepper-wrapper .di-minus' ).addClass( 'text-neutral-600' );

			$value.text( current - 1 );
			$value.trigger( 'change' );
		}

		if ( $this.hasClass( 'plus-wrapper' ) && current < max ) {
			$( '.stepper-wrapper .minus-wrapper' ).removeClass( 'btn-disabled border-neutral-700 text-neutral-700' );
			$( '.stepper-wrapper .di-minus' ).removeClass( 'text-neutral-600' );
			$( '.stepper-wrapper .minus-wrapper' ).addClass( 'btn-disabled border-neutral-500 text-neutral-500' );
			$( '.stepper-wrapper .di-minus' ).addClass( 'text-neutral-100' );

			$value.text( current + 1 );
			$value.trigger( 'change' );
		}
	} );

} );
