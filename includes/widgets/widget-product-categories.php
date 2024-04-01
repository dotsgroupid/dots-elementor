<?php
/**
 * Product Categories Widget.
 *
 * @package DOTS. Elementor
 * @since 1.0
*/

// Product categories widget class.
class Dots_Widget_Product_Categories extends WC_Widget {
	// Category ancestors.
	public $cat_ancestors;

	// Current Category.
	public $current_cat;

	// Constructor.
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_product_categories';
		$this->widget_description = __( 'An accordion list of product categories and subcategories.', 'woocommerce' );
		$this->widget_id          = 'woocommerce_product_categories--accordion';
		$this->widget_name        = __( 'DEA - Product Categories', 'woocommerce' );
		$this->settings           = array(
			'title'              => array(
				'type'  => 'text',
				'std'   => __( 'Categories', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'orderby'            => array(
				'type'    => 'select',
				'std'     => 'name',
				'label'   => __( 'Order by', 'woocommerce' ),
				'options' => array(
					'order' => __( 'Category order', 'woocommerce' ),
					'name'  => __( 'Name', 'woocommerce' ),
				),
			),
			'count'              => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show product counts', 'woocommerce' ),
			),
			'hide_empty'         => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide empty categories', 'woocommerce' ),
			),
		);

		parent::__construct();
	}

	// Output widget.
	public function widget( $args, $instance ) {
		global $wp_query, $post;

		$orderby            = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
		$count              = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
		$hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];

		$dropdown_args      = array(
			'hide_empty' => $hide_empty,
		);
		$list_args          = array(
			'hide_empty'   => $hide_empty,
			'show_count'   => $count,
			'taxonomy'     => 'product_cat',
		);
		$list_args['menu_order'] = false;

		if ( 'order' === $orderby ) {
			$list_args['orderby']      = 'meta_value_num';
			$dropdown_args['orderby']  = 'meta_value_num';
			$list_args['meta_key']     = 'order';
			$dropdown_args['meta_key'] = 'order';
		}

		$this->current_cat   = false;
		$this->cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {
			$this->current_cat   = $wp_query->queried_object;
			$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
		} elseif ( is_singular( 'product' ) ) {
			$terms = wc_get_product_terms(
				$post->ID,
				'product_cat',
				apply_filters(
					'woocommerce_product_categories_widget_product_terms_args',
					array(
						'orderby' => 'parent',
						'order'   => 'DESC',
					)
				)
			);

			if ( $terms ) {
				$main_term           = apply_filters( 'woocommerce_product_categories_widget_main_term', $terms[0], $terms );
				$this->current_cat   = $main_term;
				$this->cat_ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
			}
		}

		$this->widget_start( $args, $instance );

		include_once WC()->plugin_path() . '/includes/walkers/class-wc-product-cat-list-walker.php';

		$list_args['walker']                     = new WC_Product_Cat_List_Walker();
		$list_args['title_li']                   = '';
		$list_args['pad_counts']                 = 1;
		$list_args['show_option_none']           = __( 'No product categories exist.', 'woocommerce' );
		$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
		$list_args['current_category_ancestors'] = $this->cat_ancestors;

		$categories = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => $list_args['hide_empty'],
			'parent' => 0,
			'exclude' => array(15),
		) );
?>

		<div id="filter-navigation" class="text-neutral-300 px-4 mt-3 mb-2">
			<ul class="filter-nav-list">
				<?php
					foreach( $categories as $category ) {
						$current_term = get_term( $this->current_cat );
						$term_slug = get_term_link( $category->term_id, 'product_cat' );
						$term_current_cursor = ' cursor-pointer';
						$term_current_icon = '';
						$term_current_class = '';

						if ( isset( $current_term->term_id ) ) {
							if ( ( $category->term_id == $this->current_cat->term_id ) ) {
								$term_current_cursor = ' cursor-default';
								$term_current_icon = '<div class="nav-selector"></div>';
								$term_current_class = 'class="text-primary-1"';
							}
						}
				?>

				<li class="text-xs<?php echo $term_current_cursor; ?>">
					<a href="<?php echo $term_slug; ?>" id="filter-nav-item" class="py-1 pr-2 flex items-center">
						<?php echo $term_current_icon; ?>
						<div id="content-items" class="flex items-center ml-2">
							<figure class="h-auto mr-2">
								<img src="https://assets.jamtangan.com/icon-category/all.png">
							</figure>
							<p <?php echo $term_current_class; ?>><?php echo $category->name; ?></p>
						</div>
					</a>
				</li>

				<?php
					}
				?>
			</ul>
		</div>

<?php
		$this->widget_end( $args );
	}
}
