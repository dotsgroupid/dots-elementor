<?php

/**
 * Custom functions for Elementor Plugin.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Show in WP Dashboard notice.
function dots_elementor_fail_load_admin_notice() {
	// Leave to Elementor Pro to manage this.
	if ( function_exists( 'elementor_pro_load_plugin' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	if ( 'true' === get_user_meta( get_current_user_id(), '_dots_elementor_install_notice', true ) ) {
		return;
	}

	$plugin = 'elementor/elementor.php';
	$installed_plugins = get_plugins();
	$is_elementor_installed = isset( $installed_plugins[ $plugin ] );

	$message = esc_html__( 'The DOTS. Theme is a dynamic custom theme that works perfectly with the Elementor plugin for you, by us.', 'dots-elementor' );

	if ( $is_elementor_installed ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$button_text = esc_html__( 'Activate Elementor', 'dots-elementor' );
		$button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$button_text = esc_html__( 'Install Elementor', 'dots-elementor' );
		$button_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
	}

?>
	<style>
		.notice.dots-elementor-notice {
			border: 1px solid #ccd0d4;
			border-inline-start: 4px solid #9b0a46 !important;
			box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
			display: flex;
			padding: 0px;
		}

		.notice.dots-elementor-notice.dots-elementor-install-elementor {
			padding: 0px;
		}

		.notice.dots-elementor-notice .dots-elementor-notice-aside {
			background: rgba(215, 43, 63, 0.04);
			display: flex;
			align-items: start;
			justify-content: center;
			padding: 20px 10px;
		}

		.notice.dots-elementor-notice .dots-elementor-notice-aside img {
			width: 1.5rem;
		}

		.notice.dots-elementor-notice .dots-elementor-notice-content {
			display: flex;
			flex-direction: column;
			gap: 5px;
			width: 100%;
			padding: 20px;
		}

		.notice.dots-elementor-notice .dots-elementor-notice-content h3,
		.notice.dots-elementor-notice .dots-elementor-notice-content p {
			padding: 0px;
			margin: 0px;
		}

		.notice.dots-elementor-notice .dots-elementor-information-link {
			align-self: start;
		}

		.notice.dots-elementor-notice .dots-elementor-install-button {
			background-color: #127DB8;
			border-radius: 3px;
			color: #fff;
			line-height: 20px;
			text-decoration: none;
			align-self: start;
			height: auto;
			padding: 0.4375rem 0.75rem;
			margin-block-start: 15px;
		}

		.notice.dots-elementor-notice .dots-elementor-install-button:active {
			transform: translateY(1px);
		}

		@media (max-width: 767px) {
			.notice.dots-elementor-notice .dots-elementor-notice-aside {
				padding: 10px;
			}

			.notice.dots-elementor-notice .dots-elementor-notice-content {
				gap: 10px;
				padding: 10px;
			}
		}
	</style>
	<script>
		window.addEventListener( 'load', () => {
			const dismissNotice = document.querySelector( '.notice.dots-elementor-install-elementor button.notice-dismiss' );
			dismissNotice.addEventListener( 'click', async (event) => {
				event.preventDefault();

				var formData = new FormData();
				formData.append( 'action', 'dots_elementor_set_admin_notice_viewed' );
				formData.append( 'dismiss_nonce', '<?php echo esc_js( wp_create_nonce( 'dots_elementor_dismiss_install_notice' ) ); ?>' );

				await fetch( ajaxurl, { method: 'POST', body: formData } );
			});
		});
	</script>
	<div class="notice updated is-dismissible dots-elementor-notice dots-elementor-install-elementor">
		<div class="dots-elementor-notice-aside">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/elementor-notice-icon.svg' ); ?>" alt="<?php echo esc_attr__( 'Get Elementor', 'dots-elementor' ); ?>" />
		</div>
		<div class="dots-elementor-notice-content">
			<h3><?php echo esc_html__( 'Thanks for installing the DOTS. Theme!', 'dots-elementor' ); ?></h3>
			<p><?php echo esc_html( $message ); ?></p>
			<a class="dots-elementor-information-link" href="https://thedotscreative.com/products/wp-dots-elementor/" target="_blank"><?php echo esc_html__( 'Learn more about this Theme', 'dots-elementor' ); ?></a>
			<a class="dots-elementor-install-button" href="<?php echo esc_attr( $button_link ); ?>"><?php echo esc_html( $button_text ); ?></a>
		</div>
	</div>
<?php
}

// Set dismissed admin notice as viewed.
function ajax_dots_elementor_set_admin_notice_viewed() {
	check_ajax_referer( 'dots_elementor_dismiss_install_notice', 'dismiss_nonce' );

	update_user_meta( get_current_user_id(), '_dots_elementor_install_notice', 'true' );
	die;
}
add_action( 'wp_ajax_dots_elementor_set_admin_notice_viewed', 'ajax_dots_elementor_set_admin_notice_viewed' );

if ( ! did_action( 'elementor/loaded' ) ) {
	add_action( 'admin_notices', 'dots_elementor_fail_load_admin_notice' );
}
