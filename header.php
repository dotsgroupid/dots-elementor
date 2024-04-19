<?php

/**
 * The template for displaying the header.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
wp_body_open();

do_action( 'dots_elementor_before_page' );
?>

<a class="skip-link screen-reader-text" href="#content"><?php echo esc_html__( 'Skip to content', 'dots-elementor' ); ?></a>

<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	if ( defined( 'DOTS_ADDONS_ACTIVED' ) && DOTS_ADDONS_ACTIVED ) {
		if ( dots_addons_get_config( 'header_style' ) === 'default' ) {
			do_action( 'dots_elementor_header' );
		} else {
			do_action( 'dots_elementor_header_builder' );
		}
	} else {
		get_template_part( 'template-parts/header' );
	}
}
