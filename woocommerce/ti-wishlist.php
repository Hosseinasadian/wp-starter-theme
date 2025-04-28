<?php
/**
 * The Template for displaying wishlist if a current user is owner.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/ti-wishlist.php.
 *
 * @version             2.3.3
 * @package           TInvWishlist\Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
wp_enqueue_script( 'tinvwl' );

$form_url = tinv_url_wishlist( $wishlist['share_key'], $wl_paged, true );

?>

<div class="tinv-wishlist woocommerce tinv-wishlist-clear">
	<form action="<?php echo esc_url( $form_url ); ?>"
		method="post"
		autocomplete="off"
		data-tinvwl_paged="<?php echo $wl_paged; ?>"
		data-tinvwl_per_page="<?php echo $wl_per_page; ?>"
		data-tinvwl_sharekey="<?php echo $wishlist['share_key'] ?>">

		<div class="alm-archive-products">
			<?php
			foreach ( $products as $wl_product ) {
				$product = $wl_product['data']??null;

				$price_html = alm_wc_price_html($product);
				$currency = get_woocommerce_currency_symbol();
				$discount = alm_wc_discount_percentage($product);
				?>
				<div class="type5 product">
					<div class="archive-product-card-content">
						<?php if($discount){?>
							<div class="alm-product-discount-percentage">
								<?php echo alm_wc_discount_percentage($product)?>
							</div>
						<?php }?>
						<div class="alm-product-first-section">
							<div class="alm-product-images">
								<div class="alm-product-main-image">
									<a href="<?php the_permalink($product->get_id())?>">
												<?php echo $product->get_image() ?>
									</a>
								</div>
								<button type="submit"
										name="tinvwl-remove"
										value="<?php echo esc_attr( $wl_product['ID'] ); ?>"
										title="<?php _e( 'Remove', 'ti-woocommerce-wishlist' ) ?>">
										<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect x="0.5" y="0.500244" width="39" height="39" rx="7.5" stroke="#D5D5D5"/>
											<path d="M20.62 28.8103C20.28 28.9303 19.72 28.9303 19.38 28.8103C16.48 27.8203 10 23.6903 10 16.6903C10 13.6003 12.49 11.1003 15.56 11.1003C17.38 11.1003 18.99 11.9803 20 13.3403C21.01 11.9803 22.63 11.1003 24.44 11.1003C27.51 11.1003 30 13.6003 30 16.6903C30 23.6903 23.52 27.8203 20.62 28.8103Z" fill="#F5683C"/>
										</svg>
								</button>
							</div>
						</div>
						<div class="alm-divider">
							<div class="alm-divider-line"></div>
							<div class="alm-divider-logo-container">
								<svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none"><g id="christianity--religion-jesus-christianity-christ-fish-culture" opacity="0.5" clip-path="url(#clip0_396_12642)"><g id="christianity--religion-jesus-christianity-christ-fish-culture_2"><path id="Vector" d="M7.27922 11.5762C7.27922 11.5762 3.3304 8.43049 3.33041 4.71906C3.32553 3.83745 3.50725 2.97113 3.85553 2.21513C4.20382 1.45913 4.70524 0.842659 5.30481 0.433349C5.90438 0.842659 6.40581 1.45913 6.75409 2.21513C7.10238 2.97113 7.28406 3.83745 7.27922 4.71906C7.27922 8.43049 3.3304 11.5762 3.3304 11.5762" stroke="#8D8D8D" stroke-linecap="round" stroke-linejoin="round"></path></g></g><defs><clipPath id="clip0_396_12642"><rect width="12" height="9.2139" fill="white" transform="translate(9.9117 0.00488281) rotate(90)"></rect></clipPath></defs></svg>
							</div>
							<div class="alm-divider-line"></div>
						</div>
						<div class="alm-product-second-section">
							<a href="<?php the_permalink($product->get_id())?>">
								<h2 class="woocommerce-loop-product__title"><?php echo $product->get_name();?></h2>
							</a>
							<?php
								if ( $price_html || $price_html == '0'){
								?>
								<div class="alm-product-sell-info">
									<a class="alm-add-to-cart add_to_cart_button" href='<?php echo $product->add_to_cart_url() ?>'>
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><g id="vuesax/linear/bag-2"><g id="bag-2"><path id="Vector" d="M7.5 8.59304V7.62304C7.5 5.37304 9.31 3.16304 11.56 2.95304C14.24 2.69304 16.5 4.80304 16.5 7.43304V8.81304" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_2" d="M8.99999 22.923H15C19.02 22.923 19.74 21.313 19.95 19.353L20.7 13.353C20.97 10.913 20.27 8.92303 16 8.92303H7.99999C3.72999 8.92303 3.02999 10.913 3.29999 13.353L4.04999 19.353C4.25999 21.313 4.97999 22.923 8.99999 22.923Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_3" d="M15.4955 12.923H15.5045" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_4" d="M8.49451 12.923H8.50349" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g></g></svg>
									</a>
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
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<?php wp_nonce_field( 'tinvwl_wishlist_owner', 'wishlist_nonce' ); ?>
	</form>
	<div class="tinv-lists-nav tinv-wishlist-clear">
		<?php do_action( 'tinvwl_pagenation_wishlist', $wishlist ); ?>
	</div>
</div>
