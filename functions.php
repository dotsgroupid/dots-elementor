<?php

/**
 * DOTS. Elementor functions and definitions.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */

// Define Constants.
define( 'DOTS_THEME_VERSION', '1.1.0' );
define( 'DOTS_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'DOTS_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );

// Sets up theme defaults and registers support for various WordPress features.
function dots_elementor_setup() {
	// Sets the content width in pixels, based on the theme's design and stylesheet.
	$GLOBALS['content_width'] = apply_filters( 'dots_elementor_content_width', 1136 );

	// Add default theme support.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		],
	);

	// Register theme nav menu
	register_nav_menus( [ 'primary' => esc_html__( 'Primary', 'dots-elementor' ) ] );

	// Add theme support for WooCommerce.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'dots_elementor_setup' );

// Enqueue scripts and styles.
function dots_elementor_enqueue_scripts() {
	// Register and enqueue styles.
	wp_register_style( 'theme', DOTS_THEME_URI . 'assets/css/theme.min.css', array(), DOTS_THEME_VERSION );
	wp_enqueue_style(
		'dots-elementor', get_stylesheet_uri(), array(
			'theme',
		), DOTS_THEME_VERSION
	);

	// Register and enqueue scripts.
	wp_enqueue_script(
			'dots-elementor', DOTS_THEME_URI . 'assets/js/scripts.js', array(
			'jquery',
		), DOTS_THEME_VERSION, true
	);
}
add_action( 'wp_enqueue_scripts', 'dots_elementor_enqueue_scripts' );

// Register Elementor Locations.
function dots_elementor_register_elementor_locations( $elementor_theme_manager ) {
	if ( apply_filters( 'dots_elementor_register_elementor_locations', true ) ) {
		$elementor_theme_manager->register_all_core_location();
	}
}
add_action( 'elementor/theme/register_locations', 'dots_elementor_register_elementor_locations' );

if ( is_admin() ) {
	require DOTS_THEME_DIR . '/includes/libraries/class-tgm-plugin-activation.php';
	require DOTS_THEME_DIR . '/includes/plugins.php';
}
