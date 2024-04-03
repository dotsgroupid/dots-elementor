<?php

/**
 * Loop Price.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

if ( $price_html = $product->get_price_html() ) :

	echo $price_html;

endif;
