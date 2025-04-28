<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
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

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="alm-woocommerce-myaccount-addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php
		$address_fields = [];

		if($name == 'billing')
			$address_fields = WC()->customer->get_billing();
		elseif($name == 'shipping')
			$address_fields = WC()->customer->get_shipping();


	?>

	<div class="alm-woocommerce-myaccount-address">
		<header>
			<h3 class="alm-woocommerce-myaccount-address-title">
				<?php if($name == 'billing'):?>
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M12.0009 13.4299C13.724 13.4299 15.1209 12.0331 15.1209 10.3099C15.1209 8.58681 13.724 7.18994 12.0009 7.18994C10.2777 7.18994 8.88086 8.58681 8.88086 10.3099C8.88086 12.0331 10.2777 13.4299 12.0009 13.4299Z" stroke="#373254" stroke-width="1.5"/>
						<path d="M3.61971 8.49C5.58971 -0.169998 18.4197 -0.159997 20.3797 8.5C21.5297 13.58 18.3697 17.88 15.5997 20.54C13.5897 22.48 10.4097 22.48 8.38971 20.54C5.62971 17.88 2.46971 13.57 3.61971 8.49Z" stroke="#373254" stroke-width="1.5"/>
					</svg>
				<?php elseif($name == 'shipping'):?>
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
				<?php endif;?>
				<?php echo esc_html( $address_title ); ?>
			</h3>
			<?php
				$add_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <path d="M4.5 9H13.5" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M9 13.5V4.5" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';
				$edit_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <path d="M4.5 9H13.5" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M9 13.5V4.5" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';
$address = wc_get_account_formatted_address( $name );
$address_output = wp_kses_post( $address );
			?>
			<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php echo $address ? ($edit_icon . esc_html__( 'Edit', 'woocommerce' )) : ($add_icon . esc_html__( 'Add', 'woocommerce' )); ?></a>
		</header>
		<?php
			ob_start();
		?>

			<?php
			if($address_output){
				$first_name = $address_fields['first_name']??'';
				$last_name = $address_fields['last_name']??'';

				$full_name = '';
				if($first_name){
					$full_name .= $first_name;
				}
				if($last_name){
					$full_name .= " $last_name";
				}

				if($full_name){
					echo "<p class='alm-woocommerce-myaccount-address-fullname'>$full_name</p>";
				}

				// var_dump($address_fields);

				$country = $address_fields['country'] ?? '';
				$states = WC()->countries->get_states($country);

				$filtered_address = [
					'state'     => (isset($address_fields['state']) && isset($states[$address_fields['state']])) ? $states[$address_fields['state']]: '',
					'city'      => $address_fields['city'] ?? '',
					'address_1' => $address_fields['address_1'] ?? '',
					'address_2' => $address_fields['address_2'] ?? '',
				];

				// Convert filtered address array to a formatted string
				$address_only = implode(', ', array_filter($filtered_address));


				if($address_only){
					echo "<p class='alm-woocommerce-myaccount-address-text'>" . wp_kses_post( $address_only ) . "</p>";
				}

				$postcode = $address_fields['postcode']??'';

				if($postcode){
					echo "<p class='alm-woocommerce-myaccount-address-postcode'>" . esc_html__('کدپستی','alma') . " $postcode</p>";
				}

				$phone = $address_fields['phone']??'';

				if($phone){
					echo "<p class='alm-woocommerce-myaccount-address-phone'>" . esc_html__('تلفن','alma') . " $phone</p>";
				}

				$email = $address_fields['email']??'';

				if($email){
					echo "<p class='alm-woocommerce-myaccount-address-email'>" . esc_html__('آدرس ایمیل ','alma') . " $email</p>";
				}
			}

			/**
			 * Used to output content after core address fields.
			 *
			 * @param string $name Address type.
			 * @since 8.7.0
			 */
			do_action( 'woocommerce_my_account_after_my_address', $name );
			?>
		<?php
			$address_field = ob_get_clean();
			$address_field = trim($address_field);


			if($address_field){
				?>
				<address>
					<?php echo $address_field;;?>
				</address>
				<?php
			}
		?>
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
	<?php
endif;
