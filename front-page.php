<?php

/**
 * The template for displaying the front pages.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

get_header();

$args = array(
    'post_type' => 'slider',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'ASC',
);
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) :
?>

<div id="banner" class="w-full pt-2.5 pb-6 mx-auto overflow-hidden md:py-6">
	<div class="slick-slider mx-4 md:container md:mx-auto lg:container xl:container">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div>
			<a href="<?php echo esc_attr( get_post_meta( get_the_ID(), 'dots_slider_link', true ) ); ?>" class="cursor-pointer">
				<picture class="block max-w-full w-full">
					<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="rounded-2" width="720" height="360" loading="eager">
				</picture>
			</a>
		</div>
		<?php endwhile; wp_reset_postdata(); ?>
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
			<?php foreach( $brands as $brand ) { ?>
			<div>
				<div class="p-0.5 md:p-2">
					<a href="<?php echo get_term_link( $brand ); ?>" class="brand brand-card border-1 border-solid border-neutral-800 rounded-2 flex justify-center relative">
						<picture class="flex items-center justify-center">
							<img src="<?php echo wp_get_attachment_url( get_term_meta( $brand->term_id, 'logo_id', true ) ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>" class="object-contain" loading="lazy">
						</picture>
					</a>
				</div>
			</div>
			<?php } ?>
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

<?php endif; ?>

<div class="grid grid-cols-1 gap-8 mt-8 md:flex md:flex-col md:gap-12 md:mt-0">

	<?php
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => 'motor-roda-dua',
				),
			),
			'orderby' => 'rand',
		);
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) :
	?>

	<div class="custom-area px-4 overflow-x-hidden md:px-0">
		<div class="upper grid grid-cols-12 w-full mb-3.5 md:mb-2">
			<h1 class="text-primary-1 text-base font-bold col-span-9 pr-4 md:col-span-10 md:text-2xl">Motor Roda Dua</h1>
			<div class="text-right col-span-3 md:col-span-2">
				<a href="https://www.jamtangan.com/c/jam-tangan-pria" class="text-neutral-300 text-sm font-bold md:text-base md:leading-8">Lihat Semua</a>
			</div>
		</div>
		<div class="custom-area product-list md:px-0">
			<div class="lower">
				<div class="product-slider mt-5 md:pb-4 md:mt-4">
					<div class="product-slider slick-slider">
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); $product = wc_get_product( get_the_ID() ); ?>
						<div>
							<div class="product h-inherit px-1.5 md:px-2">
								<div class="bg-neutral-900 rounded-2 relative h-full">
									<a href="<?php echo get_the_permalink(); ?>">
										<div class="card product-card-container cursor-pointer bg-neutral-900 rounded-2 relative h-full" style="box-shadow: none;">
											<div class="product-card relative">
												<div class="relative pt-4 px-2 md:px-4">
													<div class="box-img flex items-center">
														<picture><?php echo the_post_thumbnail(); ?></picture>
													</div>
												</div>
												<div class="py-2 px-4 pb-4 mt-4">
													<p class="product-name text-neutral-0 text-sm font-normal leading-6 h-12 mb-1"><?php echo get_the_title(); ?></p>
													<div class="text-primary-1 text-sm font-black leading-6"><?php echo $product->get_price_html(); ?></div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		endif;

		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => 'motor-roda-tiga',
				),
			),
			'orderby' => 'rand',
		);
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) :
	?>

	<div class="custom-area px-4 overflow-x-hidden md:px-0">
		<div class="upper grid grid-cols-12 w-full mb-3.5 md:mb-2">
			<h1 class="text-primary-1 text-base font-bold col-span-9 pr-4 md:col-span-10 md:text-2xl">Motor Roda Tiga</h1>
			<div class="text-right col-span-3 md:col-span-2">
				<a href="https://www.jamtangan.com/c/jam-tangan-pria" class="text-neutral-300 text-sm font-bold md:text-base md:leading-8">Lihat Semua</a>
			</div>
		</div>
		<div class="custom-area product-list md:px-0">
			<div class="lower">
				<div class="product-slider mt-5 md:pb-4 md:mt-4">
					<div class="product-slider slick-slider">
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); $product = wc_get_product( get_the_ID() ); ?>
						<div>
							<div class="product h-inherit px-1.5 md:px-2">
								<div class="bg-neutral-900 rounded-2 relative h-full">
									<a href="<?php echo get_the_permalink(); ?>">
										<div class="card product-card-container cursor-pointer bg-neutral-900 rounded-2 relative h-full" style="box-shadow: none;">
											<div class="product-card relative">
												<div class="relative pt-4 px-2 md:px-4">
													<div class="box-img flex items-center">
														<picture><?php echo the_post_thumbnail(); ?></picture>
													</div>
												</div>
												<div class="py-2 px-4 pb-4 mt-4">
													<p class="product-name text-neutral-0 text-sm font-normal leading-6 h-12 mb-1"><?php echo get_the_title(); ?></p>
													<div class="text-primary-1 text-sm font-black leading-6"><?php echo $product->get_price_html(); ?></div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		endif;

		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => 'aksesoris',
				),
			),
			'orderby' => 'rand',
		);
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) :
	?>

	<div class="custom-area px-4 overflow-x-hidden md:px-0">
		<div class="upper grid grid-cols-12 w-full mb-3.5 md:mb-2">
			<h1 class="text-primary-1 text-base font-bold col-span-9 pr-4 md:col-span-10 md:text-2xl">Aksesoris</h1>
			<div class="text-right col-span-3 md:col-span-2">
				<a href="https://www.jamtangan.com/c/jam-tangan-pria" class="text-neutral-300 text-sm font-bold md:text-base md:leading-8">Lihat Semua</a>
			</div>
		</div>
		<div class="custom-area product-list md:px-0">
			<div class="lower">
				<div class="product-slider mt-5 md:pb-4 md:mt-4">
					<div class="product-slider slick-slider">
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); $product = wc_get_product( get_the_ID() ); ?>
						<div>
							<div class="product h-inherit px-1.5 md:px-2">
								<div class="bg-neutral-900 rounded-2 relative h-full">
									<a href="<?php echo get_the_permalink(); ?>">
										<div class="card product-card-container cursor-pointer bg-neutral-900 rounded-2 relative h-full" style="box-shadow: none;">
											<div class="product-card relative">
												<div class="relative pt-4 px-2 md:px-4">
													<div class="box-img flex items-center">
														<picture><?php echo the_post_thumbnail(); ?></picture>
													</div>
												</div>
												<div class="py-2 px-4 pb-4 mt-4">
													<p class="product-name text-neutral-0 text-sm font-normal leading-6 h-12 mb-1"><?php echo get_the_title(); ?></p>
													<div class="text-primary-1 text-sm font-black leading-6"><?php echo $product->get_price_html(); ?></div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php endif; ?>

</div>

<section class="banner-tips rounded-0 w-full px-4 mt-8 mx-auto overflow-x-hidden md:rounded-2 md:max-w-screen-md lg:max-w-screen-lg xl:max-w-screen-xl md:px-0 md:mt-12">
	<a href="#" class="w-full block">
		<picture class="block relative w-full overflow-hidden">
			<img src="https://placehold.co/2272x304" alt="bannerTips" class="w-full rounded-2" loading="lazy">
		</picture>
	</a>
</section>

<section class="social-feed">
	<div class="channel-list mt-8 overflow-x-hidden md:mt-12">
		<div class="upper grid grid-cols-12 w-full px-4 md:px-0">
			<h1 class="text-primary-1 text-base font-bold col-span-9 pr-4 md:text-2xl md:col-span-10">Channel The Biker Shop</h1>
			<div class="text-right col-span-3 md:col-span-2">
				<a href="https://www.youtube.com/@DjokoMotorThebikershop" target="_blank" rel="noopener noreferrer nofollow" class="text-neutral-300 text-sm font-bold md:text-base md:leading-8">Lihat Semua</a>
			</div>
		</div>
		<div class="lower">
			<div class="channel-content mt-5 md:mt-4">
				<div class="channel-slider slick-slider">
					<div>
						<div class="slider-list-item ml-4 md:ml-0">
							<a href="https://www.youtube.com/watch?v=iEfG30VYqN0" target="_blank" rel="noopener noreferrer nofollow">
								<figure class="px-2">
									<picture class="rounded-2 block w-full h-38" style="height: 154px;">
										<img src="https://i.ytimg.com/vi/iEfG30VYqN0/mqdefault.jpg" alt="NEW INCOMING! V16 PLUS | Motor mahal atau motor murah? Eps.3 | The Biker Shop" class="rounded-2 object-cover w-full h-full" loading="lazy">
									</picture>
									<figcaption class="text-neutral-300 text-base font-bold leading-6 mt-3">
										<p>NEW INCOMING! V16 PLUS | Motor mahal atau motor murah? Eps.3 | The Biker Shop</p>
									</figcaption>
								</figure>
							</a>
						</div>
					</div>
					<div>
						<div class="slider-list-item ml-4 md:ml-0">
							<a href="https://www.youtube.com/watch?v=wQqModTDDac" target="_blank" rel="noopener noreferrer nofollow">
								<figure class="px-2">
									<picture class="rounded-2 block w-full h-38" style="height: 154px;">
										<img src="https://i.ytimg.com/vi/wQqModTDDac/mqdefault.jpg" alt="CFMOTO PAPIO XO-1 | Motor mahal atau motor murah? Eps.2 | The Biker Shop" class="rounded-2 object-cover w-full h-full" loading="lazy">
									</picture>
									<figcaption class="text-neutral-300 text-base font-bold leading-6 mt-3">
										<p>CFMOTO PAPIO XO-1 | Motor mahal atau motor murah? Eps.2 | The Biker Shop</p>
									</figcaption>
								</figure>
							</a>
						</div>
					</div>
					<div>
						<div class="slider-list-item ml-4 md:ml-0">
							<a href="https://www.youtube.com/watch?v=M-I1w2lJ8y8" target="_blank" rel="noopener noreferrer nofollow">
								<figure class="px-2">
									<picture class="rounded-2 block w-full h-38" style="height: 154px;">
										<img src="https://i.ytimg.com/vi/M-I1w2lJ8y8/mqdefault.jpg" alt="MOTOR LISTRIK CANGGIH !! | ALVA CERVO | Review motor listrik Eps.1" class="rounded-2 object-cover w-full h-full" loading="lazy">
									</picture>
									<figcaption class="text-neutral-300 text-base font-bold leading-6 mt-3">
										<p>MOTOR LISTRIK CANGGIH !! | ALVA CERVO | Review motor listrik Eps.1</p>
									</figcaption>
								</figure>
							</a>
						</div>
					</div>
					<div>
						<div class="slider-list-item ml-4 md:ml-0">
							<a href="https://www.youtube.com/watch?v=UUz3T8O8Fk8" target="_blank" rel="noopener noreferrer nofollow">
								<figure class="px-2">
									<picture class="rounded-2 block w-full h-38" style="height: 154px;">
										<img src="https://i.ytimg.com/vi/UUz3T8O8Fk8/mqdefault.jpg" alt="MOTOR MATIC 150 CC | Motor mahal atau motor murah? Eps.1 | WMOTO GRETA 150" class="rounded-2 object-cover w-full h-full" loading="lazy">
									</picture>
									<figcaption class="text-neutral-300 text-base font-bold leading-6 mt-3">
										<p>MOTOR MATIC 150 CC | Motor mahal atau motor murah? Eps.1 | WMOTO GRETA 150</p>
									</figcaption>
								</figure>
							</a>
						</div>
					</div>
					<div>
						<div class="slider-list-item ml-4 md:ml-0">
							<a href="https://www.youtube.com/watch?v=EuguECYtO80" target="_blank" rel="noopener noreferrer nofollow">
								<figure class="px-2">
									<picture class="rounded-2 block w-full h-38" style="height: 154px;">
										<img src="https://i.ytimg.com/vi/EuguECYtO80/mqdefault.jpg" alt="TVS CALLISTO ASTRO! | REVIEW SPECIAL EDITION" class="rounded-2 object-cover w-full h-full" loading="lazy">
									</picture>
									<figcaption class="text-neutral-300 text-base font-bold leading-6 mt-3">
										<p>TVS CALLISTO ASTRO! | REVIEW SPECIAL EDITION</p>
									</figcaption>
								</figure>
							</a>
						</div>
					</div>
					<div>
						<div class="slider-list-item ml-4 md:ml-0">
							<a href="https://www.youtube.com/watch?v=VxNBntczn2w&t=130s" target="_blank" rel="noopener noreferrer nofollow">
								<figure class="px-2">
									<picture class="rounded-2 block w-full h-38" style="height: 154px;">
										<img src="https://i.ytimg.com/vi/VxNBntczn2w/mqdefault.jpg" alt="BIKIN MOTOR CUSTOM!! CUSTOM SM V16 INDIAN BOBBER!! 🔥 BIKIN MOTOR CUSTOM Eps.1 | The Biker Shop" class="rounded-2 object-cover w-full h-full" loading="lazy">
									</picture>
									<figcaption class="text-neutral-300 text-base font-bold leading-6 mt-3">
										<p>BIKIN MOTOR CUSTOM!! CUSTOM SM V16 INDIAN BOBBER!! 🔥 BIKIN MOTOR CUSTOM Eps.1 | The Biker Shop</p>
									</figcaption>
								</figure>
							</a>
						</div>
					</div>
					<div>
						<div class="slider-list-item ml-4 md:ml-0">
							<a href="https://www.youtube.com/watch?v=94EbVrnzu8I" target="_blank" rel="noopener noreferrer nofollow">
								<figure class="px-2">
									<picture class="rounded-2 block w-full h-38" style="height: 154px;">
										<img src="https://i.ytimg.com/vi/94EbVrnzu8I/mqdefault.jpg" alt="TVS KING PENUMPANG/THE BIKER SHOP NIAGA Eps.2" class="rounded-2 object-cover w-full h-full" loading="lazy">
									</picture>
									<figcaption class="text-neutral-300 text-base font-bold leading-6 mt-3">
										<p>TVS KING PENUMPANG/THE BIKER SHOP NIAGA Eps.2</p>
									</figcaption>
								</figure>
							</a>
						</div>
					</div>
					<div>
						<div class="slider-list-item ml-4 md:ml-0">
							<a href="https://www.youtube.com/watch?v=ECMum9seUEE" target="_blank" rel="noopener noreferrer nofollow">
								<figure class="px-2">
									<picture class="rounded-2 block w-full h-38" style="height: 154px;">
										<img src="https://i.ytimg.com/vi/ECMum9seUEE/mqdefault.jpg" alt="CUB CLASSIC CUSTOM SESPAN| REVIEW MOTOR CUSTOM Eps.5 | SM Classic" class="rounded-2 object-cover w-full h-full" loading="lazy">
									</picture>
									<figcaption class="text-neutral-300 text-base font-bold leading-6 mt-3">
										<p>CUB CLASSIC CUSTOM SESPAN| REVIEW MOTOR CUSTOM Eps.5 | SM Classic</p>
									</figcaption>
								</figure>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="lower">
			<hr class="border-t-2 border-neutral-900 mt-8 md:mt-12">
		</div>
	</div>
</section>

<?php
$args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
    'posts_per_page' => 4,
    'orderby' => 'date',
    'order' => 'DESC'
);
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) :
?>
<section class="blog-feed">
	<div class="blog-list px-4 mt-8 overflow-x-hidden md:px-0 md:mt-12">
		<div class="upper grid grid-cols-12 w-full">
			<h1 class="text-primary-1 text-base font-bold col-span-9 pr-4 md:text-2xl md:col-span-10">Blog The Biker Shop</h1>
			<div class="text-right col-span-3 md:col-span-2">
				<a href="https://blog.jamtangan.com/" target="_blank" rel="noopener noreferrer nofollow" class="text-neutral-300 text-sm font-bold md:text-base md:leading-8">Lihat Semua</a>
			</div>
		</div>
		<div class="lower">
			<div class="blog-content px-0">
				<div class="blog-slider grid grid-cols-12">
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); $categories = get_the_category(); ?>
					<div class="list-item col-span-12 mt-4 md:col-span-6">
						<a href="<?php the_permalink() ?>" target="_blank" rel="noopener noreferrer nofollow">
							<figure class="flex md:px-2">
								<picture class="rounded-2 block w-full h-38" style="min-width: 224px; width: 1px; height: 140px;">
									<img src="<?php echo get_the_post_thumbnail_url($the_query->ID, 'full') ?>" alt="<?php echo the_title(); ?>" class="rounded-2 object-cover w-full h-full" loading="lazy">
								</picture>
								<figcaption class="text-neutral-300 text-sm font-bold leading-5 pl-2 md:text-base md:leading-6 md:pl-4">
									<div class="flex items-center justify-between md:block md:mt-3">
										<p class="text-primary-1 text-xs leading-5"><?php echo esc_html( $categories[0]->name ) ?></p>
									</div>
									<p class="md:mt-1"><?php echo the_title(); ?></p>
									<p class="text-neutral-500 text-xxs font-normal leading-4 tracking-wide md:text-xs md:leading-5 md:mt-1"><?php echo get_the_date(); ?></p>
								</figcaption>
							</figure>
						</a>
					</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
		<div class="lower">
			<hr class="border-t-2 border-neutral-900 mt-8 md:mt-12">
		</div>
	</div>
</section>

<?php
endif;

get_footer();
