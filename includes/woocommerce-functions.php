<?php

/**
 * Custom functions for WooCommerce Plugin.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Register Product Brand post types.
function dots_register_product_brand()
{
	register_taxonomy(
		'product_brand',
		array('product'),
		array(
			'update_count_callback' => '_wc_term_recount',
			'label' => __('Brands', 'dots-elementor'),
			'labels' => array(
				'name'                  => __('Product brands', 'dots-elementor'),
				'singular_name'         => __('Brand', 'dots-elementor'),
				'menu_name'             => _x('Brands', 'Admin menu name', 'dots-elementor'),
				'search_items'          => __('Search brands', 'dots-elementor'),
				'all_items'             => __('All brands', 'dots-elementor'),
				'edit_item'             => __('Edit brand', 'dots-elementor'),
				'update_item'           => __('Update brand', 'dots-elementor'),
				'add_new_item'          => __('Add new brand', 'dots-elementor'),
				'new_item_name'         => __('New brand name', 'dots-elementor'),
				'not_found'             => __('No brands found', 'dots-elementor'),
				'item_link'             => __('Product Brand Link', 'dots-elementor'),
				'item_link_description' => __('A link to a product brand.', 'dots-elementor'),
			),
			'show_in_rest' => true,
			'show_ui' => true,
			'query_var' => true,
			'capabilities' => array(
				'manage_terms' => 'manage_product_terms',
				'edit_terms'   => 'edit_product_terms',
				'delete_terms' => 'delete_product_terms',
				'assign_terms' => 'assign_product_terms',
			),
			'rewrite' => array(
				'slug'         => 'brand',
				'with_front'   => false,
				'hierarchical' => false,
			),
		)
	);
}
add_action('init', 'dots_register_product_brand');

// Change messages when a post type is updated.
function dots_updated_term_messages($messages)
{
	$messages['product_brand'] = array(
		0 => '',
		1 => __('Brand added.', 'dots-elementor'),
		2 => __('Brand deleted.', 'dots-elementor'),
		3 => __('Brand updated.', 'dots-elementor'),
		4 => __('Brand not added.', 'dots-elementor'),
		5 => __('Brand not updated.', 'dots-elementor'),
		6 => __('Brands deleted.', 'dots-elementor'),
	);

	return $messages;
}
add_filter('term_updated_messages', 'dots_updated_term_messages');

/**
 * Enqueue scripts.
 */
function dots_admin_scripts()
{
	$screen       = get_current_screen();
	$screen_id    = $screen ? $screen->id : '';

	// Edit product category pages.
	if (in_array($screen_id, array('edit-product_brand'))) {
		wp_enqueue_media();
	}
}
add_action('admin_enqueue_scripts', 'dots_admin_scripts');

// Brand logo fields.
function dots_add_brand_fields()
{
?>
	<div class="form-field term-logo-wrap">
		<label><?php esc_html_e('Logo', 'dots-elementor'); ?></label>
		<div id="product_brand_logo" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="product_brand_logo_id" name="product_brand_logo_id" />
			<button type="button" class="upload_logo_button button"><?php esc_html_e('Upload/Add logo', 'dots-elementor'); ?></button>
			<button type="button" class="remove_logo_button button"><?php esc_html_e('Remove logo', 'dots-elementor'); ?></button>
		</div>
		<script type="text/javascript">
			// Only show the "remove logo" button when needed
			if (!jQuery('#product_brand_logo_id').val()) {
				jQuery('.remove_logo_button').hide();
			}

			// Uploading files
			var file_frame;

			jQuery(document).on('click', '.upload_logo_button', function(event) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if (file_frame) {
					file_frame.open();
					return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e('Choose an logo', 'dots-elementor'); ?>',
					button: {
						text: '<?php esc_html_e('Use logo', 'dots-elementor'); ?>'
					},
					multiple: false
				});

				// When an logo is selected, run a callback.
				file_frame.on('select', function() {
					var attachment = file_frame.state().get('selection').first().toJSON();
					var attachment_logo = attachment.sizes.logo || attachment.sizes.full;

					jQuery('#product_brand_logo_id').val(attachment.id);
					jQuery('#product_brand_logo').find('img').attr('src', attachment_logo.url);
					jQuery('.remove_logo_button').show();
				});

				// Finally, open the modal.
				file_frame.open();
			});

			jQuery(document).on('click', '.remove_logo_button', function() {
				jQuery('#product_brand_logo').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
				jQuery('#product_brand_logo_id').val('');
				jQuery('.remove_logo_button').hide();
				return false;
			});

			jQuery(document).ajaxComplete(function(event, request, options) {
				if (request && 4 === request.readyState && 200 === request.status &&
					options.data && 0 <= options.data.indexOf('action=add-tag')) {

					var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
					if (!res || res.errors) {
						return;
					}

					// Clear Logo fields on submit
					jQuery('#product_brand_logo').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
					jQuery('#product_brand_logo_id').val('');
					jQuery('.remove_logo_button').hide();

					return;
				}
			});
		</script>
		<div class="clear"></div>
	</div>
<?php
}
add_action('product_brand_add_form_fields', 'dots_add_brand_fields');

// Edit category logo field.
function dots_edit_category_fields($term)
{
	$logo_id = absint(get_term_meta($term->term_id, 'logo_id', true));

	if ($logo_id) {
		$logo = wp_get_attachment_thumb_url($logo_id);
	} else {
		$logo = wc_placeholder_img_src();
	}
?>
	<tr class="form-field term-logo-wrap">
		<th scope="row" valign="top"><label><?php esc_html_e('Logo', 'woocommerce'); ?></label></th>
		<td>
			<div id="product_brand_logo" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url($logo); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_brand_logo_id" name="product_brand_logo_id" value="<?php echo esc_attr($logo_id); ?>" />
				<button type="button" class="upload_logo_button button"><?php esc_html_e('Upload/Add logo', 'woocommerce'); ?></button>
				<button type="button" class="remove_logo_button button"><?php esc_html_e('Remove logo', 'woocommerce'); ?></button>
			</div>
			<script type="text/javascript">
				// Only show the "remove logo" button when needed
				if ('0' === jQuery('#product_brand_logo_id').val()) {
					jQuery('.remove_logo_button').hide();
				}

				// Uploading files
				var file_frame;

				jQuery(document).on('click', '.upload_logo_button', function(event) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if (file_frame) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php esc_html_e('Choose an logo', 'woocommerce'); ?>',
						button: {
							text: '<?php esc_html_e('Use logo', 'woocommerce'); ?>'
						},
						multiple: false
					});

					// When an logo is selected, run a callback.
					file_frame.on('select', function() {
						var attachment = file_frame.state().get('selection').first().toJSON();
						var attachment_logo = attachment.sizes.logo || attachment.sizes.full;

						jQuery('#product_brand_logo_id').val(attachment.id);
						jQuery('#product_brand_logo').find('img').attr('src', attachment_logo.url);
						jQuery('.remove_logo_button').show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery(document).on('click', '.remove_logo_button', function() {
					jQuery('#product_brand_logo').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
					jQuery('#product_brand_logo_id').val('');
					jQuery('.remove_logo_button').hide();
					return false;
				});
			</script>
			<div class="clear"></div>
		</td>
	</tr>
<?php
}
add_action('product_brand_edit_form_fields', 'dots_edit_category_fields', 10);

// Save brand fields
function dost_save_brand_fields($term_id, $tt_id = '', $taxonomy = '')
{
	if (isset($_POST['product_brand_logo_id']) && 'product_brand' === $taxonomy) { // WPCS: CSRF ok, input var ok.
		update_term_meta($term_id, 'logo_id', absint($_POST['product_brand_logo_id'])); // WPCS: CSRF ok, input var ok.
	}
}
add_action('created_term', 'dost_save_brand_fields', 10, 3);

// Description for product_brand page to aid users.
function dots_product_brand_description()
{
	echo wp_kses(
		wpautop(__('Product brands for your store can be managed here. To change the order of brands on the front-end you can drag and drop to sort them. To see more brands listed click the "screen options" link at the top-right of this page.', 'dots-elementor')),
		array('p' => array())
	);
}
add_action('product_brand_pre_add_form', 'dots_product_brand_description');

// Add some notes to describe the behavior of the default brand.
function dots_product_brand_notes()
{
?>
	<div class="form-wrap edit-term-notes">
		<p>
			<strong><?php esc_html_e('Note:', 'dots-elementor'); ?></strong><br>
			<?php esc_html_e('Deleting a brand does not delete the products in that brand.', 'dots-elementor'); ?>
		</p>
	</div>
<?php
}
add_action('after-product_brand-table', 'dots_product_brand_notes');

// Logo column added to category admin.
function dots_product_brand_columns($columns)
{
	$new_columns = array();

	if (isset($columns['cb'])) {
		$new_columns['cb'] = $columns['cb'];
		unset($columns['cb']);
	}

	$new_columns['thumb'] = __('Logo', 'dots-elementor');

	$columns = array_merge($new_columns, $columns);

	return $columns;
}
add_filter('manage_edit-product_brand_columns', 'dots_product_brand_columns');

// Logo column value added to category admin.
function dots_product_brand_column($columns, $column, $id)
{
	if ('thumb' === $column) {
		$logo_id = get_term_meta($id, 'logo_id', true);

		if ($logo_id) {
			$logo = wp_get_attachment_thumb_url($logo_id);
		} else {
			$logo = wc_placeholder_img_src();
		}

		// Prevent esc_url from breaking spaces in urls for logo embeds. Ref: https://core.trac.wordpress.org/ticket/23605 .
		$logo    = str_replace(' ', '%20', $logo);
		$columns .= '<img src="' . esc_url($logo) . '" alt="' . esc_attr__('Logo', 'woocommerce') . '" class="wp-post-image" width="48" height="48" />';
	}

	return $columns;
}
add_filter('manage_product_brand_custom_column', 'dots_product_brand_column', 10, 3);
