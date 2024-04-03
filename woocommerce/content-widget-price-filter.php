<?php

/**
 * The template for displaying product price filter widget.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

do_action( 'woocommerce_widget_price_filter_start', $args );

?>

<div class="text-neutral-100 px-4 mt-3 mb-2">
	<form action="<?php echo esc_url( $form_action ); ?>" method="get">
		<div id="input-price" class="flex items-center">
			<fieldset class="text-input price-range border-none relative p-0">
				<div class="wrap no-label bg-neutral-800 border-1 border-solid border-neutral-700 rounded leading-0 flex items-center h-13 p-4 pl-4 pr-4">
					<div class="w-full"><input type="text" class="bg-transparent border-none text-neutral-100 placeholder-neutral-500 text-xs tracking-wide relative w-full h-10 pt-6 pb-2" name="min_price" placeholder="<?php echo esc_attr__( 'Min', 'dots-elementor' ); ?>" value="<?php echo esc_attr( $current_min_price ); ?>" data-min="<?php echo esc_attr( $min_price ); ?>"></div>
					<div class="flex justify-between items-start gap-1"></div>
				</div>
			</fieldset>
			<div class="px-1">-</div>
			<fieldset class="text-input price-range border-none relative p-0">
				<div class="wrap no-label bg-neutral-800 border-1 border-solid border-neutral-700 rounded leading-0 flex items-center h-13 p-4 pl-4 pr-4">
					<div class="w-full"><input type="text" class="bg-transparent border-none text-neutral-100 placeholder-neutral-500 text-xs tracking-wide relative w-full h-10 pt-6 pb-2" name="max_price" placeholder="<?php echo esc_attr__( 'Max', 'dots-elementor' ); ?>" value="<?php echo esc_attr( $current_max_price ); ?>" data-max="<?php echo esc_attr( $max_price ); ?>"></div>
					<div class="flex justify-between items-start gap-1"></div>
				</div>
			</fieldset>
		</div>
		<p class="mt-1 mb-3"></p>
		<button type="submit" class="price-range-btn bg-primary-1 btn btn-sm btn-filled rounded text-neutral-1000 text-sm font-bold tracking-wider relative overflow-hidden w-full" style="font-size: 12px;"><?php echo esc_html__( 'Terapkan', 'woocommerce' ); ?></button>
	</form>
</div>

<?php

do_action( 'woocommerce_widget_price_filter_end', $args );
