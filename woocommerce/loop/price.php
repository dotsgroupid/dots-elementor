<?php

/**
 * Loop Price.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

if ( $price_html = dots_price_html( $product ) ) :
	echo $price_html;
endif;
