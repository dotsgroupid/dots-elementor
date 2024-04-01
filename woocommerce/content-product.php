<?php
/**
 * The template for displaying product content within loops.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>

	<div class="product w-1-2 p-1 sm:w-1-3 md:w-1-4 md:p-2 lg:w-1-5">

		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<div class="product-card-container cursor-pointer bg-neutral-900 relative rounded-2">
			<div class="product-card relative">
				<div class="relative pt-6 px-2 md:px-4">

					<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

				</div>
				<div class="py-2 px-4 pb-4 mt-4">

					<?php
						do_action( 'woocommerce_shop_loop_item_title' );

						do_action( 'woocommerce_after_shop_loop_item_title' );
					?>

				</div>
			</div>
		</div>

		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

	</div>
