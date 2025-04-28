<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>

<hr class='alm-woocommerce-after-order-review-divider'>

<section class="woocommerce-customer-details">

	<section class="alm-woocommerce-order-review__addresses">
		<div class="alm-woocommerce-order-review__address alm-woocommerce-billing-address">

			<h2 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>

			<div class="alm-woocommerce-order-review__address-box">

				<div class="alm-woocommerce-order-review__address-icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M12.0009 13.4299C13.724 13.4299 15.1209 12.0331 15.1209 10.3099C15.1209 8.58681 13.724 7.18994 12.0009 7.18994C10.2777 7.18994 8.88086 8.58681 8.88086 10.3099C8.88086 12.0331 10.2777 13.4299 12.0009 13.4299Z" stroke="#373254" stroke-width="1.5"/>
						<path d="M3.61971 8.49C5.58971 -0.169998 18.4197 -0.159997 20.3797 8.5C21.5297 13.58 18.3697 17.88 15.5997 20.54C13.5897 22.48 10.4097 22.48 8.38971 20.54C5.62971 17.88 2.46971 13.57 3.61971 8.49Z" stroke="#373254" stroke-width="1.5"/>
					</svg>
				</div>

				<address>
					<p class="woocommerce-customer-address-text">
						<?php
							$address_output = wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) );
							$address_parts = array_filter(array_map('trim', explode('<br />', $address_output)));
							$address_string = implode('- ', $address_parts);
							echo $address_string;
						?>
					</p>

					<?php if ( $order->get_billing_phone() ) : ?>
						<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
					<?php endif; ?>

					<?php if ( $order->get_billing_email() ) : ?>
						<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
					<?php endif; ?>

					<?php
						/**
						 * Action hook fired after an address in the order customer details.
						 *
						 * @since 8.7.0
						 * @param string $address_type Type of address (billing or shipping).
						 * @param WC_Order $order Order object.
						 */
						do_action( 'woocommerce_order_details_after_customer_address', 'billing', $order );
					?>
				</address>

			</div>
		</div>

		<?php if ( $show_shipping ) : ?>

			<div class="alm-woocommerce-order-review__address alm-woocommerce-shipping-address">
				<h2 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>

				<div class="alm-woocommerce-order-review__address-box">

					<div class="alm-woocommerce-order-review__address-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M11.9998 14H12.9998C14.0998 14 14.9998 13.1 14.9998 12V2H5.99976C4.49976 2 3.18977 2.82999 2.50977 4.04999" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 17C2 18.66 3.34 20 5 20H6C6 18.9 6.9 18 8 18C9.1 18 10 18.9 10 20H14C14 18.9 14.9 18 16 18C17.1 18 18 18.9 18 20H19C20.66 20 22 18.66 22 17V14H19C18.45 14 18 13.55 18 13V10C18 9.45 18.45 9 19 9H20.29L18.58 6.01001C18.22 5.39001 17.56 5 16.84 5H15V12C15 13.1 14.1 14 13 14H12" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M8 22C9.10457 22 10 21.1046 10 20C10 18.8954 9.10457 18 8 18C6.89543 18 6 18.8954 6 20C6 21.1046 6.89543 22 8 22Z" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M16 22C17.1046 22 18 21.1046 18 20C18 18.8954 17.1046 18 16 18C14.8954 18 14 18.8954 14 20C14 21.1046 14.8954 22 16 22Z" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M22 12V14H19C18.45 14 18 13.55 18 13V10C18 9.45 18.45 9 19 9H20.29L22 12Z" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 8H8" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 11H6" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 14H4" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>

					<address>

						<p class="woocommerce-customer-address-text">
							<?php
								$address_output = wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) );
								$address_parts = array_filter(array_map('trim', explode('<br />', $address_output)));
								$address_string = implode('- ', $address_parts);
								echo $address_string;
							?>
						</p>

						<?php if ( $order->get_shipping_phone() ) : ?>
							<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_shipping_phone() ); ?></p>
						<?php endif; ?>

						<?php
							/**
							 * Action hook fired after an address in the order customer details.
							 *
							 * @since 8.7.0
							 * @param string $address_type Type of address (billing or shipping).
							 * @param WC_Order $order Order object.
							 */
							do_action( 'woocommerce_order_details_after_customer_address', 'shipping', $order );
						?>
					</address>
				</div>

			</div>

		<?php endif; ?>

	</section>


	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
