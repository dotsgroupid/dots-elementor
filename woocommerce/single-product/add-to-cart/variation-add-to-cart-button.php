<?php

/**
 * Single variation cart button.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

?>

	<div class="bg-neutral-900 border-t-1 border-neutral-800 pt-4 pb-8 px-4 md:bg-transparent md:border-t-0 md:pt-0 md:pb-6 md:px-0">

		<?php
			woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
				)
			);
		?>

		<div class="flex mt-2 md:mt-6">
			<button id="btn-add-to-cart" class="btn btn-ghost bg-transparent border-1 border-solid border-primary-1 rounded text-primary-1 text-sm font-bold relative w-full mr-2 overflow-hidden md:mr-4">+ Keranjang</button>
			<button id="btn-buy-now" class="btn btn-filled bg-primary-1 rounded text-neutral-1000 text-sm font-bold relative w-full overflow-hidden">Beli Sekarang</button>
		</div>

		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />

	</div>
