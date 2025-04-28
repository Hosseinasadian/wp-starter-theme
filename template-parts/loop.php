<?php
$time_diff = human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );
?>
<div class="alm-post-card">
	<div class="alm-post-card-header">
		<a class="alm-post-img-link" href="<?php the_permalink(); ?>">
			<img src="<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>"
					alt="<?php echo get_the_title() ?>"/>
		</a>
	</div>
	<div class="alm-post-card-body">
		<div class="alm-post-card-title-time">
			<h3 class="alm-post-card-title">
				<a href="<?php the_permalink(); ?>">
					<?php the_title() ?>
				</a>
			</h3>
			<?php if($time_diff){?>
				<div class="alm-post-card-time"><?php echo $time_diff?></div>
			<?php }?>
		</div>
	</div>
</div>
