<?php

/**
 * Shop breadcrumb.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

if ( ! empty( $breadcrumb ) ) {

	echo '<nav class="hidden my-6 md:block" aria-label="breadcrumbs">
		<ul class="text-neutral-600 text-xs font-bold leading-4 flex gap-1">';

	foreach ( $breadcrumb as $key => $crumb ) {

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			if ( $key == 0 ) {
				echo '<li>
					<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>
				</li>';
			} else {
				echo '<li class="flex gap-1 items-center">
					<span class="di-chevron-right"></span>
					<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>
				</li>';
			}
		} else {
			echo '<li class="flex gap-1 items-center">
				<span class="di-chevron-right"></span>
				<span class="text-neutral-300">' . esc_html( $crumb[0] ) . '</span>
			</li>';
		}

	}

	echo '</ul>
	</nav>';
}
