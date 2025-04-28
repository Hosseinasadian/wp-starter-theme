<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="alm-section related products">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<header class="alm-section-header">
				<h2 class="alm-section-header-title"><?php echo esc_html( $heading ); ?></h2>
				<a href="<?php echo wc_get_page_permalink( 'shop' );?>" class="alm-section-header-link">
					<?php esc_html_e('مشاهده همه','alma')?>
					<svg xmlns="http://www.w3.org/2000/svg" width="34" height="28" viewBox="0 0 34 28" fill="none">
						<path opacity="0.15" d="M22.3863 26.3335C28.8005 26.3335 34.0002 20.9609 34.0002 14.3335C34.0002 7.70608 28.8005 2.3335 22.3863 2.3335C15.9722 2.3335 10.7725 7.70608 10.7725 14.3335C10.7725 20.9609 15.9722 26.3335 22.3863 26.3335Z" fill="#F5683C"/>
						<path d="M14.1386 25.6668C20.6457 25.6668 25.9208 20.4435 25.9208 14.0002C25.9208 7.55684 20.6457 2.3335 14.1386 2.3335C7.63151 2.3335 2.35645 7.55684 2.35645 14.0002C2.35645 20.4435 7.63151 25.6668 14.1386 25.6668Z" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M18.2622 14H11.1929" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M13.5493 10.5L10.0146 14L13.5493 17.5" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
			</header>
		<?php endif; ?>

		<?php woocommerce_product_loop_start(); ?>

		<?php
			$current_id = get_the_ID();
			$slider_settings = [
				'navigation'=>[
					"nextEl" => '.swiper-button-next.swiper-button-next-related-' . $current_id,
					"prevEl" => '.swiper-button-prev.swiper-button-prev-related-' . $current_id,
					"enabled" => false
				],
				'slidesPerView'=>1.3,
				'spaceBetween'=>16,
				'rtl'=>is_rtl(),
				'centeredSlides'=>true,
				'centeredSlidesBounds'=>true,
				'watchSlidesProgress'=>true,
				'breakpoints'=>[
					'1024'=>[
						'slidesPerView'=>4,
						'navigation'=>[
							"nextEl" => '.swiper-button-next.swiper-button-next-related-' . $current_id,
							"prevEl" => '.swiper-button-prev.swiper-button-prev-related-' . $current_id,
							"enabled" => true
						],
					],
					'720'=>[
						'slidesPerView'=>3,
						'navigation'=>[
							"nextEl" => '.swiper-button-next.swiper-button-next-related-' . $current_id,
							"prevEl" => '.swiper-button-prev.swiper-button-prev-related-' . $current_id,
							"enabled" => true
						],
					],
					'600'=>[
						'slidesPerView'=>2.5,
					]
				]

			];
		?>
			<div class="slider-wrapper">
				<div class="swiper alm-swiper" data-settings='<?php echo json_encode($slider_settings) ?>'>
					<div class="swiper-wrapper">
						<?php foreach ( $related_products as $related_product ) : ?>

								<?php
								$post_object = get_post( $related_product->get_id() );

								setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

								echo "<div class='swiper-slide'>";

								wc_get_template_part( 'content', 'product' );

								echo "</div>";
								?>
						<?php endforeach; ?>
					</div>
					<div class="swiper-button-prev swiper-button-prev-related-<?php echo $current_id?>"></div>
					<div class="swiper-button-next swiper-button-next-related-<?php echo $current_id?>"></div>
				</div>
			</div>

		<?php woocommerce_product_loop_end(); ?>

	</section>
	<?php
endif;

wp_reset_postdata();
