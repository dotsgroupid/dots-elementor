<?php

/**
 * Custom functions for Widgets.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Include widget classes.
require_once DOTS_THEME_DIR . '/includes/widgets/widget-product-categories.php';
require_once DOTS_THEME_DIR . '/includes/widgets/widget-product-brands.php';

// Register Widgets.
function dots_register_widgets() {
	register_widget( 'Dots_Widget_Product_Categories' );
	register_widget( 'Dots_Widget_Product_Brands' );
}
add_action( 'widgets_init', 'dots_register_widgets' );

function dots_get_filtered_term_product_counts( $term_ids, $taxonomy = false, $query_type = false ) {
	global $wpdb;

	if ( ! class_exists( 'WC_Query' ) ) {
		return false;
	}

	$tax_query  = WC_Query::get_main_tax_query();
	$meta_query = WC_Query::get_main_meta_query();

	if ( 'or' === $query_type ) {
		foreach ( $tax_query as $key => $query ) {
			if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
				unset( $tax_query[ $key ] );
			}
		}
	}

	if ( 'product_brand' === $taxonomy ) {
		foreach ( $tax_query as $key => $query ) {
			if ( is_array( $query ) ) {
				if ( $query['taxonomy'] === 'product_brand' ) {
					unset( $tax_query[ $key ] );

					if ( preg_match( '/pa_/', $query['taxonomy'] ) ) {
						unset( $tax_query[ $key ] );
					}
				}
			}
		}
	}

	$meta_query     = new WP_Meta_Query( $meta_query );
	$tax_query      = new WP_Tax_Query( $tax_query );
	$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
	$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

	$query           = array();
	$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
	$query['from']   = "FROM {$wpdb->posts}";
	$query['join']   = "
		INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
		INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
		INNER JOIN {$wpdb->terms} AS terms USING( term_id )
		" . $tax_query_sql['join'] . $meta_query_sql['join'];

	$query['where'] = "
		WHERE {$wpdb->posts}.post_type IN ( 'product' )
		AND {$wpdb->posts}.post_status = 'publish'
		" . $tax_query_sql['where'] . $meta_query_sql['where'] . "
		AND terms.term_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ")
	";

	if ( $search = WC_Query::get_main_search_query_sql() ) {
		$query['where'] .= ' AND ' . $search;
	}

	$query['group_by'] = "GROUP BY terms.term_id";
	$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
	$query             = implode( ' ', $query );

	$query_hash    = md5( $query );
	$cache = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
	if ( true === $cache ) {
		$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
	} else {
		$cached_counts = array();
	}

	if ( ! isset( $cached_counts[ $query_hash ] ) ) {
		$results                      = $wpdb->get_results( $query, ARRAY_A );
		$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
		$cached_counts[ $query_hash ] = $counts;
		set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
	}

	return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
}
