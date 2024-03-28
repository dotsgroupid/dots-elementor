<?php

/**
 * DOTS. Elementor functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Set the content width based on the theme's design and stylesheet
if ( ! isset( $content_width ) ) {
	$content_width = 1136;
}

/**
 * Sets up theme defaults and registers support for various WordPress features
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
if ( ! function_exists( 'dots_elementor_setup' ) ) {
	function dots_elementor_setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'dots-elementor' ) ] );
		register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'dots-elementor' ) ] );

		// Switch default core markup for search form to output valid HTML5.
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
			]
		);

		// Add theme support for Custom Logo.
		add_theme_support(
			'custom-logo',
			[
				'height'		=> 100,
				'width'			=> 350,
				'flex-height'	=> true,
				'flex-width'	=> true,
			]
		);

		// Add theme support for WooCommerce.
		if ( apply_filters( 'dots_add_woocommerce_support', true ) ) {
			add_theme_support( 'woocommerce' ); // WooCommerce in general.
			add_theme_support( 'wc-product-gallery-zoom' ); // Enabling WooCommerce product gallery zoom.
			add_theme_support( 'wc-product-gallery-lightbox' ); // Enabling WooCommerce product gallery lightbox.
			add_theme_support( 'wc-product-gallery-slider' ); // Enabling WooCommerce product gallery slider.
		}
	}
}
add_action( 'after_setup_theme', 'dots_elementor_setup' );

// Enqueue scripts and styles.
if ( ! function_exists( 'dots_elementor_scripts_styles' ) ) {
	function dots_elementor_scripts_styles()
	{
		wp_enqueue_style( 'dots-tailwind-style', get_parent_theme_file_uri('assets/css/tailwind.css'), [], '2.2.4' );

		wp_enqueue_style( 'dots-elementor-style', get_stylesheet_uri(), [], '1.0' );
		wp_enqueue_style( 'dots-elementor-theme', get_parent_theme_file_uri('assets/css/theme.css'), [], '1.0' );

		wp_enqueue_style( 'dots-slick-style', get_parent_theme_file_uri('assets/css/slick.css'), [], '1.8.1' );
		wp_enqueue_script( 'dots-slick-script', get_parent_theme_file_uri('assets/js/slick.js'), array('jquery'), '1.8.1', true );

		wp_enqueue_script( 'dots-elementor-script', get_parent_theme_file_uri('assets/js/script.js'), array('jquery'), '1.0', true );

		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('global-styles');
		wp_dequeue_style('classic-theme-styles');
	}
}
add_action( 'wp_enqueue_scripts', 'dots_elementor_scripts_styles' );

// Register Elementor Locations.
if ( ! function_exists( 'dots_elementor_register_elementor_locations' ) ) {
	function dots_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'dots_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'dots_elementor_register_elementor_locations' );

// Set default content width.
if ( ! function_exists( 'dots_elementor_content_width' ) ) {
	function dots_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'dots_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'dots_elementor_content_width', 0 );

// Add description meta tag with excerpt text.
if ( ! function_exists( 'dots_elementor_add_description_meta_tag' ) ) {
	function dots_elementor_add_description_meta_tag() {
		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'dots_elementor_add_description_meta_tag' );

// Custom Admin Functions.
require get_template_directory() . '/includes/admin-functions.php';

// Custom Slider Functions.
require get_template_directory() . '/includes/slider-functions.php';

// Custom Elementor Plugins Functions.
require get_template_directory() . '/includes/elementor-functions.php';

// Custom WooCommerce Plugins Functions.
if ( class_exists( 'woocommerce' ) ) {
	require get_template_directory() . '/includes/woocommerce-functions.php';
}
