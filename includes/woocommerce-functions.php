<?php

/**
 * Custom functions for WooCommerce Plugin.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Override Functions.
remove_action( 'woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );

// Add Calculates discount percentages.
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

// Override Format the price with a currency symbol.
function dots_price( $price, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'ex_tax_label'       => false,
			'currency'           => '',
			'decimal_separator'  => wc_get_price_decimal_separator(),
			'thousand_separator' => wc_get_price_thousand_separator(),
			'decimals'           => wc_get_price_decimals(),
			'price_format'       => get_woocommerce_price_format(),
		)
	);

	$original_price    = $price;
	$price             = (float) $price;
	$unformatted_price = $price;
	$negative          = $price < 0;


	$price = apply_filters( 'raw_woocommerce_price', $negative ? $price * -1 : $price, $original_price );
	$price = apply_filters( 'formatted_woocommerce_price', number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] ), $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'], $original_price );

	if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $args['decimals'] > 0 ) {
		$price = wc_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'], get_woocommerce_currency_symbol( $args['currency'] ), $price );
	$return          = $formatted_price;

	if ( $args['ex_tax_label'] && wc_tax_enabled() ) {
		$return .= WC()->countries->ex_tax_or_vat();
	}

	return apply_filters( 'woocommerce_price', $return, $price, $args, $unformatted_price, $original_price );
}

// Override Format a sale price for display.
function dots_format_sale_price( $regular_price, $sale_price ) {
	$price = '<div class="text-primary-1 text-sm font-black leading-6">' . $sale_price . '</div> <div class="text-neutral-600 text-xxs font-medium line-through" aria-hidden="true">' . $regular_price . '</div> ';
	return apply_filters( 'woocommerce_format_sale_price', $price, $regular_price, $sale_price );
}

// Override Format a price range for display.
function dots_format_min_prace_range( $from ) {
	$price = is_numeric( $from ) ? dots_price( $from ) : $from;
	return apply_filters( 'woocommerce_format_min_prace_range', $price, $from );
}

// Override Returns the price in html format.
function dots_price_html( $product ) {
	if ( $product->is_type( 'simple' ) ) {
		if ( '' === $product->get_price() ) {
			$price = apply_filters( 'woocommerce_empty_price_html', '', $product );
		} elseif ( $product->is_on_sale() ) {
			$price = dots_format_sale_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ), wc_get_price_to_display( $product ) ) . $product->get_price_suffix();
		} else {
			$price = '<div class="text-primary-1 text-sm font-black leading-6">' . dots_price( wc_get_price_to_display( $product ) ) . $product->get_price_suffix() . '</div>';
		}
	} elseif ( $product->is_type( 'external' ) ) {
		if ( $product->is_on_sale() ) {
			$price = '<div class="text-neutral-600 text-xxs font-medium" aria-hidden="true">Mulai dari</div> <div class="text-primary-1 text-sm font-black leading-6">' . dots_price( $product->get_sale_price() ) . '</div>';
		} else {
			$price = '<div class="text-neutral-600 text-xxs font-medium" aria-hidden="true">Mulai dari</div> <div class="text-primary-1 text-sm font-black leading-6">' . dots_price( $product->get_regular_price() ) . '</div>';
		}
	} elseif ( $product->is_type( 'variable' ) ) {
		$prices = $product->get_variation_prices( true );

		if ( empty( $prices['price'] ) ) {
			$price = apply_filters( 'woocommerce_variable_empty_price_html', '', $product );
		} else {
			$min_price     = current( $prices['price'] );
			$max_price     = end( $prices['price'] );
			$min_reg_price = current( $prices['regular_price'] );
			$max_reg_price = end( $prices['regular_price'] );

			if ( $min_price !== $max_price ) {
				$price = '<div class="text-neutral-600 text-xxs font-medium" aria-hidden="true">Mulai dari</div> <div class="text-primary-1 text-sm font-black leading-6">' . dots_format_min_prace_range( $min_price ) . '</div>';
			} elseif ( $product->is_on_sale() && $min_reg_price === $max_reg_price ) {
				$price = dots_format_sale_price( dots_price( $max_reg_price ), dots_price( $min_price ) );
			} else {
				$price = '<div class="text-primary-1 text-sm font-black leading-6">' . dots_price( $min_price ) . '</div>';
			}

			$price = apply_filters( 'woocommerce_variable_price_html', $price . $product->get_price_suffix(), $product );
		}
 	} else {
		$price = '';
	}

	return apply_filters( 'woocommerce_get_price_html', $price, $product );
}

// Override Product Loop Link.
function dots_template_loop_product_link_open() {
	global $product;

	if ( $product->is_type( 'external' ) ) {
		$link = apply_filters( 'woocommerce_loop_product_link', $product->get_product_url(), $product );
	} else {
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
	}

	echo '<div class="bg-neutral-900 rounded-2 relative h-full"><a href="' . esc_url( $link ) . '">';
}
add_filter( 'woocommerce_before_shop_loop_item', 'dots_template_loop_product_link_open', 100, 2 );

function dots_template_loop_product_link_close() {
	echo '</a></div>';
}
add_filter( 'woocommerce_after_shop_loop_item', 'dots_template_loop_product_link_close', 100, 2 );

// Override Product Loop Title.
function dots_template_loop_product_title() {
	echo '<p class="product-name text-neutral-0 text-sm font-normal leading-6 h-12 mb-1">' . get_the_title() . '</p>';
}
add_filter( 'woocommerce_shop_loop_item_title', 'dots_template_loop_product_title', 100, 2 );

// Override Product Tabs.
function dots_product_tabs( $tabs ) {
	$tabs[ 'description' ][ 'title' ] = 'Deskripsi';
	unset( $tabs['additional_information'] );
	unset( $tabs['reviews'] );

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'dots_product_tabs', 9999 );
