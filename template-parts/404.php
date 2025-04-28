<div class="alm-content">
	<?php
	alm_enabled_breadcrumb() && alm_breadcrumb();
	$image = alm_get_option('404_image');
	$show_prev_button = alm_get_option('404_show_prev_button');
	$show_home_button = alm_get_option('404_show_home_button');
	$message = alm_get_option('404_message');
	?>
	<div class='alm-404-content'>
		<div class='alm-404-image'>
			<?php if($image && !empty($image['id'])):?>
				<?php echo wp_get_attachment_image($image['id'],'full')?>
			<?php else:?>
				<img src="<?php echo Theme_ROOT_URL . '/images/404.png';?>" alt='404'/>
			<?php endif;?>
		</div>
		<div class="alm-404-title">
			<?php echo $message?$message: __('این صفحه یافت نشد.','alma');?>
		</div>
		<?php if($show_home_button || $show_prev_button):?>
		<div class="alm-404-buttons">
			<?php if($show_prev_button): ?>
				<button class="prev-button" onclick='javascript:history.back()'><?php echo __('صفحه قبل','alma')?></button>
			<?php endif;?>
			<?php if($show_home_button): ?>
				<a class="home-button" href="<?php echo esc_url(home_url())?>"><?php echo __('صفحه اصلی','alma')?></a>
			<?php endif;?>
		</div>
		<?php endif;?>
	</div>
</div>
