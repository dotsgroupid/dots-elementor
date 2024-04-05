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
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
				)
			);
		?>

		<div class="flex mt-2 md:mt-6">
			<a href="javascript:void(0)" class="btn btn-filled bg-primary-1 rounded text-neutral-1000 text-sm font-bold text-center relative w-full overflow-hidden">Beli Sekarang</a>
		</div>

		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />

	</div>
