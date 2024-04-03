<?php

/**
 * Single Product Price.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

if ( $product->is_type( 'variable' ) ) {
	$regular_price_min = $product->get_variation_regular_price( 'min', true );
	$active_price_min = $product->get_variation_price( 'min', true );
}

?>

	<div class="flex flex-row-reverse items-center w-max md:block md:flex-row">

		<?php if ( $product->is_on_sale() ) { ?>
		<div class="md:mb-0.5">
			<div class="flex items-center">
				<div class="text-neutral-300 text-small line-through"><?php echo wc_price( $regular_price_min ); ?></div>
				<span class="badge bagde-discount bg-accent-red bg-opacity-30 rounded-6 text-accent-red text-xs font-bold leading-6 uppercase whitespace-nowrap inline-block px-2 mx-2"><?php echo dots_presentage_ribbon( $product ); ?></span>
				<div class="text-neutral-300 body-text-3">Kamu hemat <?php echo wc_price( $regular_price_min - $active_price_min ) ?></div>
			</div>
		</div>
		<?php } ?>

		<div class="heading-4 text-primary-1 mr-2 md:mr-0"><?php echo wc_price( $product->get_price() ); ?></div>

	</div>
