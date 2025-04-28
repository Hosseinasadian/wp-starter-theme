<?php
/**
 * Downloads
 *
 * Shows downloads on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/downloads.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$downloads     = WC()->customer->get_downloadable_products();
$has_downloads = (bool) $downloads;

do_action( 'woocommerce_before_account_downloads', $has_downloads ); ?>

<?php if ( $has_downloads ) : ?>

	<?php do_action( 'woocommerce_before_available_downloads' ); ?>

	<?php do_action( 'woocommerce_available_downloads', $downloads ); ?>

	<?php do_action( 'woocommerce_after_available_downloads' ); ?>

<?php else : ?>

	<?php
		$wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
	?>

	<div class="alm-account-empty-downloads">
		<span class="alm-account-empty-downloads-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" fill="none">
				<path d="M45 55V85L55 75" stroke="#F5683C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M45 85L35 75" stroke="#F5683C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M110 50V75C110 100 100 110 75 110H45C20 110 10 100 10 75V45C10 20 20 10 45 10H70" stroke="#F5683C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M110 50H90C75 50 70 45 70 30V10L110 50Z" stroke="#F5683C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</span>
		<span class="alm-account-empty-downloads-message"><?php esc_html_e( 'No downloads available yet.', 'woocommerce' )?></span>
		<?php
			echo ' <a class="button wc-forward' . esc_attr( $wp_button_class ) . '" href="' . esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ) . '">' . esc_html__( 'Browse products', 'woocommerce' ) . '</a>'; // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
		?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_downloads', $has_downloads ); ?>
