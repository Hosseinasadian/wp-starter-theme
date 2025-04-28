<?php
get_header();

?>

<div class="alm-post-wrapper">

<?php

// Elementor `archive` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
	?>
		<div class="alm-content">
			<?php

			alm_enabled_breadcrumb() && alm_breadcrumb();
			get_template_part( 'template-parts/archive' );
			?>
		</div>
	<?php
}

?>

</div>

<?php

get_footer();
