<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Starter-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php starter_theme_post_thumbnail(); ?>

	<?php
		$post_date_before_social_enabled = alm_get_option('post_date_before_social_enabled');
		$post_like_after_social_enabled = alm_is_enable_filter_posts_by_point() && alm_get_option('post_like_after_social_enabled');
		$post_share_socials = alm_post_share_socials();

		$show_post_aside = false;

		if($post_date_before_social_enabled || $post_like_after_social_enabled || $post_share_socials){
			$show_post_aside = true;
		}

	?>

	<div class="alm-post-body">
		<div class="alm-post-body-main">
			<header class="entry-header">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				if ( 'post' === get_post_type() ) :
						alm_post_metas();
				endif;
				?>
			</header>

			<div class="entry-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'starter-theme' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);
				?>
			</div>

			<footer class="entry-footer"></footer>
		</div>
		<?php if($show_post_aside):?>
			<div class="alm-post-body-aside">
				<div class="alm-post-date-socials-like">
					<?php if($post_date_before_social_enabled):?>
					<p class="alm-post-date"><?php echo get_the_date('Y/m/d') ?></p>
					<?php endif;?>

					<div class="alm-post-socials-like">
						<?php echo $post_share_socials;?>
						<?php
						if($post_like_after_social_enabled)
							echo do_shortcode('[posts_like_dislike]');
						?>
					</div>
				</div>
			</div>
		<?php endif;?>
	</div>
</article>
