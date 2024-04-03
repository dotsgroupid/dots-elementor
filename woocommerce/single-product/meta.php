<?php

/**
 * Single Product Meta.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

?>

	<div class="px-4 md:px-0">
		<div class="border-t-1 border-dashed border-neutral-700 flex items-center pt-2.5 md:border-b-1 md:pb-2.5 md:my-2.5">

			<?php
				do_action( 'woocommerce_product_meta_start' );

				if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) :
			?>

			<span class="text-neutral-300 text-sm">
				<?php esc_html_e( 'SKU:', 'dots-elementor' ); ?>
				<span class="font-bold">
					<?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'dots-elementor' ); ?>
				</span>
			</span>

			<div class="dot-sparated mx-2"></div>

			<?php endif; ?>

			<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="text-neutral-300 text-sm">' . _n( 'Kategori:', 'Kategori:', count( $product->get_category_ids() ), 'dots-elementor' ) . ' ', '</span>' ); ?>

			<div class="dot-sparated mx-2"></div>

			<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="text-neutral-300 text-sm">' . _n( 'Tag:', 'Tag:', count( $product->get_tag_ids() ), 'dots-elementor' ) . ' ', '</span>' ); ?>

			<?php do_action( 'woocommerce_product_meta_end' ); ?>

		</div>
	</div>
