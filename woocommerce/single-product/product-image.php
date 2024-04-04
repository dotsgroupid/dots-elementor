<?php

/**
 * Single Product Image.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

?>

	<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
		<div class="woocommerce-product-gallery__wrapper">

			<?php
				if ( $post_thumbnail_id ) {
					$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
				} else {
					$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
					$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'dots-elementor' ) );
					$html .= '</div>';
				}

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

				do_action( 'woocommerce_product_thumbnails' );
			?>

		</div>

		<div class="product-share hidden md:block">
			<div class="flex flex-col items-center px-4 mt-4 md:flex-row md:px-0">
				<div class="text-neutral-300 body-text-3 font-bold tracking-wide mr-3">Bagikan</div>
				<div class="flex w-full md:w-auto">
					<a href="javascript:void(0)" class="border-b-1 border-neutral-700 text-xl md:border-0 md:mr-2.5" target="_blank" rel="noreferrer noopener">
						<div class="flex items-center py-3.5 md:py-0">
							<span class="di-facebook text-neutral-100"></span>
							<span class="text-neutral-100 body-text-2 leading-6 capitalize ml-4 md:hidden">Facebook</span>
						</div>
					</a>
					<a href="javascript:void(0)" class="border-b-1 border-neutral-700 text-xl md:border-0 md:mr-2.5" target="_blank" rel="noreferrer noopener">
						<div class="flex items-center py-3.5 md:py-0">
							<span class="di-twitter text-neutral-100"></span>
							<span class="text-neutral-100 body-text-2 leading-6 capitalize ml-4 md:hidden">Twitter</span>
						</div>
					</a>
					<a href="javascript:void(0)" class="border-b-1 border-neutral-700 text-xl md:border-0 md:mr-2.5" target="_blank" rel="noreferrer noopener">
						<div class="flex items-center py-3.5 md:py-0">
							<span class="di-whatsapp text-neutral-100"></span>
							<span class="text-neutral-100 body-text-2 leading-6 capitalize ml-4 md:hidden">WhatsApp</span>
						</div>
					</a>
					<a href="javascript:void(0)" class="border-neutral-700 text-xl md:border-0 md:mr-2.5">
						<div class="flex items-center py-3.5 md:py-0">
							<span class="di-share text-neutral-100"></span>
							<span class="text-neutral-100 body-text-2 leading-6  capitalize ml-4 md:hidden">Salin Link</span>
						</div>
					</a>
				</div>
			</div>
		</div>

	</div>
