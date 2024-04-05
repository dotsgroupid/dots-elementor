<?php

/**
 * Single Product Price.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

?>

	<div class="flex flex-row-reverse items-center w-max md:block md:flex-row">

		<?php
			if ( $product->is_type( 'variable' ) ) {
				$prices = $product->get_variation_prices( true );

				$min_price     = current( $prices['price'] );
				$max_price     = end( $prices['price'] );
				$min_reg_price = current( $prices['regular_price'] );
				$max_reg_price = end( $prices['regular_price'] );

				if ( $min_price !== $max_price ) {
		?>

		<div class="md:mb-0.5">
			<div class="flex items-center">
				<div class="text-neutral-300 text-small">Mulai dari</div>
			</div>
		</div>

		<?php
				} elseif ( $product->is_on_sale() && $min_reg_price === $max_reg_price ) {
		?>

		<div class="md:mb-0.5">
			<div class="flex items-center">
				<div class="text-neutral-300 text-small line-through"><?php echo dots_price( $max_reg_price ); ?></div>
				<span class="badge bagde-discount bg-accent-red bg-opacity-30 rounded-6 text-accent-red text-xs font-bold leading-6 uppercase whitespace-nowrap inline-block px-2 mx-2"><?php echo dots_presentage_ribbon( $product ); ?></span>
				<div class="text-neutral-300 body-text-3">Kamu hemat <?php echo dots_price( $max_reg_price - $min_price ) ?></div>
			</div>
		</div>

		<?php
				}
			}
		?>

		<div class="heading-4 text-primary-1 mr-2 md:mr-0"><?php echo dots_price( $product->get_price() ); ?></div>

	</div>
