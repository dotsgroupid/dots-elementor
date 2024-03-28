<?php

/**
 * The template for displaying footer.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

$footer_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-2',
	'fallback_cb' => false,
	'echo' => false,
] );
?>

<footer id="site-footer" class="site-footer">

	<?php if ( $footer_nav_menu ) : ?>
		<nav class="site-navigation">
			<?php echo $footer_nav_menu; ?>
		</nav>
	<?php endif; ?>

</footer>
