<?php

/**
 * Product Brands Widget.
 *
 * @package DOTS. Elementor
 * @since 1.0
*/

// Product brands widget class.
class Dots_Widget_Product_Brands extends WC_Widget {
	// Constructor.
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_product_brands';
		$this->widget_description = __( 'An list of product brands.', 'dots-elementor' );
		$this->widget_id          = 'woocommerce_product_brands';
		$this->widget_name        = __( 'DEA - Product Brands', 'dots-elementor' );
		$this->settings           = array(
			'title'              => array(
				'type'  => 'text',
				'std'   => __( 'Brands', 'dots-elementor' ),
				'label' => __( 'Title', 'dots-elementor' ),
			),
			'orderby'            => array(
				'type'    => 'select',
				'std'     => 'name',
				'label'   => __( 'Order by', 'dots-elementor' ),
				'options' => array(
					'order' => __( 'Brand order', 'dots-elementor' ),
					'name'  => __( 'Name', 'dots-elementor' ),
				),
			),
			'count'              => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show product counts', 'dots-elementor' ),
			),
			'hide_empty'         => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide empty categories', 'dots-elementor' ),
			),
		);

		parent::__construct();
	}

	// Get current page URL for layered nav items.
	protected function get_page_base_url( $taxonomy ) {
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} else {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		}

		if ( isset( $_GET['min_price'] ) ) {
			$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
		}

		if ( isset( $_GET['max_price'] ) ) {
			$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
		}

		if ( isset( $_GET['orderby'] ) ) {
			$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
		}

		if ( get_search_query() ) {
			$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
		}

		if ( isset( $_GET['post_type'] ) ) {
			$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
		}

		if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
			foreach ( $_chosen_attributes as $name => $data ) {
				if ( $name === $taxonomy ) {
					continue;
				}
				$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
				if ( ! empty( $data['terms'] ) ) {
					$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
				}
				if ( 'or' == $data['query_type'] ) {
					$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
				}
			}
		}

		return $link;
	}

	// Return the currently viewed term slug.
	protected function get_current_term_slug() {
		return absint( is_tax() ? get_queried_object()->slug : 0 );
	}

	// Output widget.
	public function widget( $args, $instance ) {
		$orderby    = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
		$count      = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
		$hide_empty = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];

		$list_args  = array(
			'hide_empty' => $hide_empty,
			'show_count' => $count,
			'taxonomy'   => 'product_brand',
		);
		$list_args['menu_order'] = false;

		if ( 'order' === $orderby ) {
			$list_args['orderby']  = 'meta_value_num';
			$list_args['meta_key'] = 'order';
		}

		$brands = get_terms( array(
			'taxonomy'   => 'product_brand',
			'hide_empty' => $list_args['hide_empty'],
		) );

		ob_start();

		$this->widget_start( $args, $instance );

		?>

		<div class="text-neutral-100 px-4 mt-3 mb-2">
			<div>
				<fieldset class="text-input border-none relative p-0 search-checkbox mb-2">
					<div class="wrap no-label border-1 border-solid rounded leading-0 flex gap-2 items-center h-13 p-4 pl-2 pr-4">
						<div class="option-wrapper">
							<span class="di-search text-neutral-300 text-xl"></span>
						</div>
						<div class="w-full"><input type="text" class="bg-transparent border-none text-neutral-100 placeholder-neutral-500 text-sm tracking-wide relative w-full h-10 pt-6 pb-2" name="" placeholder="Cari brand" value=""></div>
					</div>
					<div class="flex gap-1 items-start justify-between"></div>
				</fieldset>
				<section id="checkbox-item" class="h-36 overflow-y-auto overflow-x-hidden scrollbar-neutral-700">
					<div>
						<?php $found = $this->layered_nav_list( $brands, 'product_brand' ); ?>
					</div>
				</section>
			</div>
		</div>

		<?php

		$this->widget_end( $args );

		if ( ! $found ) {
			ob_end_clean();
		} else {
			echo ob_get_clean();
		}
	}

	// Show list based layered nav.
	protected function layered_nav_list( $terms, $taxonomy ) {
		echo '<ul>';

		$term_counts = dots_get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), 'product_brand', 'or' );
		$found       = false;

		foreach ( $terms as $term ) {
			$count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 1;
			$current_values = ! empty( $_GET[ $taxonomy ] ) ? explode( ',', wc_clean( $_GET[ $taxonomy ] ) ) : array();
			$option_is_set  = in_array( $term->slug, $current_values );

			if ( 0 < $count ) {
				$found = true;
			} elseif ( 0 === $count && ! $option_is_set ) {
				continue;
			}

			$filter_name    = sanitize_title( $taxonomy );
			$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
			$current_filter = array_map( 'sanitize_title', $current_filter );

			if ( ! in_array( $term->slug, $current_filter ) ) {
				$current_filter[] = $term->slug;
			}

			$link = $this->get_page_base_url( $taxonomy );

			foreach ( $current_filter as $key => $value ) {
				if ( $value === $this->get_current_term_slug() ) {
					unset( $current_filter[ $key ] );
				}

				if ( $option_is_set && $value === $term->slug ) {
					unset( $current_filter[ $key ] );
				}

			}

			if ( ! empty( $current_filter ) ) {
				$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );
			}

			if ( $count > 0 || $option_is_set ) {
				$link      = esc_url( apply_filters( 'woocommerce_layered_nav_link', $link, $term, $taxonomy ) );
				$term_html = '<a data-title="' . esc_html( $term->name ) . '" href="' . $link . '">' . esc_html( $term->name ) . '</a>';
			} else {
				$link      = false;
				$term_html = '<span data-title="' . esc_html( $term->name ) . '">' . esc_html( $term->name ) . '</span>';
			}

			echo '<li class="filter-list-checkbox ' . ( $option_is_set ? 'checked' : '' ) . '">' . $term_html . '</li>';
		}

		echo '</ul>';

		return $found;
	}
}
