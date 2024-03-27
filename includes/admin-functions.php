<?php

/**
 * Custom functions for Admin.
 *
 * @package DOTS. Elementor
 * @since 1.0
 */

// Disable Gutenberg.
add_filter( 'use_block_editor_for_post', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
