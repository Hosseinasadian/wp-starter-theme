<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Starter-theme
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}
?>

<aside id="alm-archive-aside" class="alm-archive-aside">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside>
