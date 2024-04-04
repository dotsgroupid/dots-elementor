<?php

/**
 * Description tab.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Deskripsi', 'dots-elementor' ) );

?>

	<h2><?php echo esc_html( $heading ); ?></h2>

	<section>
		<article class="pdp-description break-words"><?php the_content(); ?></article>
	</section>

