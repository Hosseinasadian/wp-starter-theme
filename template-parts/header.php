<?php
$header_type = alm_get_option('header_type');
if($header_type == 'elementor' && $header_template = alm_get_option('alm_header_template')){
	alm_load_elementor_template($header_template);
}else{
	$desktop_logo = alm_get_option('header_desktop_logo');
	$phone_part1 = alm_get_option('header_phone_part1');
	$phone_part2 = alm_get_option('header_phone_part2');

	$account_link = '#';
	$show_otp_modal = !is_user_logged_in() && alm_is_otp_enabled();
	if(is_user_logged_in() || !alm_is_otp_enabled()){
		$user = wp_get_current_user();
		if(function_exists('wc_get_account_endpoint_url') && wc_get_account_endpoint_url('dashboard')){
			$account_link = wc_get_account_endpoint_url('dashboard');
		}
	}

	?>
	<header class="alm-default-site-header">
		<div class="header-top-section">
			<div class="alm-container">
				<div class="alm-post-wrapper">
					<div class="header-top-section-content alm-d-flex alm-flex-row-nowrap alm-align-items-center">
						<div class="alm-d-flex alm-align-items-center">
							<?php if(!empty($desktop_logo['url'])):?>
							<a href="<?php echo home_url();?>">
								<img src="<?php echo $desktop_logo['url'];?>" alt="<?php bloginfo('name')?>">
							</a>
							<?php endif?>
						</div>
						<div class="alm-flex-1">
							<div class="alm-default-advanced-search">
								<form method="get" class="alm-default-search-form">
									<div class="alm-default-search-wrapper alm-d-flex alm-flex-row-nowrap">
										<input type="text"
												class="alm-default-search-box-input alm-flex-1"
												placeholder="نام محصول مورد نظر خود را وارد کنید"
												name="s"
												autocomplete="off">
										<div class="alm-default-divider"></div>
										<button type="submit" class="alm-default-search-submit">
											<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none"><g id="vuesax/linear/search-normal"><g id="search-normal"><path id="Vector" d="M10.1451 18.0694C14.5174 18.0694 18.0618 14.5249 18.0618 10.1527C18.0618 5.78044 14.5174 2.23602 10.1451 2.23602C5.77285 2.23602 2.22844 5.78044 2.22844 10.1527C2.22844 14.5249 5.77285 18.0694 10.1451 18.0694Z" stroke="#8D8D8D" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_2" d="M18.8951 18.9027L17.2284 17.236" stroke="#8D8D8D" stroke-linecap="round" stroke-linejoin="round"></path></g></g></svg>
										</button>
									</div>
								</form>
								<div class="alm-default-search-results alm-hide"></div>
							</div>
						</div>
						<?php if($phone_part1 || $phone_part2):?>
							<div class="header-contact alm-d-flex alm-flex-row-nowrap alm-align-items-center alm-ltr">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><g id="vuesax/linear/call"><g id="call"><g id="call_2"><path id="Vector" d="M21.97 18.83C21.97 19.19 21.89 19.56 21.72 19.92C21.55 20.28 21.33 20.62 21.04 20.94C20.55 21.48 20.01 21.87 19.4 22.12C18.8 22.37 18.15 22.5 17.45 22.5C16.43 22.5 15.34 22.26 14.19 21.77C13.04 21.28 11.89 20.62 10.75 19.79C9.6 18.95 8.51 18.02 7.47 16.99C6.44 15.95 5.51 14.86 4.68 13.72C3.86 12.58 3.2 11.44 2.72 10.31C2.24 9.17 2 8.08 2 7.04C2 6.36 2.12 5.71 2.36 5.11C2.6 4.5 2.98 3.94 3.51 3.44C4.15 2.81 4.85 2.5 5.59 2.5C5.87 2.5 6.15 2.56 6.4 2.68C6.66 2.8 6.89 2.98 7.07 3.24L9.39 6.51C9.57 6.76 9.7 6.99 9.79 7.21C9.88 7.42 9.93 7.63 9.93 7.82C9.93 8.06 9.86 8.3 9.72 8.53C9.59 8.76 9.4 9 9.16 9.24L8.4 10.03C8.29 10.14 8.24 10.27 8.24 10.43C8.24 10.51 8.25 10.58 8.27 10.66C8.3 10.74 8.33 10.8 8.35 10.86C8.53 11.19 8.84 11.62 9.28 12.14C9.73 12.66 10.21 13.19 10.73 13.72C11.27 14.25 11.79 14.74 12.32 15.19C12.84 15.63 13.27 15.93 13.61 16.11C13.66 16.13 13.72 16.16 13.79 16.19C13.87 16.22 13.95 16.23 14.04 16.23C14.21 16.23 14.34 16.17 14.45 16.06L15.21 15.31C15.46 15.06 15.7 14.87 15.93 14.75C16.16 14.61 16.39 14.54 16.64 14.54C16.83 14.54 17.03 14.58 17.25 14.67C17.47 14.76 17.7 14.89 17.95 15.06L21.26 17.41C21.52 17.59 21.7 17.8 21.81 18.05C21.91 18.3 21.97 18.55 21.97 18.83Z" stroke="#F5683C" stroke-width="1.5" stroke-miterlimit="10"></path></g></g></g></svg>
								<div class="alm-default-divider"></div>
								<span class=alm-default-header-phone>
									<?php if($phone_part1):?>
										<span class="alm-default-header-phone-prefix"><?php echo $phone_part1?></span>
										<span class="alm-default-header-phone-divider">_</span>
									<?php endif;?>
									<?php if($phone_part2) echo $phone_part2?>
								</span>
							</div>
						<?php endif;?>

						<div class="header-top-actions">
							<a href="<?php echo $account_link;?>" class="header-top-action header-top-account-action <?php echo $show_otp_modal?'alm-open-otp-modal alm-default-open-otp-modal':'';?>" <?php echo $show_otp_modal?'data-otp':'';?>>
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
									<path d="M10 9.99999C12.3012 9.99999 14.1667 8.13451 14.1667 5.83332C14.1667 3.53214 12.3012 1.66666 10 1.66666C7.69885 1.66666 5.83337 3.53214 5.83337 5.83332C5.83337 8.13451 7.69885 9.99999 10 9.99999Z" stroke="#F5683C" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M17.1583 18.3333C17.1583 15.1083 13.95 12.5 10 12.5C6.05001 12.5 2.84167 15.1083 2.84167 18.3333" stroke="#F5683C" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</a>
							<a class="header-top-action header-top-menu-action alm-open-modal" data-target="#alm-mobile-menu-modal">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
									<path d="M4.16663 8.33332H5.83329C7.49996 8.33332 8.33329 7.49999 8.33329 5.83332V4.16666C8.33329 2.49999 7.49996 1.66666 5.83329 1.66666H4.16663C2.49996 1.66666 1.66663 2.49999 1.66663 4.16666V5.83332C1.66663 7.49999 2.49996 8.33332 4.16663 8.33332Z" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M14.1666 8.33332H15.8333C17.5 8.33332 18.3333 7.49999 18.3333 5.83332V4.16666C18.3333 2.49999 17.5 1.66666 15.8333 1.66666H14.1666C12.5 1.66666 11.6666 2.49999 11.6666 4.16666V5.83332C11.6666 7.49999 12.5 8.33332 14.1666 8.33332Z" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M14.1666 18.3333H15.8333C17.5 18.3333 18.3333 17.5 18.3333 15.8333V14.1667C18.3333 12.5 17.5 11.6667 15.8333 11.6667H14.1666C12.5 11.6667 11.6666 12.5 11.6666 14.1667V15.8333C11.6666 17.5 12.5 18.3333 14.1666 18.3333Z" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M4.16663 18.3333H5.83329C7.49996 18.3333 8.33329 17.5 8.33329 15.8333V14.1667C8.33329 12.5 7.49996 11.6667 5.83329 11.6667H4.16663C2.49996 11.6667 1.66663 12.5 1.66663 14.1667V15.8333C1.66663 17.5 2.49996 18.3333 4.16663 18.3333Z" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>

						<img class="logo-bottom-curve" src="<?php echo trailingslashit(Theme_ROOT_URL) . 'images/logo-bottom-curve.png';?>" alt="">
					</div>
				</div>
			</div>
		</div>
		<div class="header-bottom-section">
			<div class="alm-container">
				<div class="alm-post-wrapper">
					<div class="header-bottom-section-content alm-d-flex alm-justify-content-between alm-align-items-center">
						<div class="header-bottom-section-part-1">

						</div>
						<div class="header-bottom-section-part-2">
							<div class="alm-default-login-minicart">
								<?php echo do_shortcode('[alm_login]')?>
								<?php if(alm_wc_enabled()):?>
									<div class="alm-default-login-minicart-divider"></div>
									<div class="alm-elementor-minicart">
										<div class="alm-card-button">
											<span class="shopping-cart">
												<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><g id="bag"><path id="Vector" d="M9.71906 2.81039L6.09906 6.44039" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_2" d="M16.0991 2.81039L19.7191 6.44039" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_3" d="M2.90906 8.6604C2.90906 6.8104 3.89906 6.6604 5.12906 6.6604H20.6891C21.9191 6.6604 22.9091 6.8104 22.9091 8.6604C22.9091 10.8104 21.9191 10.6604 20.6891 10.6604H5.12906C3.89906 10.6604 2.90906 10.8104 2.90906 8.6604Z" stroke="white" stroke-width="1.5"></path><path id="Vector_4" d="M10.6691 14.8104V18.3604" stroke="white" stroke-width="1.5" stroke-linecap="round"></path><path id="Vector_5" d="M15.269 14.8104V18.3604" stroke="white" stroke-width="1.5" stroke-linecap="round"></path><path id="Vector_6" d="M4.40906 10.8104L5.81906 19.4504C6.13906 21.3904 6.90906 22.8104 9.76906 22.8104H15.7991C18.9091 22.8104 19.3691 21.4504 19.7291 19.5704L21.4091 10.8104" stroke="white" stroke-width="1.5" stroke-linecap="round"></path></g></svg>
											</span>
											<span class="card-count"><?php echo WC()->cart->get_cart_contents_count();?></span>
										</div>
										<div class="alm-minicart alm-hide">
											<?php
											alm_get_mini_cart_content();
											?>
										</div>
									</div>
								<?php endif;?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</header>
	<?php
}
