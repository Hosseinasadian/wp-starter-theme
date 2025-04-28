<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Starter-theme
 */

if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
	return;
}
?>

<aside id="alm-product-archive-aside" class="alm-archive-aside alm-product-archive-aside">
	<?php dynamic_sidebar( 'shop-sidebar' ); ?>
</aside>
