<?php

/**
 * Register required, recommended plugins for theme.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */

// Register required plugins.
function dots_elementor_register_required_plugins() {
	$plugins = array(

		array(
			'name' => esc_html__( 'WooCommerce', 'dots-elementor' ),
			'slug' => 'woocommerce',
			'required' => false,
		),

		array(
			'name' => esc_html__( 'WCBoost – Variation Swatches', 'dots-elementor' ),
			'slug' => 'wcboost-variation-swatches',
			'required' => false,
		),

		array(
			'name' => esc_html__( 'WP Fastest Cache', 'dots-elementor' ),
			'slug' => 'wp-fastest-cache',
			'required' => false,
		),

	);

	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {

		$plugins[] = array(
			'name' => esc_html__( 'Elementor Website Builder – More than Just a Page Builder', 'dots-elementor' ),
			'slug' => 'elementor',
			'required' => true,
			'force_activation' => false,
			'force_deactivation' => false,
		);
	}

	$config = array(
		'id' => 'dots-elementor',
		'menu' => 'install-required-plugins',
		'has_notices' => true,
		'is_automatic' => false,
		'message' => '',
		'strings' => array(
			'page_title' => esc_html__( 'Install Required Plugins', 'dots-elementor' ),
			'menu_title' => esc_html__( 'Install Plugins', 'dots-elementor' ),
			'installing' => esc_html__( 'Installing Plugin: %s', 'dots-elementor' ),
			'oops' => esc_html__( 'Something went wrong with the plugin API.', 'dots-elementor' ),
			'notice_can_install_required' => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'dots-elementor'
			),
			'notice_can_install_recommended' => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'dots-elementor'
			),
			'notice_cannot_install' => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.',
				'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.',
				'dots-elementor'
			),
			'notice_can_activate_required' => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'dots-elementor'
			),
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'dots-elementor'
			),
			'notice_cannot_activate' => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.',
				'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.',
				'dots-elementor'
			),
			'notice_ask_to_update' => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'dots-elementor'
			),
			'notice_cannot_update' => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.',
				'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.',
				'dots-elementor'
			),
			'install_link' => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'dots-elementor' ),
			'activate_link' => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'dots-elementor' ),
			'return' => esc_html__( 'Return to Required Plugins Installer', 'dots-elementor' ),
			'plugin_activated' => esc_html__( 'Plugin activated successfully.', 'dots-elementor' ),
			'complete' => esc_html__( 'All plugins installed and activated successfully. %s', 'dots-elementor' ),
			'nag_type' => 'updated',
		),
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'dots_elementor_register_required_plugins' );
