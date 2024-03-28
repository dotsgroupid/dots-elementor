<?php

/**
 * Custom functions for Slider Post Types.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Register slider post types.
function dots_register_slider() {
	register_post_type(
		'slider',
		array(
			'label' => __( 'Sliders', 'dots-elementor' ),
			'labels' => array(
				'name'                  => __( 'Sliders', 'dots-elementor' ),
				'singular_name'         => __( 'Slider', 'dots-elementor' ),
				'menu_name'             => _x( 'Sliders', 'Admin menu name', 'dots-elementor' ),
				'search_items'          => __( 'Search Sliders', 'dots-elementor' ),
				'all_items'             => __( 'All Sliders', 'dots-elementor' ),
				'not_found'             => __( 'No sliders found', 'dots-elementor' ),
				'not_found_in_trash'    => __( 'No sliders found in Trash.', 'textdomain' ),
				'add_new'               => __( 'Add New Slider', 'dots-elementor' ),
				'add_new_item'          => __( 'Add New Slider', 'dots-elementor' ),
				'edit_item'             => __( 'Edit Slider', 'dots-elementor' ),
				'featured_image'        => _x( 'Slider Image','dots-elementor' ),
				'set_featured_image'    => _x( 'Set slider image', 'dots-elementor' ),
				'remove_featured_image' => _x( 'Remove slider image', 'dots-elementor' ),
				'use_featured_image'    => _x( 'Use as slider image', 'dots-elementor' ),
			),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => false,
			'rewrite' => false,
			'has_archive' => false,
			'hierarchical' => false,
			'exclude_from_search' => true,
			'menu_icon' => 'dashicons-slides',
			'capability_type' => 'post',
			'supports' => array( 'title', 'thumbnail', 'custom-fields' ),
		),
	);
}
add_action( 'init', 'dots_register_slider' );

// Change messages when a post type is updated.
function dots_updated_slider_messages( $messages ) {
	$messages[ 'slider' ] = array(
		0 => '',
		1 => __( 'Slider added.', 'dots-elementor' ),
		2 => __( 'Slider deleted.', 'dots-elementor' ),
		3 => __( 'Slider updated.', 'dots-elementor' ),
		4 => __( 'Slider not added.', 'dots-elementor' ),
		5 => __( 'Slider not updated.', 'dots-elementor' ),
		6 => __( 'Slider deleted.', 'dots-elementor' ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'dots_updated_slider_messages' );

// Specify custom bulk actions messages for different post types.
function dots_bulk_slider_updated_messages( $bulk_messages, $bulk_counts ) {
    $bulk_messages['slider'] = array(
        'updated'   => _n( '%s slider updated.', '%s sliders diperbarui.', $bulk_counts['updated'], 'dots-elementor' ),
        'locked'    => _n( '%s slider not updated, somebody is editing it.', '%s sliders not updated, somebody is editing them.', $bulk_counts['locked'], 'dots-elementor' ),
        'deleted'   => _n( '%s slider permanently deleted.', '%s sliders permanently deleted.', $bulk_counts['deleted'], 'dots-elementor' ),
        'trashed'   => _n( '%s slider moved to the Trash.', '%s sliders moved to the Trash.', $bulk_counts['trashed'], 'dots-elementor' ),
        'untrashed' => _n( '%s slider restored from the Trash.', '%s sliders restored from the Trash.', $bulk_counts['untrashed'], 'dots-elementor' ),
    );

    return $bulk_messages;
}
add_filter( 'bulk_post_updated_messages', 'dots_bulk_slider_updated_messages', 10, 2 );

// Register slider meta boxes.
function dots_register_slider_metaboxes() {
	add_meta_box( 'meta-box-id', __( 'Slider Settings', 'dots-elementor' ), 'dots_slider_metaboxes_content', 'slider', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'dots_register_slider_metaboxes' );

// Slider meta boxes display content.
function dots_slider_metaboxes_content( $post ) {
	global $post;

	$read_more_link = get_post_meta( $post->ID, 'dots_slider_link', true );
	?>

	<table class="form-table wpsisac-post-sett-table">
		<tbody>
			<tr valign="top">
				<th scope="row">
					<label for="dots-slider-link"><?php esc_html_e( 'Read More Link', 'dots-elementor' ); ?></label>
				</th>
				<td>
					<input
						type="text"
						id="dots-slider-link"
						class="large-text dots-slider-link"
						name="dots_slider_link"
						value="<?php echo esc_url( $read_more_link ); ?>"
					/>
					<br/>
				</td>
			</tr>
		</tbody>
	</table>

	<?php
}

// Slider save meta box content.
function dots_save_slider_metabox_value( $post_id ) {
	global $post_type;

	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		|| ( ! isset( $_POST['post_ID'] )
		|| $post_id != $_POST['post_ID'] ) || ( $post_type != 'slider' ) )
	{
		return $post_id;
	}

	$read_more_link = isset( $_POST['dots_slider_link']) ? esc_url_raw( trim($_POST['dots_slider_link']) )  : '';

	update_post_meta( $post_id, 'dots_slider_link', $read_more_link );
}
add_action( 'save_post', 'dots_save_slider_metabox_value' );
