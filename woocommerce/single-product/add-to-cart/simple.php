<?php

/**
 * Simple product add to cart.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product );

if ( $product->is_in_stock() ) :

	do_action( 'woocommerce_before_add_to_cart_form' );

?>

	<form action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" class="cart" enctype='multipart/form-data'>
		<div class="border-b-1 border-neutral-900 my-4">
			<div class="bg-neutral-900 border-t-1 border-neutral-800 pt-4 pb-8 px-4 md:bg-transparent md:border-t-0 md:pt-0 md:pb-6 md:px-0">

				<?php
					do_action( 'woocommerce_before_add_to_cart_button' );

					do_action( 'woocommerce_before_add_to_cart_quantity' );

					woocommerce_quantity_input(
						array(
							'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
						)
					);

					do_action( 'woocommerce_after_add_to_cart_quantity' );
				?>

				<div class="flex mt-2 md:mt-6">
					<button id="btn-add-to-cart" class="btn btn-ghost bg-transparent border-1 border-solid border-primary-1 rounded text-primary-1 text-sm font-bold relative w-full mr-2 overflow-hidden md:mr-4">+ Keranjang</button>
					<button id="btn-buy-now" class="btn btn-filled bg-primary-1 rounded text-neutral-1000 text-sm font-bold relative w-full overflow-hidden">Beli Sekarang</button>
				</div>

				<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

			</div>
		</div>
	</form>

<?php

	do_action( 'woocommerce_after_add_to_cart_form' );

endif;
