<?php

/**
 * The template for displaying the footer.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */


if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( defined( 'DOTS_ADDONS_ACTIVED' ) && DOTS_ADDONS_ACTIVED ) {
		if ( dots_addons_get_config( 'footer_style' ) === 'default' ) {
			do_action( 'dots_elementor_footer' );
		} else {
			do_action( 'dots_elementor_footer_builder' );
		}
	} else {
		get_template_part( 'template-parts/footer' );
	}
}

?>

<?php
do_action( 'dots_elementor_after_page' );

wp_footer();
?>

</body>
</html>
