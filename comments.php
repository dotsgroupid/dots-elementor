<?php
/**
 * The template for displaying comments.
 *
 * @package DOTS. Elementor
 * @since 1.1.0
 */

if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
	return;
}

if ( ! have_comments() && ! comments_open() ) {
	return;
}

// Comment Reply Script.
if ( comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

?>

<section id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="title-comments">
			<?php
				$comments_number = get_comments_number();

				if ( '1' === $comments_number ) {
					printf( esc_html_x( 'One Response', 'comments title', 'dots-elementor' ) );
				} else {
					printf(
						esc_html(
							_nx(
								'%1$s Response',
								'%1$s Responses',
								$comments_number,
								'comments title',
								'hello-elementor'
							)
						),
						esc_html( number_format_i18n( $comments_number ) )
					);
				}
			?>
		</h3>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments(
					[
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 42,
					],
				);
			?>
		</ol>

<?php
		the_comments_navigation();

	endif;

comment_form(
	[
		'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</h2>',
	],
);

?>

</section>
