<?php

/**
 * The template for displaying header.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */

$header_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-primary',
	'fallback_cb' => false,
	'echo' => false,
] );

?>

<header id="site-header" class="site-header dynamic-header menu-dropdown-tablet">
	<div class="header-inner">
		<div class="site-branding show-title">
			<h1 class="site-title show">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr__( 'Home', 'dots-elementor' ); ?>">
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</a>
			</h1>
			<p class="site-description show">
				<?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?>
			</p>
		</div>

		<?php if ( $header_nav_menu ) : ?>
		<nav class="site-navigation show">
			<?php echo $header_nav_menu; ?>
		</nav>

		<div class="site-navigation-toggle-holder show">
			<div class="site-navigation-toggle" role="button" tabindex="0">
				<i class="eicon-menu-bar" aria-hidden="true"></i>
				<span class="screen-reader-text"><?php echo esc_html__( 'Menu', 'hello-elementor' ); ?></span>
			</div>
		</div>

		<nav class="site-navigation-dropdown show">
			<?php echo $header_nav_menu; ?>
		</nav>
		<?php endif; ?>
	</div>
</header>
