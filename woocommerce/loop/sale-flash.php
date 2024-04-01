<?php

/**
 * Product loop sale flash.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $post, $product;

if ( $product->is_on_sale() ) :

?>

	<div class="ribbon clip bg-accent-red rounded-tr-2 absolute -top-1 right-0 py-3 px-2 z-10">
		<span class="tail bg-semantic-error-heavy absolute w-1 h-1 top-0 -left-1"></span>
		<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="text-neutral-0 text-xs font-bold leading-normal">' . dots_presentage_ribbon( $product ) . '</span>', $post, $product ); ?>
	</div>

<?php

endif;
