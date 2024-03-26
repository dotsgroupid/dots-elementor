<?php

/**
 * The template for displaying the front pages.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

get_header();
?>

<?php
$args = array(
    'post_type' => 'slider',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'ASC',
);
$the_query = new WP_Query($args);

if ($the_query->have_posts()) :
?>

<div id="banner" class="md:py-6 pt-2.5 pb-6 mx-auto w-full overflow-hidden">
	<div class="slick-slider mx-4 md:container md:mx-auto lg:container xl:container">
		<?php
			// Start the loop
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
		?>
		<div>
			<a href="<?php echo esc_attr( get_post_meta( get_the_ID(), 'dots_slider_link', true ) ); ?>" class="cursor-pointer">
				<picture class="block w-full max-w-full">
					<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="rounded-2" width="720" height="360" loading="eager">
				</picture>
			</a>
		</div>
		<?php
			// End the loop
			endwhile;

			wp_reset_postdata();
		?>
	</div>
	<script>
		jQuery( document ).on( 'ready', function( event ) {

			event.preventDefault();

			jQuery( '#banner .slick-slider' ).slick({
				autoplay: true,
				centerMode: true,
				centerPadding: '208px',
				dots: true,
				infinite: true,
				variableWidth: true,
			});

		});
	</script>
</div>

<?php
endif;

$args = array(
'public'   => true,
'_builtin' => false

);
$output = 'names'; // or objects
$operator = 'and'; // 'and' or 'or'
$taxonomies = get_taxonomies( $args, $output, $operator );

if ( $taxonomies ) {
	echo '<ul>';
	foreach ( $taxonomies  as $taxonomy ) {
		echo '<li>' . $taxonomy . '</li>';
	}
	echo '</ul>';
}

get_footer();
