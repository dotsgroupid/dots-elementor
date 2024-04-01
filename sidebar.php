<?php

/**
 * The template for displaying the sidebar.
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

if ( is_active_sidebar( 'main-sidebar' ) ) {

?>

<div id="product-list" class="product-list-filter bg-neutral-900 rounded-2 py-4" style="position: sticky; width: 212px; top: 8rem;">
	<?php dynamic_sidebar('main-sidebar'); ?>
</div>

<?php

}
