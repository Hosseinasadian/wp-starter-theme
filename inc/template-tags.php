<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Starter-theme
 */

 function alm_post_metas(){
	$post_date_meta_enabled = alm_get_option('post_date_meta_enabled');
	$post_date_comments_count_enabled = alm_get_option('post_date_comments_count_enabled');
	$post_date_author_enabled = alm_get_option('post_date_author_enabled');

	if($post_date_meta_enabled || $post_date_comments_count_enabled || $post_date_author_enabled){

		?>
		<div class="entry-meta">
			<?php if($post_date_meta_enabled):?>
				<div class="alm-post-meta-item">
				<svg class="alm-post-meta-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
					<path d="M6 1.5V3.75" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M12 1.5V3.75" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M2.625 6.8175H15.375" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M15.75 6.375V12.75C15.75 15 14.625 16.5 12 16.5H6C3.375 16.5 2.25 15 2.25 12.75V6.375C2.25 4.125 3.375 2.625 6 2.625H12C14.625 2.625 15.75 4.125 15.75 6.375Z" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M11.7713 10.275H11.778" stroke="#F5683C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M11.7713 12.525H11.778" stroke="#F5683C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M8.99686 10.275H9.00359" stroke="#F5683C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M8.99686 12.525H9.00359" stroke="#F5683C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M6.22049 10.275H6.22723" stroke="#F5683C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M6.22049 12.525H6.22723" stroke="#F5683C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<?php echo get_the_date('Y/m/d') ?>
				</div>
			<?php endif;?>
			<?php if($post_date_comments_count_enabled):?>
				<div class="alm-post-meta-item">
				<svg class="alm-post-meta-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  					<path d="M6.375 7.875H11.625" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M5.25 13.8225H8.25L11.5875 16.0425C12.0825 16.3725 12.75 16.02 12.75 15.42V13.8225C15 13.8225 16.5 12.3225 16.5 10.0725V5.57251C16.5 3.32251 15 1.82251 12.75 1.82251H5.25C3 1.82251 1.5 3.32251 1.5 5.57251V10.0725C1.5 12.3225 3 13.8225 5.25 13.8225Z" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<?php comments_number() ?>
				</div>
			<?php endif;?>
			<?php if($post_date_author_enabled):?>
				<div class="alm-post-meta-item">
				<svg class="alm-post-meta-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
					<path d="M9 9C11.0711 9 12.75 7.32107 12.75 5.25C12.75 3.17893 11.0711 1.5 9 1.5C6.92893 1.5 5.25 3.17893 5.25 5.25C5.25 7.32107 6.92893 9 9 9Z" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M14.4073 11.805L11.7523 14.46C11.6473 14.565 11.5498 14.76 11.5273 14.9025L11.3848 15.915C11.3323 16.2825 11.5873 16.5375 11.9548 16.485L12.9673 16.3425C13.1098 16.32 13.3123 16.2225 13.4098 16.1175L16.0648 13.4625C16.5223 13.005 16.7398 12.4725 16.0648 11.7975C15.3973 11.13 14.8648 11.3475 14.4073 11.805Z" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M14.0244 12.1875C14.2494 12.9975 14.8794 13.6275 15.6894 13.8525" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M2.55762 16.5C2.55762 13.5975 5.44514 11.25 9.00014 11.25C9.78014 11.25 10.5301 11.3625 11.2276 11.5725" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<?php the_author_posts_link(); ?>
				</div>
			<?php endif;?>
		</div>
		<?php

	}
 }

if ( ! function_exists( 'starter_theme_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function starter_theme_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'starter-theme' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'starter_theme_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function starter_theme_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'starter-theme' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'starter_theme_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function starter_theme_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'starter-theme' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'starter-theme' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'starter-theme' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'starter-theme' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'starter-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'starter-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'starter_theme_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function starter_theme_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
