<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$icons = [
	'bacs'=>'<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
  <path d="M3 12.75H19.5" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M9 24.75H12" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M15.75 24.75H21.75" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M33 16.995V24.165C33 29.43 31.665 30.75 26.34 30.75H9.66C4.335 30.75 3 29.43 3 24.165V11.835C3 6.57002 4.335 5.25 9.66 5.25H19.92" stroke="#B9B9B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M25.5 4.875H30.195C31.23 4.875 32.07 5.82 32.07 6.75C32.07 7.785 31.23 8.625 30.195 8.625H25.5V4.875Z" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M25.5 8.625H30.855C32.04 8.625 33 9.465 33 10.5C33 11.535 32.04 12.375 30.855 12.375H25.5V8.625Z" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M28.1406 12.375V14.25" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M28.1406 3V4.875" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M27.285 4.875H24" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M27.285 12.375H24" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	'cheque'=>'<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
  <path d="M3 12.75H19.5" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M9 24.75H12" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M15.75 24.75H21.75" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M33 16.995V24.165C33 29.43 31.665 30.75 26.34 30.75H9.66C4.335 30.75 3 29.43 3 24.165V11.835C3 6.57002 4.335 5.25 9.66 5.25H19.92" stroke="#B9B9B9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M25.5 4.875H30.195C31.23 4.875 32.07 5.82 32.07 6.75C32.07 7.785 31.23 8.625 30.195 8.625H25.5V4.875Z" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M25.5 8.625H30.855C32.04 8.625 33 9.465 33 10.5C33 11.535 32.04 12.375 30.855 12.375H25.5V8.625Z" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M28.1406 12.375V14.25" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M28.1406 3V4.875" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M27.285 4.875H24" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M27.285 12.375H24" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	'cod'=>'<svg xmlns="http://www.w3.org/2000/svg" width="37" height="36" viewBox="0 0 37 36" fill="none">
  <path d="M3.5 33H33.5" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M4.92578 33L5.00079 14.955C5.00079 14.04 5.43578 13.1701 6.15578 12.6001L16.6558 4.42504C17.7358 3.58504 19.2508 3.58504 20.3458 4.42504L30.8458 12.585C31.5808 13.155 32.0008 14.025 32.0008 14.955V33" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linejoin="round"/>
  <path d="M23.75 16.5H13.25C12.005 16.5 11 17.505 11 18.75V33H26V18.75C26 17.505 24.995 16.5 23.75 16.5Z" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M15.5 24.375V26.625" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M16.25 11.25H20.75" stroke="#B9B9B9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
</svg>'
];
$icons = apply_filters('alm_woocommerce_payment_shipping_icon',$icons);

?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	<p class="alm-wc_payment_method-image">
		<label class="<?php echo $gateway->chosen?'selected-payment':''?>">
			<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
		</label>
		<?php
			$gateway_id = esc_attr( $gateway->id );
			if(isset($icons[$gateway_id])){
				echo alm_safe_svg($icons[$gateway_id]);
			}
		?>
	</p>


	<div class="alm-wc_payment_method-text">
		<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
			<?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> <?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
		</label>
		<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
			<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
				<?php $gateway->payment_fields(); ?>
			</div>
		<?php endif; ?>
	</div>

</li>
