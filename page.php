<?php
get_header();

$elementor_page = alm_elementor_enabled() && (bool)get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

?>

<div class="alm-post-wrapper">

<?php


// Elementor `single` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	if(!$elementor_page){

	?>
		<div class="alm-content">
			<?php
	}

	if(!is_front_page()){
		alm_enabled_breadcrumb() && alm_breadcrumb();
	}

	get_template_part( 'template-parts/single' );

	if(!$elementor_page){
			?>
		</div>
	<?php
	}
}

?>

</div>

<?php

get_footer();
