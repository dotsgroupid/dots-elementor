<?php
/**
 * Shop breadcrumb.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

if ( ! empty( $breadcrumb ) ) {

?>

<nav class="qa-breadcrumb hidden lg:inline-block mt-6" aria-label="Breadcrumb">
	<ul class="text-neutral-600 text-xs font-bold flex gap-1">

	<?php foreach ( $breadcrumb as $key => $crumb ) { ?>
		<?php if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) { ?>
			<li>
				<a href="<?php echo esc_url( $crumb[1] ) ?>"><?php echo esc_html( $crumb[0] ) ?></a>
			</li>
		<?php } else { ?>
			<li class="flex gap-1 items-center">
				<span class="di-chevron-right"></span>
				<a href="<?php echo esc_url( $crumb[1] ) ?>"><?php echo esc_html( $crumb[0] ) ?></a>
			</li>
		<?php } ?>
	<?php } ?>

	</ul>
</nav>

<?php
}
