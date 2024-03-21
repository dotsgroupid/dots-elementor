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
if (!isset($content_width)) {
    $content_width = 1320;
}

/**
 * Sets up theme defaults and registers support for various WordPress features
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
if (!function_exists('dots_elementor_setup')) {
    function dots_setup()
    {
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
        add_theme_support('title-tag');

        /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(
            array(
                'menu-1' => esc_html__('Header', 'dots-elementor'),
                'menu-2' => esc_html__('Footer', 'dots-elementor'),
            )
        );

        // Switch default core markup for search form to output valid HTML5.
        add_theme_support('html5', array(
            'search-form',
            'gallery',
            'caption',
            'script',
            'style',
        ));

        // Add theme support for Custom Logo.
        add_theme_support('custom-logo', array(
            'height' => 100,
            'width' => 350,
            'flex-height' => true,
            'flex-width' => true,
        ));

        // Add theme support for WooCommerce.
        if (apply_filters('dots_add_woocommerce_support', true)) {
            add_theme_support('woocommerce');
            add_theme_support('wc-product-gallery-zoom');
            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support('wc-product-gallery-slider');
        }
    }
}
add_action('after_setup_theme', 'dots_elementor_setup');
