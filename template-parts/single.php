<?php

/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */

while ( have_posts() ) :
	the_post();
?>

<main id="content" <?php post_class( 'site-main' ); ?>>
	<header class="page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<div class="page-content">
		<?php the_content(); ?>

		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . esc_html__( 'Tagged ', 'dots-elementor' ), null, '</span>' ); ?>
		</div>

		<?php wp_link_pages(); ?>
	</div>

	<?php comments_template(); ?>
</main>

<?php

endwhile;
