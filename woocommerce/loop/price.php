<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$price_html = alm_wc_price_html($product);
$currency = get_woocommerce_currency_symbol();

?>

<?php if ( $price_html || $price_html == '0') : ?>
	<div class='alm-archive-product-price-box'>
		<div class='alm-archive-product-price'>
			<?php echo $price_html;?>
		</div>
		<?php if(alm_wc_enable_show_currency($product)):?>
		<div class='alm-archive-product-price-currency'>
			<?php echo $currency;?>
		</div>
		<?php endif;?>
	</div>
<?php endif; ?>
