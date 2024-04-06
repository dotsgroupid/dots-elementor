jQuery( function ( $ ) {
	"use strict";

	$( '.product-list-filter' ).on( 'keyup', '.text-input input', function (e) {
		var valid = false;

		if ( typeof e.which == 'undefined' ) {
			valid = true;
		} else if ( typeof e.which == 'number' && e.which > 0 ) {
			valid = ! e.ctrlKey && ! e.metaKey && ! e.altKey;
		}

		if ( ! valid ) {
			return;
		}

		var val = $( this ).val();

		if ( typeof val === 'number' ) {
			val = '' + val;
		}

		var filter = val.toUpperCase(),
			widget = $(this).closest( '.product-list-filter' ),
			ul = widget.find( 'ul' ),
			items = ul.children( '.filter-list-checkbox' );

		items.each(function () {
			var a = $(this).find( 'a' ).data( 'title' );

			if (typeof a === 'number') {
				a = '' + a;
			}

			a = a.toUpperCase();

			if ( a.indexOf( filter ) > -1 ) {
				$( this ).show();
			} else {
				$( this ).hide();
			}
		});
	} );

	/**
     * Change product quantity
     */
    $( document ).on( 'click', '.stepper-wrapper .minus-wrapper, .stepper-wrapper .plus-wrapper', function (event) {
		event.preventDefault();

		var $this = $( this ),
			$value = $this.siblings( '.qty' ),
			current = parseInt( $value.val(), 10 ),
			min = 1,
			max = current + 1;

		if ( $this.hasClass( 'minus-wrapper' ) && current > min ) {
			$( '.stepper-wrapper .minus-wrapper' ).removeClass( 'btn-disabled border-neutral-500 text-neutral-500' );
			$( '.stepper-wrapper .di-minus' ).removeClass( 'text-neutral-100' );
			$( '.stepper-wrapper .minus-wrapper' ).addClass( 'btn-disabled border-neutral-700 text-neutral-700' );
			$( '.stepper-wrapper .di-minus' ).addClass( 'text-neutral-600' );

			$value.val( current - 1 );
			$value.trigger( 'change' );
		}

		if ( $this.hasClass( 'plus-wrapper' ) && current < max ) {
			$( '.stepper-wrapper .minus-wrapper' ).removeClass( 'btn-disabled border-neutral-700 text-neutral-700' );
			$( '.stepper-wrapper .di-minus' ).removeClass( 'text-neutral-600' );
			$( '.stepper-wrapper .minus-wrapper' ).addClass( 'btn-disabled border-neutral-500 text-neutral-500' );
			$( '.stepper-wrapper .di-minus' ).addClass( 'text-neutral-100' );

			$value.val( current + 1 );
			$value.trigger( 'change' );
		}
	} );

} );
