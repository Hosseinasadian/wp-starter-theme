<?php
get_header();

?>

<div class="alm-post-wrapper">

<?php

// Elementor `single` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	get_template_part( 'template-parts/404' );
}

?>

</div>

<?php

get_footer();
