<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Starter-theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<div class="alm-comments-list-header">
			<h2 class="comments-title"><?php esc_html_e('دیدگاه ها','alma')?></h2>
			<h3 class="comments-description">
				<?php
				$starter_theme_comment_count = get_comments_number();

				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html__('%1$s نظر در مورد &ldquo;%2$s&rdquo;','alma'),
					number_format_i18n( $starter_theme_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
				?>
			</h2><!-- .comments-title -->
		</div>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ul',
					'short_ping' => true,
					'avatar_size' => 57,
					'callback' => 'alm_comments_callback',
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'starter-theme' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	$submit_button_icon = '<svg width="35" height="28" viewBox="0 0 35 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M22.5973 26.3384C29.0114 26.3384 34.2111 20.9658 34.2111 14.3384C34.2111 7.71096 29.0114 2.33838 22.5973 2.33838C16.1831 2.33838 10.9834 7.71096 10.9834 14.3384C10.9834 20.9658 16.1831 26.3384 22.5973 26.3384Z" fill="white" fill-opacity="0.2"/>
<path d="M14.3496 25.6717C20.8567 25.6717 26.1317 20.4484 26.1317 14.005C26.1317 7.56172 20.8567 2.33838 14.3496 2.33838C7.84244 2.33838 2.56738 7.56172 2.56738 14.005C2.56738 20.4484 7.84244 25.6717 14.3496 25.6717Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M18.4736 14.0049H11.4043" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M13.7602 10.5049L10.2256 14.0049L13.7602 17.5049" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';

	$comment_field = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

 	$submit_field = '<div class="comment-field-wrapper">'.$comment_field.'<div class="form-submit">%1$s %2$s</div></div>';

	comment_form([
		'submit_button'=>'<span class="alm-submit-button"><input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />' . $submit_button_icon . '</span>',
		'comment_field'=>'',
		'submit_field'=>$submit_field,

	]);

// 	comment_form([
//         'fields' => [
//             'author' => '<div class="comment-form-row comment-form-author"><div class="input-append"><input placeholder="' . __('نام:', 'pezeshkyar') . '" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . 'aria-required="true"' . ' required /><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
//   <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#5C91C7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
// </svg></div></div>',
//             'email' => '<div class="comment-form-row comment-form-email"><div class="input-append"><input placeholder="' . __('آدرس ایمیل:', 'pezeshkyar') . '" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . 'aria-required="true"' . ' required /><i data-feather="mail"></i></div></div>',
//         ],
//         'comment_field' => '<div class="comment-form-comment"><textarea id="comment" name="comment" class="span12" rows="5" aria-required="true"></textarea></div>',
//         'submit_field' => '<div class="comment-form-submit-box"><div class="pzy-rate-box"><span class="pzy-rate-title">' . __('امتیاز شما', 'pezeshkyar') . '</span>' . $rating_text . '</div><p class="form-submit">%1$s %2$s</p></div>',
//         'title_reply' => __('دیدگاه شما', 'pezeshkyar'),
//         'title_reply_after' => '<p class="title_reply_after"></p></span>',
//     ]);
	?>

</div><!-- #comments -->
