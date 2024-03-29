<?php

/**
 * Custom functions for Elementor Plugins.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Register Elementor categories.
function dots_elementor_register_categories( $elements_manager ) {
    $elements_manager->add_category(
        'dots-elementor-addons',
        [
            'title' => esc_html__( 'DOTS. Elementor - Addons', 'dots-elementor-addons' ),
            'icon'  => 'fa fa-circle'
        ]
    );
}
add_action( 'elementor/elements/categories_registered', 'dots_elementor_register_categories' );

// Register Elementor widgets.
function dots_elementor_register_widget( $widgets_manager ) {
	require_once DOTS_THEME_DIR . '/includes/widgets/slides-widget.php';

	$widgets_manager->register( new \Elementor_Slides_Widget() );
}
add_action( 'elementor/widgets/register', 'dots_elementor_register_widget' );

// Register styles and scripts for Elementor Widgets.
function dots_elementor_widgets_dependencies() {
	wp_register_script( 'dots-elementor-editor-script', DOTS_THEME_URI . 'assets/js/elementor.js', array( 'elementor-frontend' ), DOTS_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'dots_elementor_widgets_dependencies' );
