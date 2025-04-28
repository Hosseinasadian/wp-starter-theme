<?php
while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content', get_post_type() );

	?>
		<div class="post-other-content">
	<?php

	$post_type = get_post_type();

	$blog_after_content = alm_get_option('blog_after_content');

	if($blog_after_content && in_array($post_type,['post'])){
		try{
			echo "<div class='alm-post-after-content'>";
			alm_load_elementor_template($blog_after_content);
			echo "</div>";
		}catch(Exception $e){

		}
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

	?>
		</div>
	<?php

endwhile; // End of the loop.
?>
