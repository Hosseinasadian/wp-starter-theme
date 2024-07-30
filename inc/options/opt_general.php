<?php
Redux::set_section(
	$opt_name,
	array(
		'title' => esc_html__('عمومی', 'starter-theme'),
		'id' => 'general',
		'icon' => 'el el-home',
		'fields' => array(
			array(
				'id' => 'content_width',
				'type' => 'slider',
				'title' => __('عرض سایت', 'starter-theme'),
				'subtitle' => __('عرض سایت را انتخاب کنید', 'starter-theme'),
				"default" => 1140,
				"min" => 700,
				"step" => 20,
				"max" => 1400,
				'display_value' => 'text'
			)
		)
	)
);
