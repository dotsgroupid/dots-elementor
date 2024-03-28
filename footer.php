<?php

/**
 * The template for displaying the footer.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
			get_template_part( 'template-parts/footer' );
		}

		wp_footer();
?>

	</body>
</html>
