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

if ( $the_query->have_posts() ) :
?>

<div id="banner" class="w-full pt-2.5 pb-6 mx-auto overflow-hidden md:py-6">
	<div class="slick-slider mx-4 md:container md:mx-auto lg:container xl:container">
		<?php
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
		?>
		<div>
			<a href="<?php echo esc_attr( get_post_meta( get_the_ID(), 'dots_slider_link', true ) ); ?>" class="cursor-pointer">
				<picture class="block max-w-full w-full">
					<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="rounded-2" width="720" height="360" loading="eager">
				</picture>
			</a>
		</div>
		<?php
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

$brands = get_terms( array( 'taxonomy' => 'product_brand', 'orderby' => 'term_id', 'hide_empty' => false ) );

if ( !empty( $brands ) ) :
?>

<section class="brands mt-6 md:pt-6 md:pb-12 md:mt-0">
	<div class="upper flex items-center justify-between w-full px-4 mb-3.5 md:px-0 md:mb-2">
		<h1 class="text-primary-1 text-base font-bold md:text-2xl">Brand Terlaris</h1>
		<div class="text-right">
			<a href="/brands" class="text-neutral-300 text-sm font-bold md:text-base md:leading-8">Lihat Semua</a>
		</div>
	</div>
	<div id="popular-brand" class="lower">
		<div class="slick-slider px-4 md:px-0">
			<?php
			foreach( $brands as $brand ) {
			?>
			<div>
				<div class="p-0.5 md:p-2">
					<a href="<?php echo get_term_link( $brand ); ?>" class="brand brand-card border-1 border-solid border-neutral-800 rounded-2 flex justify-center relative">
						<picture class="flex items-center justify-center">
							<img src="<?php echo wp_get_attachment_url( get_term_meta( $brand->term_id, 'logo_id', true ) ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>" class="object-contain" loading="lazy">
						</picture>
					</a>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<script>
		jQuery( document ).on( 'ready', function( event ) {

			event.preventDefault();

			jQuery( '#popular-brand .slick-slider' ).slick({
				infinite: false,
				slidesToShow: 8,
				slidesToScroll: 8,
			});

		});
	</script>
	</div>
</section>

<?php
endif;

get_footer();
