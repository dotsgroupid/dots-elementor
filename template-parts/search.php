<?php

/**
 * The template for displaying search results.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */

?>

<main id="content" class="site-main">
	<header class="page-header">
		<h1 class="entry-title">
			<?php echo esc_html__( 'Search results for: ', 'dots-elementor' ); ?>
			<span><?php echo get_search_query(); ?></span>
		</h1>
	</header>

	<div class="page-content">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) :

				the_post();
				$post_link = get_permalink();
		?>
			<article class="post">
				<?php
				printf( '<h2 class="%s"><a href="%s">%s</a></h2>', 'entry-title', esc_url( $post_link ), wp_kses_post( get_the_title() ) );
				if ( has_post_thumbnail() ) {
					printf( '<a href="%s">%s</a>', esc_url( $post_link ), get_the_post_thumbnail( $post, 'large' ) );
				}
				the_excerpt();
				?>
			</article>
		<?php
				endwhile;
			else :
		?>
			<p><?php echo esc_html__( 'It seems we can\'t find what you\'re looking for.', 'dots-elementor' ); ?></p>
		<?php endif; ?>
	</div>

	<?php
		wp_link_pages();

		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
	?>
		<nav class="pagination">
			<div class="nav-previous"><?php next_posts_link( sprintf( __( '%s older', 'dots-elementor' ), '<span class="meta-nav">&larr;</span>' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( sprintf( __( 'newer %s', 'dots-elementor' ), '<span class="meta-nav">&rarr;</span>' ) ); ?></div>
		</nav>
	<?php endif; ?>
</main>
