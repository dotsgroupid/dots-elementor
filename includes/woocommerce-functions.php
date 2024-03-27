<?php

/**
 * Custom functions for WooCommerce Plugin.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Register Product Brand taxonomies.
function dots_register_product_brand() {
	$shop_page_id = wc_get_page_id( 'shop' );

	register_taxonomy(
		'product_brand',
		array( 'product' ),
		apply_filters(
			'dots_taxonomy_args_product_brand',
			array(
				'hierarchical'          => false,
				'update_count_callback' => '_wc_term_recount',
				'label'                 => __( 'Brands', 'dots-elementor'),
				'labels'                => array(
					'name'                  => __( 'Product brands', 'dots-elementor' ),
					'singular_name'         => __( 'Brand', 'dots-elementor' ),
					'menu_name'             => _x( 'Brands', 'Admin menu name', 'dots-elementor' ),
					'search_items'          => __( 'Search brands', 'dots-elementor' ),
					'all_items'             => __( 'All brands', 'dots-elementor' ),
					'edit_item'             => __( 'Edit brand', 'dots-elementor' ),
					'update_item'           => __( 'Update brand', 'dots-elementor' ),
					'add_new_item'          => __( 'Add new brand', 'dots-elementor' ),
					'new_item_name'         => __( 'New brand name', 'dots-elementor' ),
					'not_found'             => __( 'No brands found', 'dots-elementor' ),
					'item_link'             => __( 'Product Brand Link', 'dots-elementor' ),
					'item_link_description' => __( 'A link to a product brand.', 'dots-elementor' ),
				),
				'show_in_rest'          => true,
				'show_ui'               => true,
				'query_var'             => true,
				'capabilities'          => array(
					'manage_terms' => 'manage_product_terms',
					'edit_terms'   => 'edit_product_terms',
					'delete_terms' => 'delete_product_terms',
					'assign_terms' => 'assign_product_terms',
				),
				'rewrite'               => array(
					'slug'         => get_page_uri( $shop_page_id ),
					'with_front'   => true,
					'hierarchical' => false,
				),
			),
		),
	);
	register_taxonomy_for_object_type( 'product_brand', 'product' );
}
add_action( 'init', 'dots_register_product_brand' );

// Change messages when a taxonomies is updated.
function dots_updated_term_messages( $messages ) {
	$messages[ 'product_brand' ] = array(
		0 => '',
		1 => __( 'Brand added.', 'dots-elementor' ),
		2 => __( 'Brand deleted.', 'dots-elementor' ),
		3 => __( 'Brand updated.', 'dots-elementor' ),
		4 => __( 'Brand not added.', 'dots-elementor' ),
		5 => __( 'Brand not updated.', 'dots-elementor' ),
		6 => __( 'Brands deleted.', 'dots-elementor' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'dots_updated_term_messages' );

// Enqueue styles and scripts.
function dots_admin_styles_scripts() {
	$screen    = get_current_screen();
	$screen_id = $screen ? $screen->id : '';

	wp_enqueue_style( 'dots-admin-style', get_parent_theme_file_uri('assets/css/admin.css'), [], '1.0' );

	if ( in_array( $screen_id, array( 'edit-product_brand' ) ) ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'dots_admin_styles_scripts' );

// Add product brand logo fields.
function dots_product_brand_add_fields() {
?>

	<div class="form-field term-logo-wrap">
		<label><?php esc_html_e( 'Logo', 'dots-elementor' ); ?></label>
		<div id="product_brand_logo" style="float: left; margin-right: 10px;">
			<img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" />
		</div>
		<div style="line-height: 60px;">
			<input type="hidden" id="product_brand_logo_id" name="product_brand_logo_id" />
			<button type="button" class="upload_logo_button button"><?php esc_html_e( 'Upload/Add logo', 'dots-elementor' ); ?></button>
			<button type="button" class="remove_logo_button button"><?php esc_html_e( 'Remove logo', 'dots-elementor' ); ?></button>
		</div>
		<script type="text/javascript">
			if ( ! jQuery( '#product_brand_logo_id' ).val() ) {
				jQuery( '.remove_logo_button' ).hide();
			}

			var file_frame;

			jQuery( document ).on( 'click', '.upload_logo_button', function( event ) {

				event.preventDefault();

				if ( file_frame ) {
					file_frame.open();

					return;
				}

				file_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e( 'Choose an logo', 'dots-elementor' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use logo', 'dots-elementor' ); ?>'
					},
					multiple: false,
				});

				file_frame.on( 'select', function() {
					var attachment = file_frame.state().get( 'selection' ).first().toJSON();
					var attachment_logo = attachment.sizes.logo || attachment.sizes.full;

					jQuery( '#product_brand_logo_id' ).val( attachment.id );
					jQuery( '#product_brand_logo' ).find( 'img' ).attr( 'src', attachment_logo.url );
					jQuery( '.remove_logo_button' ).show();
				});

				file_frame.open();
			});

			jQuery( document ).on( 'click', '.remove_logo_button', function() {
				jQuery( '#product_brand_logo' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
				jQuery( '#product_brand_logo_id' ).val( '' );
				jQuery( '.remove_logo_button' ).hide();

				return false;
			});

			jQuery( document ).ajaxComplete( function( event, request, options ) {
				if ( request && 4 === request.readyState && 200 === request.status &&
					options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

					var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
					if ( ! res || res.errors ) {
						return;
					}

					jQuery( '#product_brand_logo' ).find( 'img' ).attr( 'src', '<?php echo esc_js(wc_placeholder_img_src()); ?>' );
					jQuery( '#product_brand_logo_id' ).val( '' );
					jQuery( '.remove_logo_button' ).hide();

					return;
				}
			});
		</script>
		<div class="clear"></div>
	</div>

<?php
}
add_action( 'product_brand_add_form_fields', 'dots_product_brand_add_fields', 10, 2 );

// Edit product brand logo fields.
function dots_product_brand_edit_fields( $term ) {
	$logo_id = absint(get_term_meta( $term->term_id, 'logo_id', true ) );

	if ( $logo_id ) {
		$logo = wp_get_attachment_thumb_url( $logo_id );
	} else {
		$logo = wc_placeholder_img_src();
	}
	?>

	<tr class="form-field term-logo-wrap">
		<th scope="row" valign="top">
			<label><?php esc_html_e( 'Logo', 'dots-elementor' ); ?></label>
		</th>
		<td>
			<div id="product_brand_logo" style="float: left; margin-right: 10px;">
				<img src="<?php echo esc_url( $logo ); ?>" width="60px" height="60px" />
			</div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_brand_logo_id" name="product_brand_logo_id" value="<?php echo esc_attr( $logo_id ); ?>" />
				<button type="button" class="upload_logo_button button"><?php esc_html_e( 'Upload/Add logo', 'dots-elementor' ); ?></button>
				<button type="button" class="remove_logo_button button"><?php esc_html_e( 'Remove logo', 'dots-elementor' ); ?></button>
			</div>
			<script type="text/javascript">
				if ( '0' === jQuery( '#product_brand_logo_id' ).val()) {
					jQuery( '.remove_logo_button' ).hide();
				}

				var file_frame;

				jQuery( document ).on( 'click', '.upload_logo_button', function( event ) {

					event.preventDefault();

					if ( file_frame ) {
						file_frame.open();

						return;
					}

					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php esc_html_e( 'Choose an logo', 'dots-elementor' ); ?>',
						button: {
							text: '<?php esc_html_e( 'Use logo', 'dots-elementor' ); ?>'
						},
						multiple: false,
					});

					file_frame.on( 'select', function() {
						var attachment = file_frame.state().get( 'selection' ).first().toJSON();
						var attachment_logo = attachment.sizes.logo || attachment.sizes.full;

						jQuery( '#product_brand_logo_id' ).val( attachment.id );
						jQuery( '#product_brand_logo' ).find( 'img' ).attr( 'src', attachment_logo.url );
						jQuery( '.remove_logo_button' ).show();
					});

					file_frame.open();
				});

				jQuery( document ).on( 'click', '.remove_logo_button', function() {
					jQuery( '#product_brand_logo' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_brand_logo_id' ).val( '' );
					jQuery( '.remove_logo_button' ).hide();

					return false;
				});
			</script>
			<div class="clear"></div>
		</td>
	</tr>

	<?php
}
add_action( 'product_brand_edit_form_fields', 'dots_product_brand_edit_fields', 10 );

// Save product brand fields.
function dost_product_brand_save_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
	if ( isset( $_POST['product_brand_logo_id'] ) && 'product_brand' === $taxonomy ) {
		update_term_meta( $term_id, 'logo_id', absint( $_POST['product_brand_logo_id'] ) );
	}
}
add_action( 'created_term', 'dost_product_brand_save_fields', 10, 3 );
add_action( 'edit_term', 'dost_product_brand_save_fields', 10, 3 );

// Add product brand logo column added to brands admin.
function dots_product_brand_columns( $columns ) {
	$new_columns = array();

	if ( isset( $columns['cb'] ) ) {
		$new_columns['cb'] = $columns['cb'];
		unset( $columns['cb'] );
	}

	$new_columns['logo'] = __( 'Logo', 'dots-elementor' );
	$columns = array_merge( $new_columns, $columns );

	return $columns;
}
add_filter( 'manage_edit-product_brand_columns', 'dots_product_brand_columns' );

// Add product brand logo column value added to brands admin.
function dots_product_brand_column( $columns, $column, $id ) {
	if ( 'logo' === $column ) {
		$logo_id = get_term_meta( $id, 'logo_id', true );

		if ( $logo_id ) {
			$logo = wp_get_attachment_thumb_url( $logo_id );
		} else {
			$logo = wc_placeholder_img_src();
		}

		// Prevent esc_url from breaking spaces in urls for logo embeds. Ref: https://core.trac.wordpress.org/ticket/23605 .
		$logo = str_replace( ' ', '%20', $logo );
		$columns .= '<img src="' . esc_url( $logo ) . '" alt="' . esc_attr__( 'Logo', 'dots-elementor' ) . '" class="wp-post-image" width="48" height="48" />';
	}

	return $columns;
}
add_filter( 'manage_product_brand_custom_column', 'dots_product_brand_column', 10, 3 );

// Add callback arguments for custom metabox.
function dots_add_metabox_args( $args ) {
	class DOTS_Meta_Box_Product_Brands {

		// Output the metabox.
		public static function output( $post, $box ) {
			$defaults = array( 'taxonomy' => 'category' );

			if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
				$args = array();
			} else {
				$args = $box['args'];
			}

			$parsed_args = wp_parse_args( $args, $defaults );
			$tax_name    = $parsed_args['taxonomy'];
			$taxonomy    = get_taxonomy( $parsed_args['taxonomy'] );
			?>

			<div id="taxonomy-<?php echo $tax_name; ?>" class="categorydiv">
				<ul id="<?php echo $tax_name; ?>-tabs" class="category-tabs">
					<li class="tabs">
						<a href="#<?php echo $tax_name; ?>-all"><?php echo $taxonomy->labels->all_items; ?></a>
					</li>
					<li class="hide-if-no-js">
						<a href="#<?php echo $tax_name; ?>-pop"><?php echo esc_html( $taxonomy->labels->most_used ); ?></a>
					</li>
				</ul>

				<div id="<?php echo $tax_name; ?>-pop" class="tabs-panel" style="display: none;">
					<ul id="<?php echo $tax_name; ?>checklist-pop" class="categorychecklist form-no-clear">
						<?php $popular_ids = wp_popular_terms_checklist( $tax_name ); ?>
					</ul>
				</div>

				<div id="<?php echo $tax_name; ?>-all" class="tabs-panel">
					<?php
						$name = ( 'category' === $tax_name ) ? 'post_category' : 'tax_input[' . $tax_name . ']';
						echo "<input type='hidden' name='{$name}[]' value='0' />";
					?>
					<ul
						id="<?php echo $tax_name; ?>checklist"
						data-wp-lists="list:<?php echo $tax_name; ?>"
						class="categorychecklist form-no-clear"
					>
						<?php
							wp_terms_checklist( $post->ID, array(
								'taxonomy'     => $tax_name,
								'popular_cats' => $popular_ids,
							) );
						?>
					</ul>
				</div>
			</div>

			<?php
		}
	}

	if ( ! isset( $args['meta_box_cb'] ) ) {
		$args['meta_box_cb']          = 'DOTS_Meta_Box_Product_Brands::output';
		$args['meta_box_sanitize_cb'] = 'taxonomy_meta_box_sanitize_cb_checkboxes';
	}
	return $args;
}
add_filter( 'dots_taxonomy_args_product_brand', 'dots_add_metabox_args' );

// Brands column added to products admin.
function dots_admin_product_brand_columns( $columns ) {
	$columns['product_brand'] = __( 'Brands', 'dots-elementor' );
	return array_slice( $columns, 0, 7, true ) + array( 'product_brand' => 'Brands' ) + array_slice( $columns, 7, count( $columns ) - 7, true );
}
add_filter( 'manage_edit-product_columns', 'dots_admin_product_brand_columns' );

// Brands column value added to products admin.
function dots_admin_product_brand_column( $column, $product_id ) {
	if ( 'product_brand' === $column  ) {
		$terms = get_the_terms( $product_id , 'product_brand' );

		if ( ! $terms ) {
			echo '<span class="na">&ndash;</span>';
		} else {
			$termlist = array();
			foreach ( $terms as $term ) {
				$termlist[] = '<a href="' . esc_url( admin_url( 'edit.php?product_brand=' . $term->slug . '&post_type=product' ) ) . ' ">' . esc_html( $term->name ) . '</a>';
			}

			echo apply_filters( 'woocommerce_admin_product_term_list', implode( ', ', $termlist ), 'product_brand', $product_id , $termlist, $terms ); // WPCS: XSS ok.
		}
	}
}
add_filter( 'manage_product_posts_custom_column', 'dots_admin_product_brand_column', 10, 7 );
