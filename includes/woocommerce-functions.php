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
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );

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

// Override Product Loop Link.
function dots_template_loop_product_link_open() {
	global $product;

	$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

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

// Add Custom Product Attribute Locations.
function dots_product_attribute_location() {
	global $product;

	$attributes = $product->get_variation_attributes();

	if ( ! empty( $attributes ) ) {
	?>

		<div class="bg-neutral-900 mt-4 mb-6 md:bg-transparent md:mb-0">
			<div class="flex justify-between items-center pt-4 px-4 md:p-0">
				<div class="text-primary-1 font-black">Stok Toko Offline</div>
			</div>
			<div class="text-neutral-200 body-text-2 px-4 mt-2 mb-4 md:text-sm md:px-0">Selain secara online, kamu juga bisa beli dari stok offline di toko kami:</div>
			<div class="scroll-container-hide-scrollbar pl-4 pb-4 overflow-y-scroll md:pl-0 md:pb-4 md:overflow-visible">

		<?php
			foreach ( $attributes as $attribute_name => $options ) {
				if ( $attribute_name == 'pa_kota' ) {
					$terms = wc_get_product_terms(
						$product->get_id(),
						'pa_kota',
						array(
							'fields' => 'all',
						),
					);

					if ( count( $terms ) > 1 ) {
						echo '<div class="slick-slider offline-slider inline-flex md:block">';
					}

					foreach ( $terms as $term ) {
						if ( count( $terms ) > 1 ) {
					?>
						<div>
							<a href="<?php echo esc_url( $term->description ); ?>" class="store-item-container store-item cursor-pointer bg-neutral-900 border-1 border-neutral-800 rounded-2 py-3 px-4 mr-2 md:border-0 md:mr-0" target="_blank" rel="noreferrer noopener">
								<div class="store-name text-neutral-100 text-sm font-black tracking-wide leading-5"><?php echo $term->name; ?></div>
								<div class="flex items-center mt-2">
									<span class="badge bg-semantic-success-heavy rounded-6 text-neutral-100 text-xs font-bold leading-4 normal-case whitespace-nowrap inline-block py-0.5 px-2">Stok Tersedia</span>
								</div>
							</a>
						</div>
					<?php
						} else {
					?>
						<a href="<?php echo esc_url( $term->description ); ?>" class="store-item-container cursor-pointer bg-neutral-900 border-1 border-neutral-800 rounded-2 flex items-center justify-between py-3 px-4 mb-2 mr-4 md:border-0 md:mr-0" target="_blank" rel="noreferrer noopener">
							<div class="text-neutral-100 text-sm font-black tracking-wide leading-5 w-8-12"><?php echo $term->name; ?></div>
							<div class="block">
								<span class="badge bg-semantic-success-heavy rounded-6 text-neutral-100 text-xs font-bold normal-case leading-4 whitespace-nowrap inline-block py-0.5 px-2">Stok tersedia</span>
							</div>
						</a>
					<?php
						}
					}

					if ( count( $terms ) > 1 ) {
						echo '</div>';
						echo '<script>
							jQuery( function ( $ ) {
								$( ".slick-slider" ).slick({
									infinite: false,
									slidesToShow: 2,
									slidesToScroll: 2,
								});
							} );
						</script>';
					}

				}
			}
		?>

			</div>
		</div>

	<?php
	}
}
add_filter( 'woocommerce_after_add_to_cart_form', 'dots_product_attribute_location' );

// Override Product Tabs.
function dots_product_tabs( $tabs ) {
	$tabs[ 'description' ][ 'title' ] = 'Deskripsi';
	unset( $tabs['additional_information'] );
	unset( $tabs['reviews'] );

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'dots_product_tabs', 9999 );
