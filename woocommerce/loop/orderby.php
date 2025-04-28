<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="alm-archive-sort">
	<form class="woocommerce-ordering alm-archive-sort-form" method="get">
		<input type="hidden" name="paged" value="1"/>

		<button class="alm-archive-sort-button" type="button">
			<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
				<path d="M3.81055 7H21.8105" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M6.81055 12H18.8105" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M10.8105 17H14.8105" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
			<?php esc_html_e('مرتب سازی','alma')?>
		</button>

		<select name="orderby" class="orderby alm-archive-sort-select" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>

		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
	</form>
</div>
