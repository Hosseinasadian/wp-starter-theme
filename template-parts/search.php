<?php
	$post_type = get_post_type();

	echo "<div class='alm-archive alm-archive-$post_type'>";

	get_sidebar();

	echo "<div class='alm-archive-main'>";

	$sort_options = alm_blog_order_options();
?>

<div class="alm-archive-header">
	<h1 class="alm-archive-title"><?php printf( esc_html__( 'نتایج جست و جو برای: %s', 'alma' ), '<span>' . get_search_query() . '</span>' );?></h1>
	<?php if(have_posts()) alm_ordering_form($sort_options)?>
</div>

<div class="alm-archive-body">
	<?php if ( have_posts() ) : ?>

		<div class="alm-archive-posts">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/loop', $post_type );

			endwhile;
			?>
		</div>
		<?php
			$pagination = paginate_links(array('echo' => false));

			if (!empty($pagination)) {
				echo '<div class="alm-archive-pagination">' . $pagination . '</div>';
			}
		?>
	<?php else:?>

		<div class="alm-empty-archive"><?php esc_html_e("مطلبی برای نمایش پیدا نشد",'alma')?></div>

	<?php endif;?>

</div>
<?php

echo "</div>";

echo "</div>";
