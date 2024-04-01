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

<div id="sidebar" class="product-list-filter filter-desktop scrollbar-transparent bg-neutral-900 rounded-2 py-4 overflow-y-auto" style="position: sticky; width: 212px; top: 8rem;">
	<?php dynamic_sidebar('main-sidebar'); ?>
</div>

<?php

}
