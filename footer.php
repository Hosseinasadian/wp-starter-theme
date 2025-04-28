<?php
// Elementor `footer` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	get_template_part( 'template-parts/footer' );
}

?>
</div>

<?php
if(alm_is_otp_enabled() && !is_user_logged_in()){
	$otp_modal_logo = alm_get_option('otp_modal_logo');
	$custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image( $custom_logo_id , 'full' );
	?>
		<div class="alm-otp-modal alm-hide" id="alm-otp-modal">
			<div class="alm-otp-modal-body">
				<button class="alm-otp-modal-close-button">
					<svg xmlns="http://www.w3.org/2000/svg" width="34" height="35" viewBox="0 0 34 35" fill="none">
 					 	<path d="M12.728 21.7132L21.2133 13.2279" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
 					 	<path d="M21.2133 21.7132L12.728 13.2279" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</button>
				<div class="alm-otp-modal-content">
					<?php if(!empty($otp_modal_logo['url'])){?>
						<div class="alm-otp-logo"><img src="<?php echo $otp_modal_logo['url'];?>" alt="<?php bloginfo('name')?>"></div>
					<?php }?>
					<div class="alm-otp-wrapper">
						<?php echo alm_otp_form_step_1_template();?>
					</div>
				</div>
			</div>
		</div>
	<?php
}

$mobile_logo = alm_get_option('header_mobile_logo');
$phone_part1 = alm_get_option('header_phone_part1');
$phone_part2 = alm_get_option('header_phone_part2');
$header_support_text = alm_get_option('header_support_text');

?>

<div class="alm-modal-wrapper alm-hide" id="alm-mobile-menu-modal">
	<div class="alm-modal">
		<?php if(!empty($mobile_logo['url'])):?>
			<div class="alm-modal-header">
				<div class="alm-d-flex alm-align-items-center">
					<a href="<?php echo home_url();?>">
						<img src="<?php echo $mobile_logo['url'];?>" alt="<?php bloginfo('name')?>">
					</a>
				</div>
			</div>
		<?php endif?>
		<div class="alm-modal-body">
			<?php almRenderMobileMenu('primary');?>
		</div>
		<?php if($phone_part1 || $phone_part2):?>
		<div class="alm-modal-footer">
			<div class="alm-mobile-menu-support-phone-wrapper alm-d-flex alm-flex-row-nowrap alm-align-items-center alm-justify-content-center">
				<div class="alm-d-flex alm-flex-column-wrap alm-justify-content-center">
					<div class="alm-mobile-menu-support-phone">
					<?php if($phone_part1):?>
						<span class="alm-mobile-menu-support-phone-prefix"><?php echo $phone_part1?></span>
						<span class="alm-mobile-menu-support-phone-divider">_</span>
					<?php endif;?>
					<?php if($phone_part2) echo $phone_part2?>
					</div>
					<?php if($header_support_text):?>
						<div class="alm-mobile-menu-support-text"><?php echo $header_support_text;?></div>
					<?php endif;?>
				</div>
				<svg xmlns="http://www.w3.org/2000/svg" width="35" height="36" viewBox="0 0 35 36" fill="none">
					<path d="M25.4479 33.6771C23.8 33.6771 22.0645 33.2833 20.2708 32.525C18.5208 31.7812 16.7562 30.7604 15.0354 29.5208C13.3291 28.2667 11.6812 26.8667 10.1208 25.3354C8.57496 23.775 7.17496 22.1271 5.93538 20.4354C4.68121 18.6854 3.67496 16.9354 2.96038 15.2437C2.20204 13.4354 1.82288 11.6854 1.82288 10.0375C1.82288 8.89999 2.02704 7.82082 2.42079 6.81457C2.82913 5.77916 3.48538 4.81666 4.37496 3.98541C5.49788 2.87707 6.78121 2.32291 8.15204 2.32291C8.72079 2.32291 9.30413 2.45416 9.79996 2.68749C10.3687 2.94999 10.85 3.34374 11.2 3.86874L14.5833 8.63749C14.8895 9.06041 15.1229 9.46874 15.2833 9.87707C15.4729 10.3146 15.575 10.7521 15.575 11.175C15.575 11.7292 15.4145 12.2687 15.1083 12.7792C14.8895 13.1729 14.5541 13.5958 14.1312 14.0187L13.1395 15.0542C13.1541 15.0979 13.1687 15.1271 13.1833 15.1562C13.3583 15.4625 13.7083 15.9875 14.3791 16.775C15.0937 17.5917 15.7645 18.3354 16.4354 19.0208C17.2958 19.8667 18.0104 20.5375 18.6812 21.0917C19.5125 21.7917 20.052 22.1417 20.3729 22.3021L20.3437 22.375L21.4083 21.325C21.8604 20.8729 22.2979 20.5375 22.7208 20.3187C23.5229 19.8229 24.5437 19.7354 25.5645 20.1583C25.9437 20.3187 26.352 20.5375 26.7895 20.8437L31.6312 24.2854C32.1708 24.65 32.5645 25.1167 32.7979 25.6708C33.0166 26.225 33.1187 26.7354 33.1187 27.2458C33.1187 27.9458 32.9583 28.6458 32.652 29.3021C32.3458 29.9583 31.9666 30.5271 31.4854 31.0521C30.6541 31.9708 29.75 32.6271 28.7 33.05C27.6937 33.4583 26.6 33.6771 25.4479 33.6771ZM8.15204 4.51041C7.34996 4.51041 6.60621 4.86041 5.89163 5.56041C5.22079 6.18749 4.75413 6.87291 4.46246 7.61666C4.15621 8.37499 4.01038 9.17707 4.01038 10.0375C4.01038 11.3937 4.33121 12.8667 4.97288 14.3833C5.62913 15.9292 6.54788 17.5333 7.71454 19.1375C8.88121 20.7417 10.2083 22.3021 11.6666 23.775C13.125 25.2187 14.7 26.5604 16.3187 27.7417C17.8937 28.8937 19.5125 29.8271 21.1166 30.4979C23.6104 31.5625 25.9437 31.8104 27.8687 31.0083C28.6125 30.7021 29.2687 30.2354 29.8666 29.5646C30.202 29.2 30.4645 28.8062 30.6833 28.3396C30.8583 27.975 30.9458 27.5958 30.9458 27.2167C30.9458 26.9833 30.902 26.75 30.7854 26.4875C30.7416 26.4 30.6541 26.2396 30.377 26.05L25.5354 22.6083C25.2437 22.4042 24.9812 22.2583 24.7333 22.1562C24.4125 22.025 24.2812 21.8937 23.7854 22.2C23.4937 22.3458 23.2312 22.5646 22.9395 22.8562L21.8312 23.95C21.2625 24.5042 20.3875 24.6354 19.7166 24.3875L19.3229 24.2125C18.725 23.8917 18.025 23.3958 17.252 22.7396C16.552 22.1417 15.7937 21.4417 14.875 20.5375C14.1604 19.8083 13.4458 19.0354 12.702 18.175C12.0166 17.3729 11.5208 16.6875 11.2145 16.1187L11.0395 15.6812C10.952 15.3458 10.9229 15.1562 10.9229 14.9521C10.9229 14.4271 11.1125 13.9604 11.477 13.5958L12.5708 12.4583C12.8625 12.1667 13.0812 11.8896 13.227 11.6417C13.3437 11.4521 13.3875 11.2917 13.3875 11.1458C13.3875 11.0292 13.3437 10.8542 13.2708 10.6792C13.1687 10.4458 13.0083 10.1833 12.8041 9.90624L9.42079 5.12291C9.27496 4.91874 9.09996 4.77291 8.88121 4.67082C8.64788 4.56874 8.39996 4.51041 8.15204 4.51041ZM20.3437 22.3896L20.1104 23.3812L20.5041 22.3604C20.4312 22.3458 20.3729 22.3604 20.3437 22.3896Z" fill="#373254"/>
					<path d="M26.9792 14.7188C26.3812 14.7188 25.8854 14.2229 25.8854 13.625C25.8854 13.1 25.3604 12.0063 24.4854 11.0729C23.625 10.1542 22.6771 9.61459 21.875 9.61459C21.2771 9.61459 20.7812 9.11876 20.7812 8.52084C20.7812 7.92293 21.2771 7.42709 21.875 7.42709C23.2896 7.42709 24.7771 8.18543 26.075 9.57084C27.2854 10.8688 28.0729 12.4583 28.0729 13.625C28.0729 14.2229 27.5771 14.7188 26.9792 14.7188Z" fill="#373254"/>
					<path d="M32.0833 14.7187C31.4854 14.7187 30.9896 14.2229 30.9896 13.625C30.9896 8.59374 26.9062 4.51041 21.875 4.51041C21.2771 4.51041 20.7812 4.01457 20.7812 3.41666C20.7812 2.81874 21.2771 2.32291 21.875 2.32291C28.1021 2.32291 33.1771 7.39791 33.1771 13.625C33.1771 14.2229 32.6812 14.7187 32.0833 14.7187Z" fill="#373254"/>
				</svg>
			</div>
		</div>
		<?php endif;?>
	</div>
</div>

<?php

wp_footer();
?>

</body>
</html>
