<?php

/**
 * The template for displaying footer.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */

?>

<footer id="site-footer" class="site-footer dynamic-footer footer-has-copyright">
	<div class="footer-inner">
		<div class="site-branding show-title">
			<h4 class="site-title show">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr__( 'Home', 'dots-elementor' ); ?>">
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</a>
			</h4>
			<p class="site-description show">
				<?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?>
			</p>
		</div>
		<div class="copyright show">
			<p>All rights reserved</p>
		</div>
	</div>
</footer>
