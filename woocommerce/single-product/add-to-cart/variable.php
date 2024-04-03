<?php

/**
 * Variable product add to cart
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' );

?>

	<form action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" class="variations_form cart" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; ?>">

		<?php
			do_action( 'woocommerce_before_variations_form' );

			if ( empty( $available_variations ) && false !== $available_variations ) :
		?>

			<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>

		<?php else : ?>

			<div class="variations">
				<div>

					<?php
						foreach ( $attributes as $attribute_name => $options ) {
							if ($attribute_name == 'pa_warna') {
					?>
						<div class="text-neutral-100 body-text-3 pt-2 px-4 mt-4 mb-3 md:px-0">Warna:</div>
						<div class="flex w-full pb-2 overflow-x-auto overflow-y-hidden scroll-container-hide-scrollbar">
							<div class="flex gap-2 mx-4 md:flex-wrap md:mx-0">
								<?php
									wc_dropdown_variation_attribute_options(
										array(
											'options'   => $options,
											'attribute' => $attribute_name,
											'product'   => $product,
										)
									);
								?>
							</div>
						</div>
					<?php
							}
						}
					?>

				</div>
			</div>

			<?php do_action( 'woocommerce_after_variations_table' ); ?>

			<div class="border-b-1 border-neutral-900 my-4">

				<?php
					do_action( 'woocommerce_before_single_variation' );

					do_action( 'woocommerce_single_variation' );

					do_action( 'woocommerce_after_single_variation' );
				?>

			</div>

		<?php
			endif;

			do_action( 'woocommerce_after_variations_form' );
		?>

	</form>

<?php

do_action( 'woocommerce_after_add_to_cart_form' );
