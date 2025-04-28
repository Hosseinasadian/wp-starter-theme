<?php
$footer_type = alm_get_option('footer_type');

if($footer_type == 'elementor' && $footer_template = alm_get_option('alm_footer_template')){
	alm_load_elementor_template($footer_template);
}else{
	// manual handle footer
	$footer_logo = alm_get_option('footer_logo');

	$footer_introduction = alm_get_option('footer_introduction');
	$footer_list_1_title = alm_get_option('footer_list_1_title');
	$footer_list_1_icon = alm_get_option('footer_list_1_icon');
	$footer_list_1_items = alm_get_option('footer_list_1_items');
	$list_1_items=[];
	if(isset($footer_list_1_items['link_title'])){
		foreach($footer_list_1_items['link_title'] as $index=>$item){
			$list_1_items[]=[
				'link_title'=>$item,
				'link_href'=>$footer_list_1_items['link_href'][$index]??'#'
			];
		}
	}
	$footer_list_2_title = alm_get_option('footer_list_2_title');
	$footer_list_2_icon = alm_get_option('footer_list_2_icon');
	$footer_list_2_items = alm_get_option('footer_list_2_items')??[];
	$list_2_items=[];
	if(isset($footer_list_2_items['link_title'])){
		foreach($footer_list_2_items['link_title'] as $index=>$item){
			$list_2_items[]=[
				'link_title'=>$item,
				'link_href'=>$footer_list_1_items['link_href'][$index]??'#'
			];
		}
	}

	$footer_socials_title = alm_get_option('footer_socials_title');
	$footer_newsletter_title = alm_get_option('footer_newsletter_title');
	$footer_copyright = alm_get_option('footer_copyright');

	$social_icons = [
		'instagram'=>'<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
									<path d="M9.5 22.002H15.5C20.5 22.002 22.5 20.002 22.5 15.002V9.00195C22.5 4.00195 20.5 2.00195 15.5 2.00195H9.5C4.5 2.00195 2.5 4.00195 2.5 9.00195V15.002C2.5 20.002 4.5 22.002 9.5 22.002Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
									<path d="M12.5 15.502C14.433 15.502 16 13.9349 16 12.002C16 10.069 14.433 8.50195 12.5 8.50195C10.567 8.50195 9 10.069 9 12.002C9 13.9349 10.567 15.502 12.5 15.502Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
									<path d="M18.1361 7.00195H18.1477" stroke="#B0B0B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>',
		'youtube'=>'<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
  <path d="M17.5 20.002H7.5C4.5 20.002 2.5 18.002 2.5 15.002V9.00195C2.5 6.00195 4.5 4.00195 7.5 4.00195H17.5C20.5 4.00195 22.5 6.00195 22.5 9.00195V15.002C22.5 18.002 20.5 20.002 17.5 20.002Z" stroke="#B0B0B0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
  <path d="M11.9 9.50177L14.4 11.0018C15.3 11.6018 15.3 12.5018 14.4 13.1018L11.9 14.6018C10.9 15.2018 10.1 14.7018 10.1 13.6018V10.6018C10.1 9.30177 10.9 8.90177 11.9 9.50177Z" stroke="#B0B0B0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>',
		'whatsapp'=>'<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
  <path d="M7.4 20.602C8.9 21.502 10.7 22.002 12.5 22.002C18 22.002 22.5 17.502 22.5 12.002C22.5 6.50195 18 2.00195 12.5 2.00195C7 2.00195 2.5 6.50195 2.5 12.002C2.5 13.802 3 15.502 3.8 17.002L2.94044 20.3079C2.74572 21.0569 3.43892 21.7337 4.18299 21.5211L7.4 20.602Z" stroke="#B0B0B0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
  <path d="M17 14.8505C17 15.0125 16.9639 15.179 16.8873 15.341C16.8107 15.503 16.7116 15.656 16.5809 15.8C16.36 16.043 16.1167 16.2185 15.8418 16.331C15.5714 16.4435 15.2784 16.502 14.9629 16.502C14.5033 16.502 14.012 16.394 13.4937 16.1735C12.9755 15.953 12.4572 15.656 11.9434 15.2825C11.4251 14.9045 10.9339 14.486 10.4652 14.0225C10.001 13.5545 9.58187 13.064 9.20781 12.551C8.83826 12.038 8.54081 11.525 8.32449 11.0165C8.10816 10.5035 8 10.013 8 9.54495C8 9.23895 8.05408 8.94645 8.16224 8.67645C8.27041 8.40195 8.44166 8.14995 8.68052 7.92495C8.96895 7.64145 9.28443 7.50195 9.61793 7.50195C9.74412 7.50195 9.87031 7.52895 9.98297 7.58295C10.1002 7.63695 10.2038 7.71795 10.2849 7.83495L11.3305 9.30645C11.4116 9.41895 11.4702 9.52245 11.5108 9.62145C11.5513 9.71595 11.5739 9.81045 11.5739 9.89595C11.5739 10.004 11.5423 10.112 11.4792 10.2155C11.4206 10.319 11.335 10.427 11.2268 10.535L10.8843 10.8905C10.8348 10.94 10.8122 10.9985 10.8122 11.0705C10.8122 11.1065 10.8167 11.138 10.8257 11.174C10.8393 11.21 10.8528 11.237 10.8618 11.264C10.9429 11.4125 11.0826 11.606 11.2809 11.84C11.4837 12.074 11.7 12.3125 11.9344 12.551C12.1778 12.7895 12.4121 13.01 12.651 13.2125C12.8853 13.4105 13.0791 13.5455 13.2323 13.6265C13.2549 13.6355 13.2819 13.649 13.3135 13.6625C13.3495 13.676 13.3856 13.6805 13.4261 13.6805C13.5028 13.6805 13.5613 13.6535 13.6109 13.604L13.9534 13.2665C14.0661 13.154 14.1743 13.0685 14.2779 13.0145C14.3816 12.9515 14.4852 12.92 14.5979 12.92C14.6835 12.92 14.7737 12.938 14.8728 12.9785C14.972 13.019 15.0756 13.0775 15.1883 13.154L16.68 14.2115C16.7972 14.2925 16.8783 14.387 16.9279 14.4995C16.973 14.612 17 14.7245 17 14.8505Z" stroke="#B0B0B0" stroke-width="1.5" stroke-miterlimit="10"></path>
</svg>',
		'facebook'=>'<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
  <path d="M14.5 9.30195V12.202H17.1C17.3 12.202 17.4 12.402 17.4 12.602L17 14.502C17 14.602 16.8 14.702 16.7 14.702H14.5V22.002H11.5V14.802H9.8C9.6 14.802 9.5 14.702 9.5 14.502V12.602C9.5 12.402 9.6 12.302 9.8 12.302H11.5V9.00195C11.5 7.30195 12.8 6.00195 14.5 6.00195H17.2C17.4 6.00195 17.5 6.10195 17.5 6.30195V8.70195C17.5 8.90195 17.4 9.00195 17.2 9.00195H14.8C14.6 9.00195 14.5 9.10195 14.5 9.30195Z" stroke="#B0B0B0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"></path>
  <path d="M15.5 22.002H9.5C4.5 22.002 2.5 20.002 2.5 15.002V9.00195C2.5 4.00195 4.5 2.00195 9.5 2.00195H15.5C20.5 2.00195 22.5 4.00195 22.5 9.00195V15.002C22.5 20.002 20.5 22.002 15.5 22.002Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>',
		'google'=>'<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
  <path d="M22.1 10.202H12.7V13.902H18.2C18.1 14.802 17.5 16.202 16.2 17.102C15.4 17.702 14.2 18.102 12.7 18.102C10.1 18.102 7.80001 16.402 7.00001 13.902C6.80001 13.302 6.70001 12.602 6.70001 11.902C6.70001 11.202 6.80001 10.502 7.00001 9.90195C7.10001 9.70195 7.10001 9.50195 7.20001 9.40195C8.10001 7.30195 10.2 5.80195 12.7 5.80195C14.6 5.80195 15.8 6.60195 16.6 7.30195L19.4 4.50195C17.7 3.00195 15.4 2.00195 12.7 2.00195C8.80001 2.00195 5.40001 4.20195 3.80001 7.50195C3.10001 8.90195 2.70001 10.402 2.70001 12.002C2.70001 13.602 3.10001 15.102 3.80001 16.502C5.40001 19.802 8.80001 22.002 12.7 22.002C15.4 22.002 17.7 21.102 19.3 19.602C21.2 17.902 22.3 15.302 22.3 12.202C22.3 11.402 22.2 10.802 22.1 10.202Z" stroke="#B0B0B0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>',
	];

	$footer_socials_list = alm_get_option('footer_socials_list');
	$social_lists=[];
	if(isset($footer_socials_list['social_icon'])){
		foreach($footer_socials_list['social_icon'] as $index=>$item){
			$social_item=[
				'link_href'=>$footer_socials_list['social_link'][$index]??'#'
			];
			if($item == 'other'){
				$social_item['link_icon'] = alm_safe_svg($footer_socials_list['social_custom_icon'][$index]??'');
			}else{
				$social_item['link_icon'] = $social_icons[$item]??'';
			}
			$social_lists[]=$social_item;
		}
	}

	$footer_address1 = alm_get_option('footer_address1');
	$footer_address2 = alm_get_option('footer_address2');
	$footer_phone = alm_get_option('footer_phone');
	$footer_phone_text = alm_get_option('footer_phone_text');

	?>
	<footer class="alm-default-site-footer">
		<div class="alm-post-wrapper">
			<div class="alm-footer-main-content">
				<div class="alm-footer-over-layer-wrapper">
					<div class="alm-footer-over-layer">
						<svg class="alm-footer-over-layer-curve" width="177" height="22" viewBox="0 0 177 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_8026_12668)">
							<g filter="url(#filter0_d_8026_12668)">
							<path d="M-874 -68C-874 -86.7777 -858.778 -102 -840 -102H166C184.778 -102 200 -86.7777 200 -68V-18.6878C200 -6.70997 190.29 3 178.312 3H172.776C167.727 3 163.135 5.92455 161 10.5C158.865 15.0754 154.273 18 149.224 18H88.3494H34.5139C28.8825 18 23.6237 15.1856 20.5 10.5C17.3763 5.81441 12.1175 3 6.48615 3H-840C-858.778 3 -874 -12.2223 -874 -31L-874 -68Z" fill="#C1B6DE"/>
							</g>
							</g>
							<defs>
							<filter id="filter0_d_8026_12668" x="-874" y="-102" width="1074" height="124" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
							<feFlood flood-opacity="0" result="BackgroundImageFix"/>
							<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
							<feOffset dy="4"/>
							<feComposite in2="hardAlpha" operator="out"/>
							<feColorMatrix type="matrix" values="0 0 0 0 0.294455 0 0 0 0 0.269792 0 0 0 0 0.4375 0 0 0 1 0"/>
							<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_8026_12668"/>
							<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_8026_12668" result="shape"/>
							</filter>
							<clipPath id="clip0_8026_12668">
							<rect width="177" height="22" fill="white"/>
							</clipPath>
							</defs>
						</svg>
						<?php if(!empty($footer_logo['url'])):?>
							<a href="<?php echo home_url();?>" class="alm-footer-logo">
								<img src="<?php echo $footer_logo['url'];?>" alt="<?php bloginfo('name')?>">
							</a>
						<?php endif;?>
						<div class="alm-footer-informaions">
							<?php if(!empty($footer_address1) || !empty($footer_address2)):?>
							<div class="alm-footer-informaion">
								<svg class="alm-footer-informaion-icon" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
									<path d="M16.2089 18.384C18.5064 18.384 20.3689 16.5215 20.3689 14.224C20.3689 11.9265 18.5064 10.064 16.2089 10.064C13.9114 10.064 12.0489 11.9265 12.0489 14.224C12.0489 16.5215 13.9114 18.384 16.2089 18.384Z" stroke="#373254" stroke-width="1.5"/>
									<path d="M5.03553 11.7974C7.66219 0.250713 24.7689 0.264046 27.3822 11.8107C28.9155 18.584 24.7022 24.3174 21.0089 27.864C18.3289 30.4507 14.0889 30.4507 11.3955 27.864C7.71553 24.3174 3.50219 18.5707 5.03553 11.7974Z" stroke="#373254" stroke-width="1.5"/>
								</svg>
								<div class="alm-footer-informaion-divider"></div>
								<div class="alm-footer-informaion-rows">
									<?php if(!empty($footer_address1)):?>
									<div class="alm-footer-informaion-address1"><?php echo $footer_address1?></div>
									<?php endif;?>
									<?php if(!empty($footer_address2)):?>
									<div class="alm-footer-informaion-address2"><?php echo $footer_address2?></div>
									<?php endif;?>
								</div>
							</div>
							<?php endif;?>
							<?php if(!empty($footer_phone)):?>
							<div class="alm-footer-informaion">
								<svg class="alm-footer-informaion-icon" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
									<path d="M29.7933 24.9174C29.7933 25.3974 29.6867 25.8907 29.46 26.3707C29.2333 26.8507 28.94 27.304 28.5533 27.7307C27.9 28.4507 27.18 28.9707 26.3667 29.304C25.5667 29.6374 24.7 29.8107 23.7667 29.8107C22.4067 29.8107 20.9533 29.4907 19.42 28.8374C17.8867 28.184 16.3533 27.304 14.8333 26.1974C13.3 25.0774 11.8467 23.8374 10.46 22.464C9.08666 21.0774 7.84666 19.624 6.73999 18.104C5.64666 16.584 4.76666 15.064 4.12666 13.5574C3.48666 12.0374 3.16666 10.584 3.16666 9.19738C3.16666 8.29071 3.32666 7.42404 3.64666 6.62404C3.96666 5.81071 4.47332 5.06404 5.17999 4.39738C6.03332 3.55738 6.96666 3.14404 7.95332 3.14404C8.32666 3.14404 8.69999 3.22404 9.03332 3.38404C9.37999 3.54404 9.68666 3.78404 9.92666 4.13071L13.02 8.49071C13.26 8.82404 13.4333 9.13071 13.5533 9.42404C13.6733 9.70404 13.74 9.98404 13.74 10.2374C13.74 10.5574 13.6467 10.8774 13.46 11.184C13.2867 11.4907 13.0333 11.8107 12.7133 12.1307L11.7 13.184C11.5533 13.3307 11.4867 13.504 11.4867 13.7174C11.4867 13.824 11.5 13.9174 11.5267 14.024C11.5667 14.1307 11.6067 14.2107 11.6333 14.2907C11.8733 14.7307 12.2867 15.304 12.8733 15.9974C13.4733 16.6907 14.1133 17.3974 14.8067 18.104C15.5267 18.8107 16.22 19.464 16.9267 20.064C17.62 20.6507 18.1933 21.0507 18.6467 21.2907C18.7133 21.3174 18.7933 21.3574 18.8867 21.3974C18.9933 21.4374 19.1 21.4507 19.22 21.4507C19.4467 21.4507 19.62 21.3707 19.7667 21.224L20.78 20.224C21.1133 19.8907 21.4333 19.6374 21.74 19.4774C22.0467 19.2907 22.3533 19.1974 22.6867 19.1974C22.94 19.1974 23.2067 19.2507 23.5 19.3707C23.7933 19.4907 24.1 19.664 24.4333 19.8907L28.8467 23.024C29.1933 23.264 29.4333 23.544 29.58 23.8774C29.7133 24.2107 29.7933 24.544 29.7933 24.9174Z" stroke="#373254" stroke-width="1.5" stroke-miterlimit="10"/>
									<path d="M25.1667 12.4772C25.1667 11.6772 24.54 10.4505 23.6067 9.45055C22.7533 8.53055 21.62 7.81055 20.5 7.81055" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M29.8333 12.4774C29.8333 7.31738 25.66 3.14404 20.5 3.14404" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<div class="alm-footer-informaion-divider"></div>
								<div class="alm-footer-informaion-rows">
									<div class="alm-footer-informaion-phone"><?php echo $footer_phone?></div>
									<?php if(!empty($footer_phone_text)):?>
									<div class="alm-footer-informaion-phone-text"><?php echo $footer_phone_text?></div>
									<?php endif;?>
								</div>
							</div>
							<?php endif;?>
						</div>
					</div>
				</div>

				<div class="alm-footer-main-part-1">
					<?php if($footer_introduction):?>
						<div class="alm-footer-introduction"><?php echo $footer_introduction?></div>
					<?php endif;?>
				</div>
				<div class="alm-footer-main-part-2">
					<div class="alm-footer-list">
						<h5 class="alm-footer-list-title">
							<?php if($footer_list_1_icon && !empty($footer_list_1_icon['url'])):?>
								<img src="<?php echo $footer_list_1_icon['url'];?>" alt="<?php echo $footer_list_1_title??'';?>"/>
							<?php endif;?>
							<?php echo $footer_list_1_title??'';?>
						</h5>
						<ul>
							<?php foreach($list_1_items as $item):?>
								<li>
									<a href="<?php echo $item['link_href'];?>"><?php echo $item['link_title'];?></a>
								</li>
							<?php endforeach;?>
						</ul>
					</div>
					<div class="alm-footer-list">
						<h5 class="alm-footer-list-title">
							<?php if($footer_list_2_icon && !empty($footer_list_2_icon['url'])):?>
								<img src="<?php echo $footer_list_2_icon['url'];?>" alt="<?php echo $footer_list_2_title??'';?>"/>
							<?php endif;?>
							<?php echo $footer_list_2_title??'';?>
						</h5>
						<ul>
							<?php foreach($list_2_items as $item):?>
								<li>
									<a href="<?php echo $item['link_href'];?>"><?php echo $item['link_title'];?></a>
								</li>
							<?php endforeach;?>
						</ul>
					</div>
				</div>
				<div class="alm-footer-main-part-3">
					<h5 class="alm-footer-socials-title"><?php echo $footer_socials_title??'';?></h5>
					<ul class="alm-footer-socials-list">
						<?php foreach($social_lists as $social):?>
						<li>
							<a href="<?php echo $social['link_href']?>">
								<?php echo $social['link_icon'];?>
							</a>
						</li>
						<?php endforeach;?>
					</ul>
					<h5 class="alm-default-newsletter"><?php echo $footer_newsletter_title??'';?></h5>
					<form class="alm-default-newsletter-form alm-d-flex alm-flex-column-wrap">
                		<div class="alm-default-newsletter-content-area alm-d-flex alm-flex-row-nowrap alm-align-items-center">
                    		<input class="alm-flex-1 alm-ignore-outline alm-w-10px" type="text" name="contact" autocomplete="off" required="" placeholder="عضویت در خبرنامه آلما">
							<div class="alm-default-newsletter-form-divider"></div>
							<button class="alm-d-flex alm-flex-row-wrap alm-align-items-center"><?php esc_html_e('ثبت','alma')?></button>
                		</div>
                		<div class="alm-newsletter-message alm-hide"></div>
            		</form>
				</div>
				<div class="alm-footer-main-bottom">
					<h6 class="alm-footer-copyright"><?php echo $footer_copyright??'';?></h6>
				</div>
			</div>
		</div>
	</footer>
	<?php
}
