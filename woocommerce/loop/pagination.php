<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

?>

	<nav class="dots-pagination">

		<?php
			echo paginate_links(
				apply_filters(
					'woocommerce_pagination_args',
					array(
						'base'      => $base,
						'format'    => $format,
						'add_args'  => false,
						'current'   => max( 1, $current ),
						'total'     => $total,
						'prev_text' => is_rtl() ? '<span class="di-chevron-right"></span>' : '<span class="di-chevron-left"></span>',
						'next_text' => is_rtl() ? '<span class="di-chevron-left"></span>' : '<span class="di-chevron-right"></span>',
						'type'      => 'list',
						'end_size'  => 3,
						'mid_size'  => 3,
					)
				)
			);
		?>

	</nav>
