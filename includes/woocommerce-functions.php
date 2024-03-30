<?php

/**
 * Custom functions for WooCommerce Plugin.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Override Functions.
remove_action( 'woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open', 10);
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close', 5);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10);
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// Calculates discount percentages.
function dots_presentage_ribbon( $product ) {
	if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
		$regular_price = $product->get_regular_price();
		$sale_price = $product->get_sale_price();

		$ribbon_content = round( ( ( floatval( $regular_price ) - floatval( $sale_price ) ) / floatval( $regular_price ) ) * 100 );
	} elseif ( $product->is_type( 'variable' ) ) {
		$available_variations = $product->get_available_variations();
		$maximumper = 0;

		for ( $i = 0; $i < count( $available_variations ); ++ $i ) {
			$variation_id = $available_variations[ $i ]['variation_id'];
			$variable_product = new WC_Product_Variation( $variation_id );

			if ( ! $variable_product->is_on_sale() ) {
				continue;
			}

			$regular_price = $variable_product->get_regular_price();
			$sale_price = $variable_product->get_sale_price();
			$percentage = round( ( ( floatval( $regular_price ) - floatval( $sale_price ) ) / floatval( $regular_price ) ) * 100 );

			if ( $percentage > $maximumper ) {
				$maximumper = $percentage;
			}
		}

		$ribbon_content = sprintf( __( '%s', 'dots-elementor' ), $maximumper );
	} else {
		$ribbon_content = __( 'Sale!', 'dots-elementor' );

		return $ribbon_content;
	}

	return str_replace( '{value}', $ribbon_content, '-{value}%' );
}

// Override Variable Price HTML Outputs.
function dots_variable_price_html( $price, $product ){
	global $woocommerce_loop;

	if ( ( is_product() && isset($woocommerce_loop['name']) && ! empty($woocommerce_loop['name']) ) || ! is_product() ) {
		if ( $product->is_on_sale() ) {
			$regular_price_min = $product->get_variation_regular_price( 'min', true );
			$active_price_min = $product->get_variation_price( 'min', true );

			$active_price_ins_html = sprintf( '<ins>%s</ins>', wc_price( $active_price_min ) );
			$regular_price_del_html = sprintf( '<del>%s</del>', wc_price( $regular_price_min ) );

			$price = sprintf( '%s %s', $active_price_ins_html, $regular_price_del_html );
		} else {
			$active_price_min = $product->get_variation_price( 'min', true );
			$active_price_ins_html = sprintf( '<ins>%s</ins>', wc_price( $active_price_min ) );

			$price = sprintf( '%s', $active_price_ins_html );
		}
	}

	return $price;
}
add_filter( 'woocommerce_variable_price_html', 'dots_variable_price_html', 100, 2 );
