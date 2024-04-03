<?php

/**
 * Product quantity inputs.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

?>

	<div class="mt-2">
		<div class="flex items-center">
			<div class="stepper-wrapper flex">
				<button class="minus-wrapper btn btn-sm btn-ghost btn-ghost-grey btn-disabled bg-transparent border-1 border-solid border-neutral-700 rounded rounded-l-1 rounded-r-0 text-neutral-700 text-sm relative w-9 h-9 pt-1 overflow-hidden">
					<span class="di-minus text-neutral-600"></span>
				</button>
				<input
					type="number"
					id="<?php echo esc_attr( $input_id ); ?>"
					class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
					name="<?php echo esc_attr( $input_name ); ?>"
					value="<?php echo esc_attr( $input_value ); ?>"
					readonly
				/>
				<button class="plus-wrapper btn btn-sm btn-ghost btn-ghost-grey bg-transparent border-1 border-solid border-neutral-500 rounded rounded-l-0 rounded-r-1 text-neutral-500 text-sm relative w-9 h-9 pt-1 overflow-hidden">
					<span class="di-plus text-neutral-100"></span>
				</button>
			</div>
		</div>
	</div>

