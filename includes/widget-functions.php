<?php

/**
 * Custom functions for Widgets.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Include widget classes.
require_once DOTS_THEME_DIR . '/includes/widgets/widget-product-categories.php';

// Register Widgets.
function dots_register_widgets() {
	register_widget( 'Dots_Widget_Product_Categories' );
}
add_action( 'widgets_init', 'dots_register_widgets' );
