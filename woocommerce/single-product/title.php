<?php
/**
 * Single Product title.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

global $product;

$terms = get_the_terms( $product->get_id(), 'product_brand' );

?>

	<section class="product-title pt-4 mx-4 md:pt-0 md:mx-0">
		<?php if ( ! empty( $terms ) ) { ?>
		<a href="<?php echo esc_url( get_term_link( $terms[0] ), 'product_brand' ); ?>" class="series font-black text-lg inline-block mb-2 md:text-xl">
			<?php echo esc_html( $terms[0]->name ); ?>
		</a>
		<?php } ?>
		<div class="title">
			<?php the_title( '<h1 class="text-neutral-100 font-medium pb-2.5 md:text-xl md:pb-0">', '</h1>' ); ?>
		</div>
	</section>
