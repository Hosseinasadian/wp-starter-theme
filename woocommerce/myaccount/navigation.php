<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$icons = [
	'dashboard'=>'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
<path d="M16.5 6.39V2.985C16.5 1.9275 16.02 1.5 14.8275 1.5H11.7975C10.605 1.5 10.125 1.9275 10.125 2.985V6.3825C10.125 7.4475 10.605 7.8675 11.7975 7.8675H14.8275C16.02 7.875 16.5 7.4475 16.5 6.39Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M16.5 14.8275V11.7975C16.5 10.605 16.02 10.125 14.8275 10.125H11.7975C10.605 10.125 10.125 10.605 10.125 11.7975V14.8275C10.125 16.02 10.605 16.5 11.7975 16.5H14.8275C16.02 16.5 16.5 16.02 16.5 14.8275Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M7.875 6.39V2.985C7.875 1.9275 7.395 1.5 6.2025 1.5H3.1725C1.98 1.5 1.5 1.9275 1.5 2.985V6.3825C1.5 7.4475 1.98 7.8675 3.1725 7.8675H6.2025C7.395 7.875 7.875 7.4475 7.875 6.39Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M7.875 14.8275V11.7975C7.875 10.605 7.395 10.125 6.2025 10.125H3.1725C1.98 10.125 1.5 10.605 1.5 11.7975V14.8275C1.5 16.02 1.98 16.5 3.1725 16.5H6.2025C7.395 16.5 7.875 16.02 7.875 14.8275Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	'orders'=>'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
<path d="M6 9.15H11.25" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 12.15H9.285" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M7.5 4.5H10.5C12 4.5 12 3.75 12 3C12 1.5 11.25 1.5 10.5 1.5H7.5C6.75 1.5 6 1.5 6 3C6 4.5 6.75 4.5 7.5 4.5Z" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12 3.015C14.4975 3.15 15.75 4.0725 15.75 7.5V12C15.75 15 15 16.5 11.25 16.5H6.75C3 16.5 2.25 15 2.25 12V7.5C2.25 4.08 3.5025 3.15 6 3.015" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	'downloads'=>'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
<path d="M6.75 8.25V12.75L8.25 11.25" stroke="#373254" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6.75 12.75L5.25 11.25" stroke="#373254" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M16.5 7.5V11.25C16.5 15 15 16.5 11.25 16.5H6.75C3 16.5 1.5 15 1.5 11.25V6.75C1.5 3 3 1.5 6.75 1.5H10.5" stroke="#373254" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M16.5 7.5H13.5C11.25 7.5 10.5 6.75 10.5 4.5V1.5L16.5 7.5Z" stroke="#373254" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	'edit-address'=>'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
<path d="M9.00016 10.0725C10.2925 10.0725 11.3402 9.02483 11.3402 7.73249C11.3402 6.44014 10.2925 5.39249 9.00016 5.39249C7.70781 5.39249 6.66016 6.44014 6.66016 7.73249C6.66016 9.02483 7.70781 10.0725 9.00016 10.0725Z" stroke="#373254"/>
<path d="M2.71527 6.3675C4.19277 -0.127498 13.8153 -0.119998 15.2853 6.375C16.1478 10.185 13.7778 13.41 11.7003 15.405C10.1928 16.86 7.80777 16.86 6.29277 15.405C4.22277 13.41 1.85277 10.1775 2.71527 6.3675Z" stroke="#373254"/>
</svg>',
	'edit-account'=>'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
<path d="M6 1.5V3.75" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12 1.5V3.75" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.25 8.25H11.25" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.25 11.25H9" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M11.25 16.5H6.75C3 16.5 2.25 14.955 2.25 11.865V7.2375C2.25 3.7125 3.5025 2.7675 6 2.625H12C14.4975 2.76 15.75 3.7125 15.75 7.2375V12" stroke="#373254" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15.75 12L11.25 16.5V14.25C11.25 12.75 12 12 13.5 12H15.75Z" stroke="#373254" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	'customer-logout'=>'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
<path d="M6.6748 5.66999C6.9073 2.96999 8.2948 1.86749 11.3323 1.86749H11.4298C14.7823 1.86749 16.1248 3.20999 16.1248 6.56249V11.4525C16.1248 14.805 14.7823 16.1475 11.4298 16.1475H11.3323C8.3173 16.1475 6.9298 15.06 6.6823 12.405" stroke="#373254" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M11.2498 9H2.71484" stroke="#373254" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M4.3875 6.48749L1.875 8.99999L4.3875 11.5125" stroke="#373254" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
];
$icons = apply_filters('alm_woocommerce_account_menu_item_icon',$icons);

?>

<nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>>
					<?php if(isset($icons[$endpoint])):?>
						<?php echo alm_safe_svg($icons[$endpoint])?>
					<?php endif;?>
					<?php echo esc_html( $label ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
