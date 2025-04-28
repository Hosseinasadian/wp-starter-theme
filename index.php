<?php
get_header();

?>

<div class="alm-post-wrapper">

<main id="primary" class="site-main">

<?php

if(!is_front_page()){
	alm_enabled_breadcrumb() && alm_breadcrumb();
}


if ( is_archive() || is_home() || is_search() ) {
	// Elementor `archive` location
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
		get_template_part( 'template-parts/archive' );
	}
} elseif ( is_singular() ) {
	// Elementor `single` location
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
		get_template_part( 'template-parts/single' );
	}
} else {
	// Elementor `404` location
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( '404' ) ) {
		get_template_part( 'template-parts/404' );
	}
}

?>

</main>

</div>

<?php

get_footer();
