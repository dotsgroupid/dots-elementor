<?php

/**
 * The Template for displaying product archives,
 * including the main shop page which is a post type archive.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );

?>

	<div class="flex lg:mt-8">
		<div class="hidden mr-4 lg:block">

			<?php do_action( 'woocommerce_sidebar' ); ?>

		</div>
		<div class="flex-basis-full">

			<?php
				if ( woocommerce_product_loop() ) {
					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();

							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}

					woocommerce_product_loop_end();

					do_action( 'woocommerce_after_shop_loop' );
				} else {
					do_action( 'woocommerce_no_products_found' );
				}
			?>

		</div>
	</div>

<?php

do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
